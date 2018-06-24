<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

class StatisticsController extends Controller
{
    public function index()
    {
        $startDate = request('startDate') ?: Carbon::now()->startOfMonth();
        $endDate   = request('endDate') ?: Carbon::now()->endOfMonth();

        return view('reports.statistics', ['repository' => $repository->forDates($startDate, $endDate)]);
    }
}
