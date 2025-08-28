<?php

namespace App\Http\Controllers;

use App\Models\Anak;
use Illuminate\Http\Request;
use Mpdf\Mpdf;

class AnakController extends Controller
{
    public function cetak($id)
    {
        // Ambil data anak berdasarkan ID
        $anak = Anak::with(['pemeriksaanAnak' => function ($query) {
            $query->with(['bidan', 'imunisasi', 'vitamin']);
        }])
            ->findOrFail($id); // Ambil data anak beserta pemeriksaannya

        // Pastikan anak memiliki pemeriksaan
        if ($anak->pemeriksaanAnak->isEmpty()) {
            return abort(404, 'Riwayat pemeriksaan untuk anak ini tidak ditemukan.');
        }

        // Render HTML untuk PDF
        $html = view('pemeriksaan-anak.laporan-pemeriksaan', compact('anak'))->render();

        // Inisialisasi mPDF dan generate PDF
        $mpdf = new Mpdf();
        $mpdf->WriteHTML($html);
        $mpdf->Output('laporan-pemeriksaan-' . $anak->nama_lengkap . '.pdf', 'I');
    }
}
