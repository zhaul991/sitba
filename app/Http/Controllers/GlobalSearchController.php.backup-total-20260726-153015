<?php

namespace App\Http\Controllers;

use App\Models\Bandara;
use App\Models\Inspeksi;
use App\Models\Laporan;
use App\Models\Temuan;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GlobalSearchController extends Controller
{
    public function __invoke(Request $request)
    {
        $rawQuery = trim((string) $request->query('q', ''));

        if ($rawQuery === '') {
            return response()->json($this->emptyResponse());
        }

        [$keyword, $tahun] = $this->parseSearchQuery($rawQuery);

        /*
         * Bandara tidak mempunyai konteks tahun.
         * Karena itu Bandara hanya dicari apabila masih ada keyword
         * setelah angka tahun dipisahkan.
         */
        $bandara = collect();

        if ($keyword !== '') {
            $bandara = Bandara::query()
                ->where(function (Builder $query) use ($keyword) {
                    $query
                        ->where('nama_bandara', 'like', "%{$keyword}%")
                        ->orWhere('kode_bandara', 'like', "%{$keyword}%");
                })
                ->limit(5)
                ->get()
                ->map(function (Bandara $bandara) {
                    return [
                        'id' => $bandara->id,
                        'judul' => $bandara->nama_bandara,
                        'keterangan' => $bandara->kode_bandara ?: 'Bandara',
                        'tahun' => null,
                        'url' => route('bandara.show', $bandara),
                    ];
                });
        }

        $inspeksi = Inspeksi::query()
            ->with('bandara')
            ->when($tahun, function (Builder $query, int $tahun) {
                $query->whereYear('tanggal', $tahun);
            })
            ->when($keyword !== '', function (Builder $query) use ($keyword) {
                $query->where(function (Builder $searchQuery) use ($keyword) {
                    $searchQuery
                        ->where('tanggal', 'like', "%{$keyword}%")
                        ->orWhere('keterangan', 'like', "%{$keyword}%")
                        ->orWhereHas(
                            'bandara',
                            function (Builder $bandaraQuery) use ($keyword) {
                                $bandaraQuery
                                    ->where(
                                        'nama_bandara',
                                        'like',
                                        "%{$keyword}%"
                                    )
                                    ->orWhere(
                                        'kode_bandara',
                                        'like',
                                        "%{$keyword}%"
                                    );
                            }
                        );
                });
            })
            ->latest('tanggal')
            ->limit(5)
            ->get()
            ->map(function (Inspeksi $inspeksi) {
                $tanggal = $inspeksi->tanggal
                    ? $inspeksi->tanggal
                        ->locale('id')
                        ->translatedFormat('d F Y')
                    : 'Tanggal tidak tersedia';

                $keterangan = filled($inspeksi->keterangan)
                    ? Str::limit($inspeksi->keterangan, 70)
                    : 'Tanpa keterangan inspeksi';

                $namaBandara = $inspeksi->bandara?->nama_bandara
                    ?? 'Bandara tidak tersedia';

                return [
                    'id' => $inspeksi->id,
                    'judul' => "Inspeksi {$tanggal}",
                    'keterangan' => "{$keterangan} • {$namaBandara}",
                    'tahun' => $inspeksi->tanggal?->year,
                    'url' => route('inspeksi.show', $inspeksi),
                ];
            });

        $temuan = Temuan::query()
            ->with('inspeksi.bandara')
            ->when($tahun, function (Builder $query, int $tahun) {
                $query->whereHas(
                    'inspeksi',
                    function (Builder $inspeksiQuery) use ($tahun) {
                        $inspeksiQuery->whereYear('tanggal', $tahun);
                    }
                );
            })
            ->when($keyword !== '', function (Builder $query) use ($keyword) {
                $query->where(function (Builder $searchQuery) use ($keyword) {
                    $searchQuery
                        ->where('nomor_temuan', 'like', "%{$keyword}%")
                        ->orWhere('uraian_temuan', 'like', "%{$keyword}%")
                        ->orWhere('unsur_elemen', 'like', "%{$keyword}%")
                        ->orWhere('lokasi', 'like', "%{$keyword}%")
                        ->orWhere('tingkat_risiko', 'like', "%{$keyword}%")
                        ->orWhere('status', 'like', "%{$keyword}%")
                        ->orWhereHas(
                            'inspeksi.bandara',
                            function (Builder $bandaraQuery) use ($keyword) {
                                $bandaraQuery
                                    ->where(
                                        'nama_bandara',
                                        'like',
                                        "%{$keyword}%"
                                    )
                                    ->orWhere(
                                        'kode_bandara',
                                        'like',
                                        "%{$keyword}%"
                                    );
                            }
                        );
                });
            })
            ->latest()
            ->limit(5)
            ->get()
            ->map(function (Temuan $temuan) {
                $ringkasan = filled($temuan->uraian_temuan)
                    ? Str::limit($temuan->uraian_temuan, 75)
                    : (
                        filled($temuan->unsur_elemen)
                            ? Str::limit($temuan->unsur_elemen, 75)
                            : 'Uraian temuan tidak tersedia'
                    );

                $namaBandara = $temuan->inspeksi?->bandara?->nama_bandara
                    ?? 'Bandara tidak tersedia';

                return [
                    'id' => $temuan->id,
                    'judul' => $temuan->nomor_temuan,
                    'keterangan' => "{$ringkasan} • {$namaBandara}",
                    'tahun' => $temuan->inspeksi?->tanggal?->year,
                    'risiko' => $temuan->tingkat_risiko,
                    'status' => $temuan->status,
                    'url' => route('temuan.show', $temuan),
                ];
            });

        $laporan = Laporan::query()
            ->with('bandara')
            ->when($tahun, function (Builder $query, int $tahun) {
                $query->whereYear('tanggal_surat', $tahun);
            })
            ->when($keyword !== '', function (Builder $query) use ($keyword) {
                $query->where(function (Builder $searchQuery) use ($keyword) {
                    $searchQuery
                        ->where('nomor_surat', 'like', "%{$keyword}%")
                        ->orWhere('perihal', 'like', "%{$keyword}%")
                        ->orWhere('keterangan', 'like', "%{$keyword}%")
                        ->orWhereHas(
                            'bandara',
                            function (Builder $bandaraQuery) use ($keyword) {
                                $bandaraQuery
                                    ->where(
                                        'nama_bandara',
                                        'like',
                                        "%{$keyword}%"
                                    )
                                    ->orWhere(
                                        'kode_bandara',
                                        'like',
                                        "%{$keyword}%"
                                    );
                            }
                        );
                });
            })
            ->latest('tanggal_surat')
            ->limit(5)
            ->get()
            ->map(function (Laporan $laporan) {
                $perihal = filled($laporan->perihal)
                    ? Str::limit($laporan->perihal, 75)
                    : 'Perihal tidak tersedia';

                $namaBandara = $laporan->bandara?->nama_bandara
                    ?? 'Bandara tidak tersedia';

                return [
                    'id' => $laporan->id,
                    'judul' => $laporan->nomor_surat,
                    'keterangan' => "{$perihal} • {$namaBandara}",
                    'tahun' => $laporan->tanggal_surat?->year,
                    'url' => route('laporan.show', $laporan),
                ];
            });

        return response()->json([
            'meta' => [
                'query_asli' => $rawQuery,
                'keyword' => $keyword,
                'tahun' => $tahun,
            ],
            'bandara' => $bandara,
            'inspeksi' => $inspeksi,
            'temuan' => $temuan,
            'laporan' => $laporan,
        ]);
    }

    /**
     * Memisahkan angka tahun dari keyword.
     *
     * Contoh:
     * "2024 runway" -> ["runway", 2024]
     * "runway 2024" -> ["runway", 2024]
     * "2024"        -> ["", 2024]
     */
    private function parseSearchQuery(string $query): array
    {
        $tahun = null;

        if (preg_match('/\b((?:19|20)\d{2})\b/', $query, $matches)) {
            $candidate = (int) $matches[1];

            if ($candidate >= 1900 && $candidate <= 2099) {
                $tahun = $candidate;
            }
        }

        $keyword = preg_replace(
            '/\b(?:19|20)\d{2}\b/',
            ' ',
            $query,
            1
        );

        $keyword = preg_replace('/\s+/', ' ', (string) $keyword);
        $keyword = trim($keyword);

        return [$keyword, $tahun];
    }

    private function emptyResponse(): array
    {
        return [
            'meta' => [
                'query_asli' => '',
                'keyword' => '',
                'tahun' => null,
            ],
            'bandara' => [],
            'inspeksi' => [],
            'temuan' => [],
            'laporan' => [],
        ];
    }
}
