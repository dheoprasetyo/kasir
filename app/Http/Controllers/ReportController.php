<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class ReportController extends Controller
{
    public function index()
    {
        $startDate = date('Y-m-d', mktime(0,0,0,date('m'),1,date('Y')));
        $endDate = date('Y-m-d');
        $income = new Order;
        return view('report.index', compact('startDate','endDate','income'));
    }

    public function changePeriode(Request $request)
    {
        $startDate = null;
        $endDate = null;
        $income = new Order;

        if(!empty($request->daterange)){
            $startDate = substr($request->daterange,0,10);
            $endDate = substr($request->daterange,13);
        }
        return view('report.changeperiode', compact('startDate','endDate','income'));
    }
}
