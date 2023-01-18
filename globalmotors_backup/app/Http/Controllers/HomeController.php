<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Test\Result;
use App\Models\Test\QuestionTranslations;
use App\Models\Training\TrainingResource;
use App\Models\Lot\Lot;
use App\Models\Bid\Bid;
use App\Models\Auction\Auction;
use App\Models\Deposit\Deposit;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //    $this->middleware(['auth','verified']);
    // }
    public function frontend()
    {
        return view('frontend.layout.header');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function home()
    {
        $data['users'] =User::get();
        $data['Lot']=Lot::get()->count();
        $data['Auction'] = Auction::get();
        $data['Bid'] = Bid::get();
        $data['Deposit'] = Deposit::get();
     
        $data['today']=Bid::whereDate('created_at', Carbon::today())->get()->count();
        $data['week']=Bid::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get()->count();
        $data['month']=Bid::whereMonth('created_at', date('m')-1)->get()->count();
        $data['year']=Bid::whereYear('created_at', date('Y'))->get()->count();
        // dd(date('Y'));
        return view('dashboard.index',compact('data'));
    }
}
