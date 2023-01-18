<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\Setting\Settings;

use App\Models\Auction\Auction;
use App\Models\Bookmark\Bookmark;
use App\Models\Lot\Lot;
use App\Models\Fees\Fees;
use App\Models\Shipping\Shippingfee;
use App\Models\Bid\Bid;
use App\Models\Buynow\Buynow;
use App\Models\Groundshipping\Groundshipping;
use App\Models\Oceanshipping\Oceanshipping;
use App\Models\Lot\FileUpload;

use App\Models\User;

use App\Models\Comment\Comment;

use App\Models\Training\TrainingResource;

use Illuminate\Support\Facades\Auth;

use App\Models\Deposit\Deposit;
use App\Models\EmailTemplete\Templete;

use Mail;



use Illuminate\Support\Facades\Session;


class LotController extends Controller

{

	public function lotdetail($lang,$id){
       // dd($id);

		 $data['lot']=Lot::with('make','model')->where('status',"Approved")->where('id',$id)->first();
     // dd($data['lot']);
      if(empty($data['lot']->feature_image))
      {
        $data['lot']->feature_image = isset($data['lot']->feature_image)?'public/uploads/lot/1640695820.png':'';
      }
      if(empty($data['lot']->brand_logo))
      {
        $data['lot']->brand_logo = 'public/uploads/lot/1640695820.png';
      }

     $data['bookmark']=Bookmark::where('lot_id',$id)->first();

        
		 $data['lot_images']=FileUpload::where('lot_id',$id)->get();
     
		 $data['auction']=Auction::where('id', $data['lot']->auction_id)->first();

		 $data['auction']->start_date =strtotime($data['auction']->start_date);

		 $data['auction']->end_date =strtotime($data['auction']->end_date);

		 $data['auction']->current_date =strtotime(date('Y-m-d h:i:s'));

      $data['starting_price']=check_starting_price($data['lot'],$id);
            
            $user_id=0;
            if(Auth::check()){
            	$user_id=Auth::user()->id;
            }
      $data['deposit']=Deposit::where('user_id',$user_id)->where('status',"Paid")->first();
     // dd($data['deposit']);
      $data['ground_shipping']= Groundshipping::get();

      $data['ocean_shipping']= Oceanshipping::get();

		 // dd($data['lot']);
 
		return view('frontend.lots.lotdetail',compact('data'));

	}
  public function getimages($lang,$id){
       $data['lot']=Lot::where('status',"Approved")->where('id',$id)->first();
      if(empty($data['lot']->feature_image))
      {
        $data['lot']->feature_image = isset($data['lot']->feature_image)?'public/uploads/lot/1640695820.png':'';
      }
     $data['lot_images']=FileUpload::where('lot_id',$id)->get();
     $response=view('frontend.lots.galleryimage',compact('data'))->render();
     $response=array('response'=>$response);
     return json_encode($response);

  }

  
	 public function placebid(Request $request){

         $data=$request->all();
         $data['status']='Pending'; 
          unset($data['deposit_amount']);

          $lotexist=Bid::where('user_id',$data['user_id'])->where('lot_id',$data['lot_id'])->first();
          // dd($lotexist);
          if(!empty($lotexist)){
           $updaete =Bid::find($lotexist->id)->update($data);
           $bid =Bid::where('id',$lotexist->id)->first();
          }else{
           $bid =Bid::create($data);
          }

		     $data['lot']=Lot::where('status',"Approved")->where('id',$data['lot_id'])->first();

         $data['bid']=$bid;

         $data['user']=User::where('id',Auth::user()->id)->first();
     	 // $template= view('email.template',compact('data'))->render();
          // placebidtemplete();
         // dd($bid);
         $this->send_email($data['user']->email,'Bid Placed',"email.template",$data);

         $response=array('response'=>$bid);

         return json_encode($response);



	 }

   public function buynow(Request $request){

         $data=$request->all();

         $bid =Buynow::create($data);
		     $data['lot']=Lot::where('status',"Approved")->where('id',$data['lot_id'])->first();

         $data['bid']=$bid;

         $data['user']=User::where('id',Auth::user()->id)->first();

     	   $template= view('email.template',compact('data'))->render();
         // dd($data['bid']->buy_amount);
         $this->send_email($data['user']->email,'Buy Now Request',"email.buynow",$data);

         $response=array('response'=>$bid);

         return json_encode($response);

	 }



	  function send_email($to_email,$subject,$template,$data)

