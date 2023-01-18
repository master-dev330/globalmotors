<?php

namespace App\Http\Controllers\Deposit;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\Setting\Settings;

use App\Models\Setting\ContactUs;

use App\Models\Auction\Auction;

use App\Models\Lot\Lot;

use App\Models\Deposit\Deposit;
use App\Models\Deposit\DepositsReturn;


use App\Models\User;

use App\Models\Comment\Comment;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Session;

use Carbon\Carbon;
use Mail;






class DepositController extends Controller

{

	public function deposits(){

		$data['results']=Deposit::orderBy('created_at',"ASC")->with('user')->get();


		return view('deposits.index',compact('data'));

	}

	 public function depositstatus(Request $request){
        $id = $request->id;
        $data = $request->all();
        $status = $request->status;
        if($status=='Paid' || $status=='Cancel'){
            $data['amount'] = $request->amount;
            $data['status'] = $request->status;
            $deposit['deposit'] = Deposit::where('id',$id)->with('user')->first();
            $data['user_name'] = $deposit['deposit']['user']['name'];
            $email=isset($deposit['deposit']->user->email) ? $deposit['deposit']->user->email : '';
            if($data['status']=='Paid'){
            $this->send_email($email, $data['user_name'].' Deposit Approved',"email.depositemail",$data);
            }else{
            $this->send_email($email, $data['user_name'].' Deposit Cancel',"email.depositemail",$data);
            }
          }
            unset($data['deposit_id']);
            unset($data['amount']);
            unset($data['deposit']);
            unset($data['user_name']);
        $affected_rows = Deposit::find($id)->update($data);
        return redirect()->back();

    }

    public function deletedeposit($lang,$id){


    	$affected_rows = Deposit::find($id)->delete();

        $message =  set_message($affected_rows,'Deposit','Deleted');

        Session::put('message', $message);

        return redirect()->back();

    }

    public function depositdetail($lang,$id){
       // dd();
    	$data['results']=Deposit::where('id',$id)->with('user')->first();

    	return view('deposits.detail',compact('data'));

    }

    public function depositedit($lang,$id)
    {
        $data['page_title'] = "Update Deposit";
        $data['user'] = User::get();
        $data['results'] = Deposit::where('id',$id)->with('user')->first();

        return view('deposits.save',compact('data'));
    }

    public function savedeposit(Request $request)

    {

        $id = $request->id;

        $data = $request->all();

        $action = "Added";

        if ($id) {

            $action = "Updated";

            $modal = Deposit::find($id);

            $affected_rows = $modal->update($data);

        } else {

            $affected_rows =  Deposit::create($data);

        }

        $message=set_message($affected_rows,'Deposit',$action);

        Session::put('message', $message);

        return Redirect(app()->getLocale().'/admin/deposits');

    }
    //RETURN DEPOSIT
    public function returndeposits(){

		$data['results']=DepositsReturn::get();

		return view('returndeposits.index',compact('data'));

	}
    public function deletereturndeposit($lang,$id){
    	$affected_rows = DepositsReturn::find($id)->delete();

        $message=   set_message($affected_rows,'Return Deposit','Deleted');

        Session::put('message', $message);

        return redirect()->back();

    }
    public function returndepositstatus(Request $request){

        $id = $request->id;
        $data = $request->all();
        $status = $request->status;
        if($status=='Approved'){
        $deposit_id = $request->deposit_id;
        $deposit['deposit'] = Deposit::where('id',$deposit_id)->with('user')->first();
        $data['user_name'] = $deposit['deposit']['user']['name'];
        $data['return_amount'] = $deposit['deposit']['amount'];
        $email=isset($deposit['deposit']->user->email) ? $deposit['deposit']->user->email : '';
        $this->send_email($email,'Return Deposit Request Approved',"email.returndeposit",$data);
        }
        unset($data['deposit_id']);
        unset($data['return_amount']);
        unset($data['user_name']);
        $affected_rows = DepositsReturn::find($id)->update($data);

        $response=array('status'=>1,'msg'=>'Data Updated');

        $response=json_encode($response);

        return $response;

    }
	function send_email($to_email,$subject,$template,$data)

      {
         // dd($data);
  
          Mail::send($template, ['data'=>$data], function($message) use ($subject, $to_email) {
  
              $message->to($to_email,$subject)->subject($subject);
  
              $message->from('info@globalmotorshub.com',$subject);
  
          });
  
      }

}

?>