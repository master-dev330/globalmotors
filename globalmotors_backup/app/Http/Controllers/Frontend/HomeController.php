<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\Setting\Settings;

use App\Models\Setting\ContactUs;

use App\Models\Auction\Auction;

use App\Models\Lot\Lot;

use App\Models\Bid\Bid;

use App\Models\Buynow\Buynow;

use App\Models\Deposit\Deposit;
use App\Models\Deposit\DepositsReturn;


use App\Models\Bookmark\Bookmark;

use App\Models\User;

use App\Models\Fees\Fees;

use App\Models\Comment\Comment;

use App\Models\Model\Models;

use App\Models\Model\Make;

use App\Models\Faqs\Faqs;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Session;

use Carbon\Carbon;

use Goutte\Client;

use App;

use Mail;

class HomeController extends Controller

{

    public function home(){

        $data['results']=Lot::where('status',"Approved")->where('home_now','Yes')->get();
        // dd($data['results']);

        $data['make']=Make::orderBy('name')->get();

        $data['models']=Models::orderBy('name')->get();

         $id=0;

          if(Auth::check()){

            $id=Auth::user()->id;

          }  

         foreach($data['results'] as $row){
          //   echo url('/').$row->feature_image;
          // dd(file_exists(getcwd().$row->feature_image));
            // if(!file_exists(getcwd().$row->feature_image) && empty($row->feature_image))
            if(empty($row->feature_image))

            {

                // dd($row->id);
                $row->feature_image = '/public/uploads/lot/1081035701.jpg';
            }
            if( empty($row->brand_logo))
            
            // if(!file_exists(getcwd().$row->brand_logo) && empty($row->brand_logo))
            {

                // dd($row->id);
                $row->brand_logo = '/public/uploads/lot/1081035701.jpg';
            }

            $row->bookmark=Bookmark::where('lot_id',$row->id)->where('user_id',$id)->count();
        }

        // dd($data);

        return view('frontend.home.index',compact('data'));

    }

    public function userloginPage(){
      // dd('sdf');
       
        return view('frontend.auth.login');

    }

    public function userregisterPage(){
      //     $newuser=User::whereDate('created_at',Carbon::today())->whereDate('updated_at',Carbon::today())->with('role')->count();
      //        Session::put('usercount',$newuser);
      // dd($newuser);

        return view('frontend.auth.register');

    }

    public function userregister(Request $request)

    {

        $id = $request->id;

        $modal = new User();

        $data = $request->all();

        $data['password'] = bcrypt($request->password);

        $data['role_id']=2;
        $data['status']="Active";

        $email_check=User::where('email',$request->email)->first();

        // dd($data);

        if(!empty( $email_check)){

            $message['title']= 'Error';

            $message['text'] ='email already exists';

            Session::put('message', $message);

            return Redirect()->back();

        }


        if ($id) {

            $action = "Updated";

            $modal = App\Models\Role\User::find($id);

            $affected_rows = $modal->update($data);

        }else{

        

            $modal =  $modal::create($data);

        }

      return redirect('/login');

    }


    public function userdashboard(){

        // dd(Auth::user());

        $data['bookmark']=Bookmark::where('user_id',Auth::user()->id)->with('lot')->get();


        $id=0;

          if(Auth::check()){

            $id=Auth::user()->id;

          } 

        foreach($data['bookmark'] as $key=>$row){

            $row->bookmark=Bookmark::where('lot_id',$row->lot_id)->where('user_id',$id)->count();

        }

            // dd($data);



        if(Auth::check())

        {

             // dd('test');

            $data['personalinfo']=0;

            if (!empty(Auth::user()->country) && !empty(Auth::user()->region) ) {

               $data['personalinfo']=1;

            } 

            $data['docinfo']=0;

            if (!empty(Auth::user()->document) && Auth::user()->document_status=='Approved') {

               $data['docinfo']=1;

            }



             $data['depositexist']=0;

             $deposit=Deposit::where('user_id',Auth::user()->id)->get();

             // dd($deposit);

            if (!empty($deposit)) {

               $data['depositexist']=1;

            }

        }

         

        return view('frontend.dashboard.index',compact('data'));

    }


   public function userlogin(Request $request)

    {

         

            $email = $request->get('email');

            $password = $request->get('password');

            if (Auth::attempt(['email' => $email, 'password' => $password]))

             {
                     return redirect(app()->getLocale().'/userdashboard');

             }

             else

             {
                $message['title']= 'Error';

                $message['text'] ='Credentials do not match our records';

                Session::put('message', $message);

                return redirect(app()->getLocale().'/login');

             }



    }

