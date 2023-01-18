<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\Setting\Settings;

use App\Models\Setting\ContactUs;

use App\Models\Auction\Auction;

use App\Models\Lot\Lot;

use App\Models\Deposit\Deposit;

use App\Models\User;

use App\Models\Comment\Comment;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Session;

use Carbon\Carbon;

use Mail;

class DepositController extends Controller

{

   public function deposit(){

    $id=Auth::user()->id;
    $data['results'] = Deposit::where('user_id',$id)->OrderBy('created_at','DESC')->get();
   	return view('frontend.deposits.index',compact('data'));

   }

   public function savedeposit(Request $request){

     $id=$request->id;

    $data=$request->all();

    $data['status']="Pending";

    // $data['transaction_no']=uniqid();

    // dd($data);
     $affected_rows=Deposit::create($data);
     return redirect(app()->getLocale().'/paymentdetail/'.$affected_rows->id);
   }

   public function paymentdetail($lang,$id,$type=''){

    $data['deposit']=Deposit::where('id',$id)->first();

    $data['type']=$type;

    return view('frontend.payment.paymentdetail',compact('data'));

   }
   public function senddeposit(Request $request){
    $user = Auth::user();
    $id=$request->id;
    $data=$request->all();
    $data2['send']=1; 
    $data['deposit']=Deposit::find($id)->update($data2);
    $data['deposits']=Deposit::where('id',$id)->first();
    $this->send_email_test('umarwahab672@gmail.com','Deposit Email','frontend.email.depositemail',$data);
    return view('frontend.payment.paymentsuccess');
   }
   function send_email_test($email,$subject,$template,$data)
   {
       Mail::send($template, ['data'=>$data], function($message) use ($subject, $email) {
        $message->to($email,$subject)->subject($subject);
        $message->from('info@globalmotorshub.com',$subject);
        });
   }
}

?>