    {

       // dd($data);

        Mail::send($template, ['data'=>$data], function($message) use ($subject, $to_email) {

            $message->to($to_email,$subject)->subject($subject);

            $message->from('info@globalmotorshub.com',$subject);

        });

    }

public function test(Request $request){
   // dd($request->id);
   $id=$request->id;
    $data['lot']=Lot::where('status',"Approved")->where('id',$id)->first();

       $data['lot_images']=FileUpload::where('lot_id',$id)->get();
       $data['auction']=Auction::where('id', $data['lot']->auction_id)->first();

       $data['auction']->start_date =strtotime($data['auction']->start_date);

       $data['auction']->end_date =strtotime($data['auction']->end_date);

       $data['auction']->current_date =strtotime(date('Y-m-d h:i:s'));

         $data['starting_price']=check_starting_price($data['lot'],$id);
            
            $user_id=0;
            if(Auth::check()){
               $user_id=Auth::user()->id;
            }
         $data['deposit']=Deposit::where('user_id',$user_id)->first();


      return view('frontend.lots.lotdetail',compact('data'));

}


  public function bid_value(Request $request)
  {
     $bid_value = $request->bid_value;

     $type = $request->brand;

     $lot_no = $request->lot_no;

     $lot_type = strtolower($type);

      $ch = curl_init();
     // $uri ='https://carsfromwest.com/api/fee/lot-fees-calculation/'.$lot_type.'-'.$lot_no.'?winningAmount='.$bid_value;
      $uri ='https://carsfromwest.com/api/fee/lot-fees-calculation/'.$lot_type.'-'.$lot_no;
     // $uri='https://carsfromwest.com/api/fee/lot-fees-calculation/copart-42411172?winningAmount=12200';
      curl_setopt($ch, CURLOPT_URL, $uri); //$uri is the same that I use in terminal
      $post = [
          'winningAmount' => $bid_value,
      ];
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_POSTFIELDS,$post);
      $data = curl_exec($ch);
      // dd($data);
      // curl_close($ch);
      $lot_data = json_decode($data);
      // dd($lot_data);

      $fee = $lot_data->meta->fees->service[1]->fee->value;
      $document_fee = $lot_data->meta->fees->service[0]->fee->value;

      $code=$lot_data->meta->fees->auction[0]->fee->value;
      $buyer=$lot_data->meta->fees->auction[1]->fee->value;
      $virtual=$lot_data->meta->fees->auction[2]->fee->value;
      $Gate=$lot_data->meta->fees->auction[3]->fee->value;
      $mailing=$lot_data->meta->fees->auction[4]->fee->value;
      $standard_fee = $code + $buyer + $virtual + $Gate + $mailing;
     
      $bid_data = Fees::where('sale_price_end','>=',$bid_value)->where('sale_price_start','<=',$bid_value)->where('type',$type)->first();

     if(!empty($standard_fee))
     {
     
        $response = array('response'=> $standard_fee,'transction_fee'=>$fee,'document_fee'=>$document_fee);

        return json_encode($response);
     }
     else
     {

        $response = array('response'=>0);

        return json_encode($response);
     }

     
  }

  public function zip_code_search(Request $request)
  {

      $zip_code = $request->zip_code;

      $type = $request->type;

      $zip_code_data = Shippingfee::where('zip_code',$zip_code)->where('type',$type)->first();

      if(!empty($zip_code_data))
      {
        $response = array('response'=>$zip_code_data['fee']);

        return json_encode($response);
      }
      else
      {

        $response = array('response'=>0);

        return json_encode($response);
      }
  }

  public function ground_shipping_search(Request $request)
  {
      $id = $request->id;

      $ground_search_data = Groundshipping::where('id',$id)->first();

      $ocean_search_data = Oceanshipping::where('ground_id',$id)->get();

      $ocean_option = "<option value=''>Select option</option>";

      foreach ($ocean_search_data as $key => $value) {
        $ocean_option.="<option value=".$value->id.">".$value->name."</option>";
      }

      $response = array('response'=>$ground_search_data['fee'],'ocean'=>$ocean_option);
        // dd($ocean_option);
      return json_encode($response);;
  }

  public function ocean_shipping_search(Request $request)
  {
      $id = $request->ocean_id;
      $ocean_data = Oceanshipping::where('id',$id)->first();
      $response = array('response'=>$ocean_data['fee']);
      return json_encode($response);;
  }
	 
}

 

?>