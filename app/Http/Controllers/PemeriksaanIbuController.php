<?php

namespace App\Http\Controllers;

use App\Models\PemeriksaanIbu;
use Illuminate\Http\Request;
use Mpdf\Mpdf;

class PemeriksaanIbuController extends Controller
{
    public function cetakKartu($id)
    {
        $pemeriksaan = PemeriksaanIbu::with(['ibu', 'bidan'])->findOrFail($id);

        $html = view('pemeriksaan-ibu.kms-ibu-pdf', compact('pemeriksaan'))->render();

        $mpdf = new Mpdf();
        $mpdf->WriteHTML($html);
        $mpdf->Output('kartu-pemeriksaan-ibu-' . $pemeriksaan->ibu->nama_lengkap . '.pdf', 'I');
    }

    public function cetakLaporan()
    {
        $data = PemeriksaanIbu::with(['ibu', 'bidan'])->get();

        $total = $data->count();
        $avgBerat = $data->avg(fn($p) => floatval($p->berat_badan));
        $avgTinggi = $data->avg(fn($p) => floatval($p->tinggi_badan));
        $avgUsiaKehamilan = $data->avg('usia_kehamilan');

        $html = view('pemeriksaan-ibu.laporan-ibu-pdf', compact('data', 'total', 'avgBerat', 'avgTinggi', 'avgUsiaKehamilan'))->render();

        $mpdf = new Mpdf(['orientation' => 'L']);
        $mpdf->WriteHTML($html);
        $mpdf->Output('laporan-pemeriksaan-ibu.pdf', 'I');
    }
}
