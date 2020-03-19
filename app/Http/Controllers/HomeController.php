<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Order;
use App\Charts\Daily;
use App\Charts\Monthly;
use Jenssegers\Date\Date;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $cart_order = Cart::all();
        $categories = Category::all();
        $today = date('Y-m-d');
        $yesterday = date('Y-m-d', strtotime("-1 days"));
        $income_today = Order::where('created_at','LIKE',"$today%")->sum('total');
        $income_yesterday = Order::where('created_at','LIKE',"$yesterday%")->sum('total');
        $product = Product::count();

        // create date
        $startDate = date('Y-m-d', mktime(0,0,0, date('m'),1,date('Y')));

        $date = array();
        $income = array();

        for ($i=$startDate; $i <= $today ; $i++) { 
            $date[] = substr($i,8,2);
            $paid = Order::where('created_at','LIKE',"$i%")->sum('total');
            $income[]= $paid;
        }

        // create chart harian
        $chart_daily = new Daily;
        $chart_daily ->labels($date);
        $chart_daily->dataset('Grafik Penjualan Bulan Ini','line',$income);

        // create month
        $month = array();
        $income_monthly = array();
        for ($i=1; $i<=12; $i++) {
            $month[]=Date::parse(mktime(0,0,0, $i,1,date('Y')))->format('F');
            $paid_monthly = Order::select('created_at')
                ->whereBetween('created_at', array(date('Y-m-d', mktime(0,0,0, $i,1, date('Y'))), date('Y-m-d', mktime(0,0,0, $i,32, date('Y')))))->sum('total');
                $income_monthly[] = $paid_monthly;
        }

        // create chart monthly
        $chart_monthly = new Monthly;
        $chart_monthly->labels($month);
        $chart_monthly->dataset('Grafik Penjualan Per Bulan', 'line',$income_monthly);

        if(Auth::user()->hasRole('kasir')){
            return view('dashboard',compact('cart_order'));
        }
        if(Auth::user()->hasRole('owner')){
            return view('dashboard',compact('categories','income_today','income_yesterday','product','chart_daily','chart_monthly'));
        }
    }

    // Function ini kita gunakan untuk pencarian data product, apabila data ditemukan maka akan dikirimkan dalam bentuk json.
    public function search(Request $request)
    {
        $search = $request->term;
        $data = Product::where('name','LIKE','%'.$search.'%')
        ->take(10)
        ->get();
        $result=array();
        foreach ($data as $key => $value) {
            $result[]=['price'=>$value->price,'id'=>$value->id,'value'=>$value->name];
        }
        return response()->json($result);
    }
}
