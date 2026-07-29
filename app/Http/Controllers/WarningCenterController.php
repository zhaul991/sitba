<?php

namespace App\Http\Controllers;

use App\Models\Temuan;

class WarningCenterController extends Controller
{
    public function index()
    {

        /*
        |--------------------------------------------------------------------------
        | Temuan Warning
        |--------------------------------------------------------------------------
        */

        $temuanOverdue = Temuan::with([
                'inspeksi.bandara'
            ])
            ->where('status', 'Open')
            ->whereNotNull('due_date')
            ->whereDate('due_date', '<', now())
            ->latest()
            ->get();


        $temuanMenahun = Temuan::with([
                'inspeksi.bandara'
            ])
            ->where('status', 'Open')
            ->where('created_at', '<', now()->subYear())
            ->latest()
            ->get();


        $risikoTinggi = Temuan::with([
                'inspeksi.bandara'
            ])
            ->where('tingkat_risiko', 'Tinggi')
            ->latest()
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Profil Risiko
        |--------------------------------------------------------------------------
        */

        $jumlahRisikoTinggi = Temuan::where(
            'tingkat_risiko',
            'Tinggi'
        )->count();


        $jumlahRisikoSedang = Temuan::where(
            'tingkat_risiko',
            'Sedang'
        )->count();


        $jumlahRisikoRendah = Temuan::where(
            'tingkat_risiko',
            'Rendah'
        )->count();


        return view('warning-center.index', compact(
            'temuanOverdue',
            'temuanMenahun',
            'risikoTinggi',
            'jumlahRisikoTinggi',
            'jumlahRisikoSedang',
            'jumlahRisikoRendah'
        ));

    }
}
