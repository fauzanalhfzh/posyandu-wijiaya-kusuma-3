<?php

namespace App\Http\Controllers;

use App\Models\Ibu;
use Illuminate\Http\Request;

class IbuController extends Controller
{
    public function cetak($id)
    {
        // Ambil data ibu berdasarkan ID
        $ibu = Ibu::with('pemeriksaanIbu') // Only eager load 'pemeriksaanIbu' relationship
            ->findOrFail($id); // Get the 'Ibu' data along with the associated 'PemeriksaanIbu' records

        // Pastikan ibu memiliki pemeriksaan
        if ($ibu->pemeriksaanIbu->isEmpty()) {
            return abort(404, 'Riwayat pemeriksaan untuk ibu ini tidak ditemukan.');
        }

        // Render HTML untuk PDF
        $html = view('pemeriksaan-ibu.laporan-pemeriksaan-ibu', compact('ibu'))->render();

        // Inisialisasi mPDF dan generate PDF
        $mpdf = new \Mpdf\Mpdf(['orientation' => 'L']);
        $mpdf->WriteHTML($html);
        $mpdf->Output('laporan-pemeriksaan-ibu-' . $ibu->nama_lengkap . '.pdf', 'I');
    }
}
