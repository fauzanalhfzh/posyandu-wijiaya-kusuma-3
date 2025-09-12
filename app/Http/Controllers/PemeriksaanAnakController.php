<?php

namespace App\Http\Controllers;

use App\Models\PemeriksaanAnak;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Mpdf\Mpdf;

class PemeriksaanAnakController extends Controller
{
    public function cetakKMS($id)
    {
        $pemeriksaan = PemeriksaanAnak::with(['anak', 'bidan', 'imunisasi', 'vitamin'])->findOrFail($id);

        $html = view('pemeriksaan-anak.kms-anak-pdf', compact('pemeriksaan'))->render();

        $mpdf = new Mpdf();
        $mpdf->WriteHTML($html);
        $mpdf->Output('kms-' . $pemeriksaan->anak->nama . '.pdf', 'I');
    }

    public function cetakLaporan(Request $request)
    {
        // Tangkap bulan dan tahun dari URL (jika tidak ada, gunakan bulan dan tahun saat ini)
        $bulan = (int)$request->input('bulan', now()->format('m')); // Default bulan sekarang
        $tahun = (int)$request->input('tahun', now()->format('Y')); // Default tahun sekarang

        // Log untuk memeriksa bulan dan tahun yang diterima di controller
        \Log::info('Bulan dan Tahun yang diterima di controller:', ['bulan' => $bulan, 'tahun' => $tahun]);

        // Menghitung tanggal mulai dan selesai berdasarkan bulan dan tahun yang dipilih
        $startDate = Carbon::createFromDate($tahun, $bulan, 1)->startOfMonth();
        $endDate = $startDate->copy()->endOfMonth();

        // Log untuk memeriksa tanggal mulai dan selesai
        \Log::info('Tanggal Mulai dan Selesai:', [
            'start_date' => $startDate->toDateString(),
            'end_date' => $endDate->toDateString(),
        ]);

        // Query data pemeriksaan anak berdasarkan bulan dan tahun yang dipilih
        $data = PemeriksaanAnak::with(['anak', 'bidan', 'imunisasi', 'vitamin'])
            ->whereBetween('tanggal_pemeriksaan', [$startDate, $endDate])
            ->get();

        // Statistik
        $total = $data->count();
        $avgBerat = $data->avg('berat_badan');
        $minUsia = $data->min('usia_balita');
        $maxUsia = $data->max('usia_balita');

        // Render HTML untuk laporan
        $html = view('pemeriksaan-anak.laporan-anak-pdf', compact('data', 'total', 'avgBerat', 'minUsia', 'maxUsia', 'bulan', 'tahun'))->render();

        // Generate PDF dengan mPDF
        $mpdf = new Mpdf(['orientation' => 'L']); // Lanskap untuk tabel lebar
        $mpdf->WriteHTML($html);
        $mpdf->Output('laporan-pemeriksaan-anak.pdf', 'I');
    }
}
