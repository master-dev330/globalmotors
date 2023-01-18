<?php

namespace App\Http\Controllers\Deposit;

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





class DepositController extends Controller

{

	public function deposits(){

		$data['results']=Deposit::orderBy('created_at',"DESC")->with('user')->get();

		// dd($data['results']);

		return view('deposits.index',compact('data'));

	}

	 public function depositstatus(Request $request){

        $id = $request->id;

        $data = $request->all();

        $affected_rows = Deposit::find($id)->update($data);

        $response=array('status'=>1,'msg'=>'Data Updated');

        $response=json_encode($response);

        return $response;

    }

    public function deletedeposit($lang,$id){


    	$affected_rows = Deposit::find($id)->delete();

        $message=   set_message($affected_rows,'Deposit','Deleted');

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

}

?>