<?php

namespace App\Http\Controllers;

use App\Models\Bandara;
use App\Models\Inspeksi;
use App\Models\Laporan;
use App\Models\Petugas;
use App\Models\Temuan;
use App\Models\TindakLanjut;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $bandaraId = $request->filled('bandara_id')
            ? $request->integer('bandara_id')
            : null;

        $tahun = $request->filled('tahun')
            ? $request->integer('tahun')
            : null;


        /*
        |--------------------------------------------------------------------------
        | Kategori Status Dashboard
        |--------------------------------------------------------------------------
        |
        | Status teknis tetap disimpan sesuai proses inspeksi/audit.
        | Dashboard mengelompokkan menjadi:
        | - Belum selesai : Open + Unsatisfactory
        | - Selesai        : Close + Satisfactory
        |
        */
        $statusBelumSelesai = [
            'Open',
            'Unsatisfactory',
        ];

        $statusSelesai = [
            'Close',
            'Satisfactory',
        ];

        /*
        |--------------------------------------------------------------------------
        | Fungsi filter temuan
        |--------------------------------------------------------------------------
        |
        | Filter ini dipakai ulang pada seluruh statistik agar angka dashboard,
        | tabel, grafik, dan daftar prioritas selalu konsisten.
        |
        */
        $filterTemuan = function (Builder $query) use ($bandaraId, $tahun) {
            $query->when(
                $bandaraId || $tahun,
                function (Builder $query) use ($bandaraId, $tahun) {
                    $query->whereHas(
                        'inspeksi',
                        function (Builder $inspeksiQuery) use ($bandaraId, $tahun) {
                            $inspeksiQuery
                                ->when(
                                    $bandaraId,
                                    fn (Builder $query) =>
                                        $query->where('bandara_id', $bandaraId)
                                )
                                ->when(
                                    $tahun,
                                    fn (Builder $query) =>
                                        $query->whereYear('tanggal', $tahun)
                                );
                        }
                    );
                }
            );
        };

        /*
        |--------------------------------------------------------------------------
        | Ringkasan utama
        |--------------------------------------------------------------------------
        */
        $jumlahBandara = Bandara::query()
            ->when(
                $bandaraId,
                fn (Builder $query) => $query->whereKey($bandaraId)
            )
            ->count();

        $jumlahPetugas = Petugas::count();

        $jumlahLaporan = Laporan::query()
            ->when(
                $bandaraId,
                fn (Builder $query) =>
                    $query->where('bandara_id', $bandaraId)
            )
            ->when(
                $tahun,
                fn (Builder $query) =>
                    $query->whereYear('tanggal_surat', $tahun)
            )
            ->count();

        $jumlahInspeksi = Inspeksi::query()
            ->when(
                $bandaraId,
                fn (Builder $query) =>
                    $query->where('bandara_id', $bandaraId)
            )
            ->when(
                $tahun,
                fn (Builder $query) =>
                    $query->whereYear('tanggal', $tahun)
            )
            ->count();

        $jumlahTemuan = Temuan::query()
            ->tap($filterTemuan)
            ->count();

        $temuanOpen = Temuan::query()
            ->tap($filterTemuan)
            ->whereIn('status', $statusBelumSelesai)
            ->count();

        $temuanClose = Temuan::query()
            ->tap($filterTemuan)
            ->whereIn('status', $statusSelesai)
            ->count();

        $persentaseSelesai = $jumlahTemuan > 0
            ? round(($temuanClose / $jumlahTemuan) * 100)
            : 0;

        /*
        |--------------------------------------------------------------------------
        | Risiko
        |--------------------------------------------------------------------------
        */
        $risikoRendah = Temuan::query()
            ->tap($filterTemuan)
            ->where('tingkat_risiko', 'Rendah')
            ->count();

        $risikoTinggi = Temuan::query()
            ->tap($filterTemuan)
            ->where('tingkat_risiko', 'Tinggi')
            ->count();

        $persentaseOpen = $jumlahTemuan > 0
            ? round(($temuanOpen / $jumlahTemuan) * 100)
            : 0;

        $persentaseClose = $jumlahTemuan > 0
            ? round(($temuanClose / $jumlahTemuan) * 100)
            : 0;

        $totalRisiko = $risikoRendah + $risikoTinggi;

        $persentaseRisikoRendah = $totalRisiko > 0
            ? round(($risikoRendah / $totalRisiko) * 100)
            : 0;

        $persentaseRisikoTinggi = $totalRisiko > 0
            ? round(($risikoTinggi / $totalRisiko) * 100)
            : 0;

        /*
        |--------------------------------------------------------------------------
        | Tindak lanjut lewat deadline
        |--------------------------------------------------------------------------
        */
        $filterTindakLanjut = function (Builder $query) use ($bandaraId, $tahun) {
            $query->when(
                $bandaraId || $tahun,
                function (Builder $query) use ($bandaraId, $tahun) {
                    $query->whereHas(
                        'temuan.inspeksi',
                        function (Builder $inspeksiQuery) use ($bandaraId, $tahun) {
                            $inspeksiQuery
                                ->when(
                                    $bandaraId,
                                    fn (Builder $query) =>
                                        $query->where('bandara_id', $bandaraId)
                                )
                                ->when(
                                    $tahun,
                                    fn (Builder $query) =>
                                        $query->whereYear('tanggal', $tahun)
                                );
                        }
                    );
                }
            );
        };

        /*
        |--------------------------------------------------------------------------
        | Monitoring status tindak lanjut pada temuan Open
        |--------------------------------------------------------------------------
        */
        $queryMonitoringTindakLanjut = function () use ($filterTindakLanjut) {
            return TindakLanjut::query()
                ->tap($filterTindakLanjut);
        };

        $jumlahTindakLanjutAktif = $queryMonitoringTindakLanjut()
            ->count();

        /*
        |--------------------------------------------------------------------------
        | Monitoring penyelesaian temuan
        |--------------------------------------------------------------------------
        |
        | Perhitungan dilakukan berdasarkan jumlah temuan, bukan jumlah baris
        | tindak lanjut. Temuan Open masuk kategori Open dan temuan Close masuk
        | kategori Close.
        |
        */
        $tindakLanjutOpen = Temuan::query()
            ->tap($filterTemuan)
            ->whereIn('status', $statusBelumSelesai)
            ->count();

        $tindakLanjutClose = Temuan::query()
            ->tap($filterTemuan)
            ->whereIn('status', $statusSelesai)
            ->count();

        $jumlahTindakLanjutAktif =
            $tindakLanjutOpen + $tindakLanjutClose;

        $persentaseTindakLanjutClose = $jumlahTindakLanjutAktif > 0
            ? round(
                ($tindakLanjutClose / $jumlahTindakLanjutAktif) * 100
            )
            : 0;

        $tindakLanjutOverdue = TindakLanjut::query()
            ->tap($filterTindakLanjut)
            ->whereHas('temuan', function (Builder $query) use ($statusBelumSelesai) {
                $query->whereIn('status', $statusBelumSelesai);
            })
            ->whereNotNull('deadline')
            ->whereDate('deadline', '<', now()->toDateString())
            ->where('status', '!=', 'Selesai')
            ->count();

        $tindakLanjutMendesak = TindakLanjut::query()
            ->with('temuan.inspeksi.bandara')
            ->tap($filterTindakLanjut)
            ->whereHas('temuan', function (Builder $query) use ($statusBelumSelesai) {
                $query->whereIn('status', $statusBelumSelesai);
            })
            ->whereNotNull('deadline')
            ->where('status', '!=', 'Selesai')
            ->orderBy('deadline')
            ->take(8)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Bandara dengan temuan terbanyak
        |--------------------------------------------------------------------------
        */
        $bandaraTerbanyak = Bandara::query()
            ->when(
                $bandaraId,
                fn (Builder $query) => $query->whereKey($bandaraId)
            )
            ->with([
                'inspeksis' => function ($query) use ($tahun) {
                    $query
                        ->when(
                            $tahun,
                            fn ($query) =>
                                $query->whereYear('tanggal', $tahun)
                        )
                        ->with('temuans');
                },
            ])
            ->get()
            ->map(function (Bandara $bandara) use (
                $statusBelumSelesai,
                $statusSelesai
            ) {

                $temuans = $bandara->inspeksis
                    ->flatMap(
                        fn (Inspeksi $inspeksi) =>
                            $inspeksi->temuans
                    );

                $bandara->jumlah_temuan = $temuans->count();

                $bandara->jumlah_open = $temuans
                    ->whereIn('status', $statusBelumSelesai)
                    ->count();

                $bandara->jumlah_close = $temuans
                    ->whereIn('status', $statusSelesai)
                    ->count();

                return $bandara;
            })
            ->sortByDesc('jumlah_temuan')
            ->take(5)
            ->values();


        /*
        |--------------------------------------------------------------------------
        | Executive Insight
        |--------------------------------------------------------------------------
        */

        // Risiko tinggi yang belum Close
        $executiveRisikoTinggi = Temuan::query()
            ->tap($filterTemuan)
            ->where('tingkat_risiko', 'Tinggi')
            ->whereIn('status', $statusBelumSelesai)
            ->count();


        // Temuan Open / Unsatisfactory
        $executiveOpenUnsatisfactory = Temuan::query()
            ->tap($filterTemuan)
            ->whereIn('status', $statusBelumSelesai)
            ->count();


        // Temuan overdue berdasarkan due_date
        $totalOverdue = Temuan::query()
            ->tap($filterTemuan)
            ->whereNotNull('due_date')
            ->whereDate('due_date', '<', now()->toDateString())
            ->whereIn('status', $statusBelumSelesai)
            ->count();


        // Bandara dengan temuan aktif terbanyak
        $bandaraAktifTerbanyak = Bandara::query()
            ->with([
                'inspeksis.temuans'
            ])
            ->get()
            ->map(function (Bandara $bandara) use ($statusBelumSelesai) {

                $temuanAktif = $bandara->inspeksis
                    ->flatMap(
                        fn (Inspeksi $inspeksi) =>
                            $inspeksi->temuans
                    )
                    ->whereIn('status', $statusBelumSelesai);

                $bandara->jumlah_temuan_aktif =
                    $temuanAktif->count();

                return $bandara;
            })
            ->sortByDesc('jumlah_temuan_aktif')
            ->take(5)
            ->values();


        /*
        |--------------------------------------------------------------------------
        | Temuan terbaru dan prioritas
        |--------------------------------------------------------------------------
        */
        $temuanTerbaru = Temuan::query()
            ->with('inspeksi.bandara')
            ->tap($filterTemuan)
            ->latest()
            ->take(5)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Top 5 Temuan Prioritas Dashboard
        |--------------------------------------------------------------------------
        |
        | Urutan:
        | 1. Overdue paling lama
        | 2. Jatuh tempo hari ini
        | 3. Due <= 7 hari
        | 4. Risiko tinggi belum Close
        |
        */


        $topTemuanPrioritas = Temuan::query()
            ->with('inspeksi.bandara')
            ->tap($filterTemuan)
            ->whereIn('status', $statusBelumSelesai)
            ->whereNotNull('due_date')
            ->get()
            ->map(function (Temuan $temuan) {

                $today = now()->startOfDay();
                $dueDate = \Carbon\Carbon::parse($temuan->due_date);

                if ($dueDate->lt($today)) {

                    $temuan->priority_score = 1;

                } elseif ($dueDate->equalTo($today)) {

                    $temuan->priority_score = 2;

                } elseif ($dueDate->lte($today->copy()->addDays(7))) {

                    $temuan->priority_score = 3;

                } elseif ($temuan->tingkat_risiko === 'Tinggi') {

                    $temuan->priority_score = 4;

                } else {

                    $temuan->priority_score = 5;

                }

                return $temuan;

            })
            ->sort(function ($a, $b) {

                if ($a->priority_score === $b->priority_score) {

                    if ($a->priority_score === 1) {
                        return $a->due_date <=> $b->due_date;
                    }

                    return $a->due_date <=> $b->due_date;
                }

                return $a->priority_score <=> $b->priority_score;

            })
            ->take(5)
            ->values();




        /*
        |--------------------------------------------------------------------------
        | Data grafik temuan bulanan
        |--------------------------------------------------------------------------
        |
        | Temuan dikelompokkan berdasarkan bulan pelaksanaan inspeksi.
        | Data tetap mengikuti filter bandara dan tahun pada dashboard.
        |
        */
        $labelBulan = [
            'Jan',
            'Feb',
            'Mar',
            'Apr',
            'Mei',
            'Jun',
            'Jul',
            'Agu',
            'Sep',
            'Okt',
            'Nov',
            'Des',
        ];

        $dataTemuanBulanan = array_fill(0, 12, 0);
        $dataTemuanOpenBulanan = array_fill(0, 12, 0);
        $dataTemuanCloseBulanan = array_fill(0, 12, 0);

        Temuan::query()
            ->with('inspeksi:id,tanggal')
            ->tap($filterTemuan)
            ->get()
            ->each(function (Temuan $temuan) use (
                &$dataTemuanBulanan,
                &$dataTemuanOpenBulanan,
                &$dataTemuanCloseBulanan,
                $statusBelumSelesai,
                $statusSelesai
            ) {
                if (! $temuan->inspeksi?->tanggal) {
                    return;
                }

                $indexBulan = $temuan->inspeksi->tanggal->month - 1;

                $dataTemuanBulanan[$indexBulan]++;

                if (in_array($temuan->status, $statusBelumSelesai)) {
                    $dataTemuanOpenBulanan[$indexBulan]++;
                }

                if (in_array($temuan->status, $statusSelesai)) {
                    $dataTemuanCloseBulanan[$indexBulan]++;
                }
            });

        /*
        |--------------------------------------------------------------------------
        | Data grafik temuan adaptif
        |--------------------------------------------------------------------------
        */
        $temuanGrafik = Temuan::query()
            ->with('inspeksi:id,tanggal')
            ->tap($filterTemuan)
            ->get();

        if ($tahun) {
            $labelGrafikTemuan = [
                'Jan',
                'Feb',
                'Mar',
                'Apr',
                'Mei',
                'Jun',
                'Jul',
                'Agu',
                'Sep',
                'Okt',
                'Nov',
                'Des',
            ];

            $dataTemuanOpenGrafik = array_fill(0, 12, 0);
            $dataTemuanCloseGrafik = array_fill(0, 12, 0);

            foreach ($temuanGrafik as $temuan) {
                if (! $temuan->inspeksi?->tanggal) {
                    continue;
                }

                $indexGrafik = $temuan->inspeksi->tanggal->month - 1;

                if (in_array($temuan->status, $statusBelumSelesai)) {
                    $dataTemuanOpenGrafik[$indexGrafik]++;
                }

                if (in_array($temuan->status, $statusSelesai)) {
                    $dataTemuanCloseGrafik[$indexGrafik]++;
                }
            }
        } else {
            $labelGrafikTemuan = $temuanGrafik
                ->filter(
                    fn (Temuan $temuan) =>
                        $temuan->inspeksi?->tanggal !== null
                )
                ->map(
                    fn (Temuan $temuan) =>
                        (string) $temuan->inspeksi->tanggal->year
                )
                ->unique()
                ->sort()
                ->values()
                ->all();

            $dataTemuanOpenGrafik = array_fill(
                0,
                count($labelGrafikTemuan),
                0
            );

            $dataTemuanCloseGrafik = array_fill(
                0,
                count($labelGrafikTemuan),
                0
            );

            foreach ($temuanGrafik as $temuan) {
                if (! $temuan->inspeksi?->tanggal) {
                    continue;
                }

                $tahunTemuan = (string) $temuan->inspeksi->tanggal->year;

                $indexGrafik = array_search(
                    $tahunTemuan,
                    $labelGrafikTemuan,
                    true
                );

                if ($indexGrafik === false) {
                    continue;
                }

                if (in_array($temuan->status, $statusBelumSelesai)) {
                    $dataTemuanOpenGrafik[$indexGrafik]++;
                }

                if (in_array($temuan->status, $statusSelesai)) {
                    $dataTemuanCloseGrafik[$indexGrafik]++;
                }
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Pilihan filter
        |--------------------------------------------------------------------------
        */
        $daftarBandara = Bandara::query()
            ->orderBy('nama_bandara')
            ->get();

        $daftarTahun = Inspeksi::query()
            ->whereNotNull('tanggal')
            ->selectRaw('DISTINCT CAST(strftime("%Y", tanggal) AS INTEGER) AS tahun')
            ->orderByDesc('tahun')
            ->pluck('tahun');

        $bandaraTerpilih = $bandaraId
            ? $daftarBandara->firstWhere('id', $bandaraId)
            : null;

        return view('dashboard.index', compact(
            'jumlahBandara',
            'jumlahPetugas',
            'jumlahInspeksi',
            'jumlahTemuan',
            'jumlahLaporan',
            'temuanOpen',
            'temuanClose',
            'persentaseSelesai',
            'risikoRendah',
            'risikoTinggi',
            'persentaseOpen',
            'persentaseClose',
            'persentaseRisikoRendah',
            'persentaseRisikoTinggi',
            'jumlahTindakLanjutAktif',
            'tindakLanjutOpen',
            'tindakLanjutClose',
            'persentaseTindakLanjutClose',
            'tindakLanjutOverdue',
            'tindakLanjutMendesak',
            'bandaraTerbanyak',
            'executiveRisikoTinggi',
            'executiveOpenUnsatisfactory',
            'totalOverdue',
            'bandaraAktifTerbanyak',
            'temuanTerbaru',
            'topTemuanPrioritas',
            'daftarBandara',
            'daftarTahun',
            'bandaraId',
            'tahun',
            'bandaraTerpilih',
            'labelGrafikTemuan',
            'dataTemuanOpenGrafik',
            'dataTemuanCloseGrafik',
            'dataTemuanCloseBulanan'
        ));
    }
}
