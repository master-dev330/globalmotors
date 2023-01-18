<?php

namespace App\Http\Controllers\Auctions;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\Setting\Settings;

use App\Models\Auction\Auction;

use App\Models\Bid\Bid;
use App\Models\Lot\Lot;
use App\Models\User;

use App\Models\Buynow\Buynow;

use App\Models\Lot\FileUpload;

use App\Models\Training\Like;

use App\Models\Comment\Comment;

use App\Models\Training\TrainingResource;

use Carbon\Carbon;

use Illuminate\Support\Facades\Session;
use Mail;



class BidsController extends Controller

{

	public function bids(){

		$data['results']=Bid::with('user','auction','lotname')->OrderBy('created_at','DESC')->get();


		return view('bids.index',compact("data"));

	}



	public function approvebid($lang,$id){
       $data['status']="Approved" ;
      if($id){

            $action = "Updated";

            $modal = Bid::find($id);

            // dd($modal);

            $affected_rows = $modal->update($data);

      }



      return redirect()->back();    

  

	}

//pending bids
    public function prndingbid($lang,$id){
       $data['status']="Pending" ;
      if($id){

            $action = "Updated";

            $modal = Bid::find($id);


            $affected_rows = $modal->update($data);

      }



      return redirect()->back();    

  

    }

  public function approvebuynow(Request $request){
    $id = $request->id;
    $data = $request->all();
    $status = $request->status;
    if($status=='Approved' || $status=='Cancelled'){
      $lot_id = $request->lot_id;
      $user_id = $request->user_id;
      $data['lot'] = Lot::where('id',$lot_id)->first();
      $data['lot_title']=$data['lot']->lot_title;
      $data['user'] = User::where('id',$user_id)->first();
      $email=isset($data['user']->email) ? $data['user']->email : '';
      if($status=="Approved"){
      $this->send_email($email,$data['lot_title'].' Bid Approved',"email.buynowbidapprove",$data);
      }
      else{
        $this->send_email($email,$data['lot_title'].' Bid Rejected',"email.buynowbidapprove",$data);
      }
    }
    unset($data['details']);
        unset($data['lot']);
        unset($data['lot_id']);
        unset($data['user_id']);
        unset($data['user']);
        unset($data['lot_title']);
        $modal = Buynow::find($id);
        $affected_rows = $modal->update($data);
        return redirect()->back();    

  }

	 public function bidstatus(Request $request){

        $id = $request->id;
        $data = $request->all();
        $status = $request->status;
        if($status=='Approved' || $status=='Rejected'){
          $lot_id = $request->lot_id;
          $user_id = $request->user_id;
          $data['lot'] = Lot::where('id',$lot_id)->first();
          $data['lot_title']=$data['lot']->lot_title;
          $data['user'] = User::where('id',$user_id)->first();
          $email=isset($data['user']->email) ? $data['user']->email : '';
          if($status=="Approved"){
          $this->send_email($email,$data['lot_title'].' Bid Approved',"email.bidapprove",$data);
          }
          else{
            $this->send_email($email,$data['lot_title'].' Bid Rejected',"email.bidapprove",$data);
          }
        }
        unset($data['details']);
        unset($data['lot']);
        unset($data['lot_id']);
        unset($data['user_id']);
        unset($data['user']);
        unset($data['lot_title']);

        $affected_rows = Bid::find($id)->update($data);
        if($status=='Approved'){
          return Redirect(app()->getLocale().'/admin/bids');
          }
        $response=array('status'=>1,'msg'=>'Data Updated');

        $response=json_encode($response);

        return $response;

    } 
  function send_email($to_email,$subject,$template,$data)
    {

        Mail::send($template, ['data'=>$data], function($message) use ($subject, $to_email) {

            $message->to($to_email,$subject)->subject($subject);

            $message->from('info@globalmotorshub.com',$subject);

        });

    }

    public function buynowstatus(Request $request){

        $id = $request->id;
        dd($id);

        $data = $request->all();

        $affected_rows = Buynow::find($id)->update($data);

        $response=array('status'=>1,'msg'=>'Data Updated');

        $response=json_encode($response);

        return $response;

    }



    public function purchased(){

      // dd('test');

    $data['results']=Bid::where('status','Approved')->with('user','auction','lotname')->OrderBy('created_at','DESC')->get();

    // dd($data);

      return view('purchase.index',compact('data'));

    }



    public function purchasedhistory($id){

      $data['results']=Bid::where('user_id',$id)->where('status','Approved')->with('user','auction','lotname')->get();

    $response=view('users.purchasedhistory',compact('data'))->render();

    // dd($response);



    $response=array('response'=>$response);

    return json_encode($response);

    }





    public function buynow(){

      $data['results']=Buynow::with('user','lotname')->OrderBy('created_at','DESC')->get();

         // dd($data);

      return view('buynow.index',compact("data"));



    }
    public function deletebid($lang,$id){

        $affected_rows=Bid::find($id)->delete();
        $message=   set_message($affected_rows,'Bid','Deleted');
        Session::put('message', $message);
        return Redirect(app()->getLocale().'/admin/bids');
    }


    public function todayBids(){
     $data['page_title'] = "Notifications";
     return view("bids.todaybids",compact('data'));
    }

    public function filter_bids(Request $request)

    {
       $range=$this->daterange($request);
        $startdate=$range->startdate;
        // dd($startdate);
        $enddate=$range->enddate;

        $data['results']=Bid::whereDate('created_at','>=',$startdate)->whereDate('created_at','<=',$enddate)->get();

        $response= view('bids.filterbids',compact('data'))->render();
        $response=array('response'=>$response);
        return json_encode($response);
    }

    public function daterange($request){
        $startdate="1975-11-11";
        $enddate="2099-11-11";
        if($request->startdate){
            $startdate=db_format_date($request->startdate);
        }
        if($request->enddate){
            $enddate=db_format_date($request->enddate);
        }
        return (object) array('startdate'=>$startdate,'enddate'=>$enddate);
    }


}



?>