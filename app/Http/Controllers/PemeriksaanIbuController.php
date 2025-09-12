<?php

namespace App\Http\Controllers;

use App\Models\PemeriksaanIbu;
use Carbon\Carbon;
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

    public function cetakLaporan(Request $request)
    {
        // Get the selected month from the request (this should be passed via the URL)
        $bulan = (int)$request->input('bulan', now()->format('m')); // Default bulan sekarang
        $tahun = (int)$request->input('tahun', now()->format('Y'));


        // Log the received month for debugging
        \Log::info('Bulan dan Tahun yang diterima di controller:', ['bulan' => $bulan, 'tahun' => $tahun]);

        // Get the current year to calculate the start and end dates
        $year = Carbon::now()->year;

        // Get the start and end dates of the selected month
        $startDate = Carbon::createFromDate($tahun, $bulan, 1)->startOfMonth();
        $endDate = $startDate->copy()->endOfMonth();

        // Log the start and end dates for debugging
        \Log::info('Start and End Dates:', [
            'start_date' => $startDate->toDateString(),
            'end_date' => $endDate->toDateString(),
        ]);

        // Query the data for the selected month
        $data = PemeriksaanIbu::with(['ibu', 'bidan'])
            ->whereBetween('tanggal_pemeriksaan', [$startDate, $endDate])
            ->get();

        $total = $data->count();
        $avgBerat = $data->avg(fn($p) => floatval($p->berat_badan));
        $avgTinggi = $data->avg(fn($p) => floatval($p->tinggi_badan));
        $avgUsiaKehamilan = $data->avg('usia_kehamilan');

        // Render the HTML view for the report
        $html = view('pemeriksaan-ibu.laporan-ibu-pdf', compact('data', 'total', 'avgBerat', 'avgTinggi', 'avgUsiaKehamilan', 'bulan'))->render();

        // Generate PDF using mPDF
        $mpdf = new Mpdf(['orientation' => 'L']);
        $mpdf->WriteHTML($html);
        $mpdf->Output('laporan-pemeriksaan-ibu.pdf', 'I');
    }
}