    public function userlogout()
    {
        
        // dd('test');
        $user = Auth::user();

        Auth::logout();

        Session::flush();

        return Redirect(app()->getLocale().'/');

    }



    public function contactus(){


        return view("frontend.contactus.index");

    }

    public function about(){


        return view("frontend.about.index");

    }



    public function sendmessage(Request $request){



        $data=$request->all();

        

        $response=ContactUs::create($data);



        $response=array('response'=>$response);

        return json_encode($response);



    }
    public function depositstatus(Request $request){

      $id = $request->id;

      $data = $request->all();
      $affected_rows = Deposit::find($id)->update($data);
      $updated['deposit'] = Deposit::where('id',$id)->first();
      $updatedstatus=$updated['deposit']['status'];
      $response=array('status'=>1,'msg'=>$updatedstatus);
      $response=json_encode($response);
      return $response;

  }

    public function return_deposit(Request $request){

      $data=$request->all();
      $data['status']='Pending';
      $response=DepositsReturn::create($data);
      $response=array('response'=>$response);
      return json_encode($response);

  }
   public function paymenthistory(){

    $id=Auth::user()->id;

    $data['per_page']=25;

    $data['offset']=0;

    $data['results']=Deposit::where('user_id',$id)->take($data['per_page'])->OrderBy('created_at','DESC')->get();

    $data['total']=Deposit::where('user_id',$id)->count();

    // foreach($data['results'] as $value){
    //     Deposit::find($value->id)->delete();
    // }
    // dd( $data);

    return view('frontend.payment.index',compact('data'));

   }



    public function paymentpagination(Request $request){

     $id=Auth::user()->id;

     $data['per_page']=25;

     // $data['offset']=0;

     $pageno=(int)$request->pageno;

     $offset=($pageno-1) * $data['per_page']; 

     $data['offset']=$offset;

     $data['total']=Deposit::where('user_id',$id)->count();

     $data['results']=Deposit::where('user_id',$id)->offset($offset)->take($data['per_page'])->get();

     $respose=view('frontend.payment.table',compact('data'))->render();

      $respose=array('response'=>$respose);

      return json_encode($respose);

 

   }



    public function bettings($lang,$id){
        // dd($id);
      $data['results']=Bid::where('user_id',$id)->where('status','Approved')->with('user','auction','lotname')->OrderBy('created_at','DESC')->get();

      $data['rejected']=Bid::where('user_id',$id)->where('status','Rejected')->with('user','auction','lotname')->OrderBy('created_at','DESC')->get();
      $data['current']=Bid::where('user_id',$id)->where('status','Pending')->with('user','auction','lotname')->OrderBy('created_at','DESC')->get();
      $data['canceled']=Bid::join('auctions', 'bids.auction_id', '=', 'auctions.id')->join('lot', 'bids.lot_id', '=', 'lot.id')->with('lotname')->where('lot.status','Canceled')->where('user_id',$id)->get();

      // $data['current']= Bid::with('lotname')->join('auctions', 'bids.auction_id', '=', 'auctions.id')->join('lot', 'bids.lot_id', '=', 'lot.id')->where("bids.status",'Pending')->where('user_id',$id)->get();
      // dd($data['current']);
     // echo $currentTime;
     // echo strtotime($data['current'][0]->start_date)-$currentTime;

      // dd($data);

       return view('frontend.betting.index',compact("data"));

   }

   public function bidstatus(Request $request){

    $id = $request->id;
    $data = $request->all();
    $affected_rows = Bid::find($id)->update($data);
    $updated['Bid'] = Bid::where('id',$id)->first();
    $updatedstatus=$updated['Bid']['status'];
    $response=array('status'=>1,'msg'=>$updatedstatus);
    $response=json_encode($response);
    return $response;

}
public function bidchange(Request $request){
  $id = $request->id;
  $data = $request->all();
  $affected_rows = Bid::find($id)->update($data);
  $response=array('status'=>1,'msg'=>$affected_rows);
  $response=json_encode($response);
  return $response;
}

   public function buynowlist($lang,$id){
      $data['results']=Buynow::where('user_id',$id)->where('status','Approved')->with('user','auction','lotname')->OrderBy('created_at','DESC')->get();
      $data['rejected']=Buynow::where('user_id',$id)->where('status','Rejected')->with('user','auction','lotname')->OrderBy('created_at','DESC')->get();
      $data['canceled']=Buynow::join('auctions', 'buy_now.auction_id', '=', 'auctions.id')->join('lot', 'buy_now.lot_id', '=', 'lot.id')->where('lot.status','Canceled')->with('lotname')->where('user_id',$id)->OrderBy('lot.created_at','DESC')->get();
      $data['current']= Buynow::join('auctions', 'buy_now.auction_id', '=', 'auctions.id')->join('lot', 'buy_now.lot_id', '=', 'lot.id')->where("buy_now.status",'Pending')->with('lotname')->where('user_id',$id)->OrderBy('lot.created_at','DESC')->get();

       return view('frontend.buynow.index',compact("data"));

   }


