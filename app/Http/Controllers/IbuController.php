<?php

namespace App\Http\Controllers;

use App\Models\Ibu;
use Illuminate\Http\Request;
use Mpdf\Mpdf;

class IbuController extends Controller
{
    public function cetak($id)
    {
        // Cek apakah ibu ada
        $ibu = Ibu::with(['pemeriksaanIbu' => function ($query) {
            $query->with(['bidan']);
        }])->find($id);

        if (!$ibu) {
            return abort(404, 'Ibu tidak ditemukan.');
        }

        // Pastikan ibu memiliki pemeriksaan
        if ($ibu->pemeriksaanIbu->isEmpty()) {
            return abort(404, 'Riwayat pemeriksaan untuk ibu ini tidak ditemukan.');
        }

        // Render HTML untuk PDF
        $html = view('pemeriksaan-ibu.laporan-pemeriksaan', compact('ibu'))->render();

        // Inisialisasi mPDF dan generate PDF
        $mpdf = new Mpdf();
        $mpdf->WriteHTML($html);
        $mpdf->Output('laporan-pemeriksaan-' . $ibu->nama_lengkap . '.pdf', 'I');
    }
}
