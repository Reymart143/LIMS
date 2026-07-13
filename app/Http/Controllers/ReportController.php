<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Http;

class ReportController extends Controller
{
    public function payments(Request $request){
        $year = $request->year ?? date('Y');
        $month = $request->month;
        $dateFrom = $request->date_from;
        $dateTo = $request->date_to;

        $query = DB::table('lf_06_02')
            ->join('clients', 'lf_06_02.user_id', '=', 'clients.id')
            ->leftJoin('lf_06_04', 'lf_06_02.id', '=', 'lf_06_04.lf_06_02_id');
        if ($year) {
            $query->whereYear('lf_06_02.date_payment', $year);
        }
        if ($month) {
            $query->whereMonth('lf_06_02.date_payment', $month);
        }
        if ($dateFrom && $dateTo) {
            $query->whereBetween('lf_06_02.date_payment', [
                $dateFrom,
                $dateTo
            ]);
        }

        $records = $query->select(
            'lf_06_02.user_id',
            'lf_06_02.payment',
            'lf_06_02.date_payment'
        )->get();

        $totalCustomers = $records->pluck('user_id')->unique()->count();

        $totalPayments = DB::table('lf_06_02')
            ->when($year, function ($q) use ($year) {
                $q->whereYear('date_payment', $year);
            })
            ->when($month, function ($q) use ($month) {
                $q->whereMonth('date_payment', $month);
            })
            ->when($dateFrom && $dateTo, function ($q) use ($dateFrom, $dateTo) {
                $q->whereBetween('date_payment', [$dateFrom, $dateTo]);
            })
            ->sum(DB::raw("CAST(REPLACE(payment, ',', '') AS DECIMAL(15,2))"));
        $monthlyData = DB::table('lf_06_02')
            ->selectRaw("
                MONTH(date_payment) as month,
                COUNT(DISTINCT user_id) as total_customers,
                SUM(CAST(REPLACE(payment, ',', '') AS DECIMAL(15,2))) as total_payments
            ")
            ->when($year, function ($q) use ($year) {
                $q->whereYear('date_payment', $year);
            })
            ->when($month, function ($q) use ($month) {
                $q->whereMonth('date_payment', $month);
            })
            ->when($dateFrom && $dateTo, function ($q) use ($dateFrom, $dateTo) {
                $q->whereBetween('date_payment', [$dateFrom, $dateTo]);
            })
            ->groupByRaw('MONTH(date_payment)')
            ->orderByRaw('MONTH(date_payment)')
            ->get();

            $months = [
                1 => 'Jan',
                2 => 'Feb',
                3 => 'Mar',
                4 => 'Apr',
                5 => 'May',
                6 => 'Jun',
                7 => 'Jul',
                8 => 'Aug',
                9 => 'Sep',
                10 => 'Oct',
                11 => 'Nov',
                12 => 'Dec'
            ];

        $report = [];

        foreach ($months as $number => $name) {

            $row = $monthlyData->firstWhere('month', $number);

            $report[] = [
                'month' => $name,
                'customers' => $row->total_customers ?? 0,
                'payments' => $row->total_payments ?? 0
            ];
        }

        return view('Reports.payments', compact(
            'report',
            'year',
            'month',
            'dateFrom',
            'dateTo',
            'totalCustomers',
            'totalPayments'
        ));
    }
    private function getAddressFromCoordinates($coordinates)
    {
        if (empty($coordinates)) {
            return 'N/A';
        }

        [$lat, $lng] = explode(',', $coordinates);

        $response = Http::get(
            'https://nominatim.openstreetmap.org/reverse',
            [
                'lat' => trim($lat),
                'lon' => trim($lng),
                'format' => 'jsonv2'
            ]
        );

        if ($response->successful()) {
            return $response->json()['display_name'] ?? 'Unknown Location';
        }

        return 'Unknown Location';
    }
   public function customers(Request $request)
{
    $year = $request->year;
    $month = $request->month;

    $query = DB::table('clients');

    if ($year) {
        $query->whereYear('created_at', $year);
    }

    if ($month) {
        $query->whereMonth('created_at', $month);
    }

    $customers = $query
        ->select(
            'id',
            'company_name',
            'address',
            'contact_no',
            'created_at'
        )
        ->orderBy('created_at', 'desc')
        ->get();

    foreach ($customers as $customer) {

        $customer->resolved_address = 'N/A';

        if (!empty($customer->address) && str_contains($customer->address, ',')) {

            try {

                [$lat, $lng] = explode(',', $customer->address);

                $response = Http::withHeaders([
                    'User-Agent' => 'Laravel Application'
                ])->get('https://nominatim.openstreetmap.org/reverse', [
                    'lat' => trim($lat),
                    'lon' => trim($lng),
                    'format' => 'jsonv2'
                ]);

                if ($response->successful()) {

                    $data = $response->json();

                    $customer->resolved_address =
                        $data['display_name'] ?? $customer->address;
                }

            } catch (\Exception $e) {

                $customer->resolved_address = $customer->address;
            }
        }
    }

    $totalCustomers = $customers->count();

    return view(
        'Reports.customers',
        compact(
            'customers',
            'totalCustomers'
        )
    );
}
}