  public function document($lang,$id){

    $data['results'] = User::where('id',$id)->first();

    return view('frontend.document.index',compact('data'));

  }

  public function savedocument(Request $request){

     $data=$request->all();

       if ($request->hasfile('document')) {

            $name = $request->file('document');

            $file = rand(1,9999).'_'.'document'.'.'.$name->getClientOriginalExtension();

            $name->move(public_path().'/uploads/document',$file);

            $data['document'] = '/public/uploads/document/' . $file;



            // $data['document']=$file;

        }

        // dd($data);

        $id=Auth::user()->id;

        if($id){
       $data['document_status']='Pending';
        $data['document_upload_date']=date('Y-m-d H:i:s');
        $modal = User::find($id)->update($data);
        }

        // dd($modal);

        return redirect()->back();   

  }



  public function langsession($language){



  Session::put('lang',$language);



  return 1;

  }

  public function faq(){

    $data['faq']=Faqs::OrderBy('created_at','DESC')->get();

    return view('frontend.faqs.index',compact("data"));

  } 

  public function get_faqs(Request $request){

    $data=$request->all();

    $data['faq']=Faqs::where('type',$data['type'])->get();

    $response=view('frontend.faqs.section',compact("data"))->render();

    $response=array('response'=>$response);

    return json_encode($response);

  }


  public function howto()

  {
    $lang = App::getLocale();

    return view('frontend.howto.index_'.$lang);

  }

  public function terms()

  {
    $lang = App::getLocale();
    return view('frontend.terms.index_'.$lang);

  } 

  public function privacy()

  {
    $lang = App::getLocale();
    return view('frontend.terms.privacy_'.$lang);

  }


  public function fees()

  {
    $data['coparts']=Fees::where('type','copart')->where('sub_type','BuyerFee')->get();
    $data['copart_sub']=Fees::where('type','copart')->where('sub_type','Virtualbed')->get();
    $data['iaai']=Fees::where('type','iaai')->where('sub_type','BuyerFee')->get();
    $data['iaai_sub']=Fees::where('type','iaai')->where('sub_type','Virtualbed')->get();
    
    return view('frontend.partials.index',compact('data'));

  }


  public function scrape(){

    $client = new Client();

    $crawler = $client->request('GET', 'https://carsfromwest.com/en/search?auctions=copart,iaai&type=AM&yearMin=2017&yearMax=2022&onlyActive=true');

    dd($crawler);

  }

  public function email_verify()
    {
        $password = $_GET['token'];
        $user = User::where('password',$password )->first();
        if(!empty($user))
        {
            if(!empty($user->email_verified_at))
            {
                 $data['message'] = array('message'=>'Email Already verified');
            }
            else
            {
                $update_data = array('email_verified_at'=>date('Y-m-d h:i:s'));
                $affected_rows = User::where('password',$password)->update($update_data);
                $data['message'] = array('message'=>'Email is verified');
            }
           
           
        }
        else
        {
            $data['message'] = array('message'=>'Invalid verification link');
        }
        
        $data = implode("",($data['message']));

        

         return view('frontend.email.emailverified',compact('data'));
    }

    public function resendemail()
    {
        // dd('sdf');
        $data = Auth::user();
        dd($data);
        $template= view('frontend.email.email',compact('data'))->render();

        $this->send_email_test($data['email'],'Verify Email',"frontend.email.email",$data);
        Session::put('resent',$data);
        return redirect('email/verify');
    }
     public function socialemail_verify()
    {
        $email = $_GET['token'];
        $user = User::where('email',$email )->first();
        if(!empty($user))
        {
            if(!empty($user->email_verified_at))
            {
                 $data['message'] = array('message'=>'Email Already verified');
            }
            else
            {
                $update_data = array('email_verified_at'=>date('Y-m-d h:i:s'));
                $affected_rows = User::where('email',$email)->update($update_data);
                $data['message'] = array('message'=>'Email is verified');
            }
           
           
        }
        else
        {
            $data['message'] = array('message'=>'Invalid verification link');
        }
        
        $data = implode("",($data['message']));

        

         return view('frontend.email.emailverified',compact('data'));
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

