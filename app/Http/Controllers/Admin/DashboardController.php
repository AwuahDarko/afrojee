<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\VisitLog;        // your logger model
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{
    public function index()
    {
        $this_month_order_count = Order::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->where('payment_status', 'paid')
            ->count();

        $total_orders = Order::whereYear('created_at', now()->year)
            ->where('payment_status', 'paid')
            ->count();

        $this_month_payment_count = Payment::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $total_sales_this_month = Payment::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('amount');

        $total_sales = $total_sales_this_month = Payment::whereYear('created_at', now()->year)
            ->sum('amount');


        $orders = Order::with(['billingAddress'])->orderBy('id', 'desc')->limit(20)->get();
        $payments = Payment::with('order')->orderBy('id', 'desc')->limit(20)->get();

        $visit_data = $this->visitsThisWeekChart();
        $sales_data = $this->ordersAmountThisYearChart();


        return view(
            'backend.dashboard',
            compact(
                'this_month_order_count',
                'orders',
                'this_month_payment_count',
                'payments',
                'total_sales_this_month',
                'total_sales',
                'total_orders',
                'visit_data',
                'sales_data'
            )
        );
    }


    public function visitsThisWeekChart(): array
    {
        // 1️⃣  Define the week range (00:00 Monday → 23:59:59 Sunday)
        $start = Carbon::now()->startOfWeek(Carbon::MONDAY);
        $end = Carbon::now()->endOfWeek(Carbon::SUNDAY);

        // 2️⃣  Pull counts, grouped by day‑of‑week, with one query
        //     MySQL: DAYOFWEEK() returns 1=Sun…7=Sat
        //     PostgreSQL: 'ID' (ISO‑dow) returns 1=Mon…7=Sun
        $dowField = DB::getDriverName() === 'pgsql'
            ? "to_char(created_at, 'ID')::int"     // pgSQL
            : "DAYOFWEEK(created_at)";             // MySQL / MariaDB

        $rawCounts = VisitLog::selectRaw("$dowField as dow, COUNT(*) as visits")
            ->whereBetween('created_at', [$start, $end])
            ->groupBy('dow')
            ->pluck('visits', 'dow');   // → [dow => visits]

        // 3️⃣  Map to Monday‑first order and pad missing days with zero
        //     ISO order: 1=Mon … 7=Sun
        $labels = ['M', 'T', 'W', 'T', 'F', 'S', 'S'];

        $data = collect(range(1, 7))
            ->map(fn($isoDow) => (int) $rawCounts->get(
                // translate MySQL Sunday‑first to ISO if needed
                DB::getDriverName() === 'pgsql'
                ? $isoDow           // pgSQL already ISO
                : (($isoDow % 7) + 1)  // MySQL: 1(Sun)→7 ⇒ 2…7,1
                ,
                0
            ))
            ->all();

        return [
            'labels' => $labels,   // x‑axis
            'data' => $data,     // y‑axis
        ];
    }

    public function ordersAmountThisYearChart(): array
    {
        // 1️⃣  Restrict to the current year
        $currentYear = now()->year;

        // 2️⃣  One SQL query: SUM(amount) per month for status = 'paid'
        //     Adapt the month extractor for MySQL/MariaDB vs PostgreSQL
        $monthField = DB::getDriverName() === 'pgsql'
            ? "EXTRACT(MONTH FROM created_at)::int"  // pgSQL 1–12
            : "MONTH(created_at)";                   // MySQL/MariaDB 1–12

        $raw = Order::selectRaw("$monthField as mth, SUM(total_amount) as total")
            ->whereYear('created_at', $currentYear)
            ->where('payment_status', 'paid')               // ⬅ only paid orders
            ->groupBy('mth')
            ->pluck('total', 'mth');                // → [mth => total]

        // 3️⃣  Map into Jan‑first order; fill missing months with zero
        $labels = ['J', 'F', 'M', 'A', 'M', 'J', 'J', 'A', 'S', 'O', 'N', 'D'];

        $data = collect(range(1, 12))
            ->map(fn($m) => (float) $raw->get($m, 0))
            ->all();

        return [
            'labels' => $labels,
            'data' => $data,
        ];
    }

}
