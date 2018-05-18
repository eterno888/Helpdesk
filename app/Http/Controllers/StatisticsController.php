<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Repositories\KpiRepository;

class StatisticsController extends Controller
{
    public function index(KpiRepository $repository)
    {
        $startDate = request('startDate') ?: Carbon::now()->startOfMonth();
        $endDate   = request('endDate') ?: Carbon::now()->endOfMonth();

        return view('reports.statistics', ['repository' => $repository->forDates($startDate, $endDate)]);
    }
}
