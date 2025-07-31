<?php

namespace App\Http\Controllers;

use App\Models\PemeriksaanAnak;
use Illuminate\Http\Request;
use Mpdf\Mpdf;

class PemeriksaanAnakController extends Controller
{
    public function cetakKMS($id)
    {
        $pemeriksaan = PemeriksaanAnak::with(['anak', 'bidan', 'imunisasi', 'vitamin'])->findOrFail($id);

        $html = view('generate-pdf.kms-anak-pdf', compact('pemeriksaan'))->render();

        $mpdf = new Mpdf();
        $mpdf->WriteHTML($html);
        $mpdf->Output('kms-' . $pemeriksaan->anak->nama . '.pdf', 'I');
    }
    public function cetakLaporan()
    {
        $data = PemeriksaanAnak::with(['anak', 'bidan', 'imunisasi', 'vitamin'])->get();

        // Statistik
        $total = $data->count();
        $avgBerat = $data->avg('berat_badan');
        $minUsia = $data->min('usia_balita');
        $maxUsia = $data->max('usia_balita');

        $html = view('generate-pdf.laporan-anak-pdf', compact('data', 'total', 'avgBerat', 'minUsia', 'maxUsia'))->render();

        $mpdf = new Mpdf(['orientation' => 'L']); // Lanskap untuk tabel lebar
        $mpdf->WriteHTML($html);
        $mpdf->Output('laporan-pemeriksaan-anak.pdf', 'I');
    }
}
