<?php
namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting\Settings;
use App\Models\Setting\ContactUs;
use App\Models\Auction\Auction;
use App\Models\Lot\Lot;
use App\Models\Bookmark\Bookmark;
use App\Models\Model\Models;
use App\Models\Model\Make;
use App\Models\User;
use App\Models\Comment\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\Countries\Countries;
use App\Models\Countries\State;
use App\Models\Countries\City;
use Carbon\Carbon;
use App\Models\Lot\FileUpload;


class FilterController extends Controller
{
   public function searchbar(Request $request){

    $data=$request->all();
    
     Session::put('searchQuery',$data['search']);
       Session::put('data', $data);
       // dd(env('PER_PAGE'));
      $data['per_page']=env('PER_PAGE');
      $data['offset']=1;
      $data['cur_page']=2;
        $data['post']= $data;
      $data['make']=Make::orderBy('name')->get();
      
      $data['auction']=Auction::get();
      $country_id=$data['auction']->pluck('location');
      $state_id=$data['auction']->pluck('state');
      $data['state']=State::whereIn('country_id',$country_id)->get();
      $data['city']=City::whereIn('state_id',$state_id)->get();
  
      // dd($data['search']);
// dd($numericQuery);
// $searchValue=$data['search'];
      $query=Lot::where('lot.lot_title','LIKE', '%' .$data['search']. '%')
      ->orWhere('lot.title_year_before','LIKE', '%' .$data['search']. '%')
      ->orWhere('lot.title_year_after','LIKE', '%' .$data['search']. '%');

      //commented by medha on 20/10/2019
    //   ->join('model','lot.model_id','=','model.id')
    //   ->join('make','model.make_id','make.id')
    //   // ->orWhere('vin', 'LIKE', '%' .$data['search']. '%')
    //   //->orWhere('model.name','LIKE', '%' .$data['search']. '%')
    //   //->orWhere('make.name','LIKE', '%' .$data['search']. '%')
    //  ->select('lot.*')
    //   ->with('lot');

      // if($numericQuery){
      //   if($numericQuery >= 1923 && $numericQuery<=date('Y')){
      //       $query=$query
      //   // ->orWhere('lot_no', 'LIKE', '%' .$numericQuery. '%');
      //                 ->where('lot.year',$numericQuery);
      //   }
      
      // }
        $id=0;
          if(Auth::check()){
            $id=Auth::user()->id;
          }  

          $mytime = Carbon::now();
          // dd($mytime);
       $data['search']= $query->where('trading_date','>',$mytime->toDateTimeString())->take($data['per_page'])->get();
      // dd($data['search']);
        
        foreach($data['search'] as $row){
            $row->bookmark=Bookmark::where('lot_id',$row->id)->where('user_id',$id)->count();
        }
       $data['total']=count($query->take(env('CATALOG_TOTAL'))->get());
         // $data['models']=Models::get();
    $data['models']=[];
       $data['auction']=Auction::get();
    $country_id=$data['auction']->pluck('location');
    $state_id=$data['auction']->pluck('state');
    $data['state']=State::whereIn('country_id',$country_id)->get();
    $data['city']=City::whereIn('state_id',$state_id)->get();
     $data['brand']=['COPART'=>"COPART",'IAAI'=>"IAAI"];  

    // dd($data['search']);
    return view("frontend.search.index",compact("data"));
   }
   public function filter(Request $request){
    $data=$request->all();
    // dd($data);
      $data['offset']=1;
      $data['cur_page']=2;

      $data['per_page']=env('PER_PAGE');
      $data['post']= $data;
      $data['make']=Make::orderBy('name')->get();
      $data['models']=Models::where('make_id',isset($data['brand']) ? $data['brand'] : [])->orderBy('name')->get();
   
        $data['auction']=Auction::get();
        $country_id=$data['auction']->pluck('location');
        $state_id=$data['auction']->pluck('state');
        $data['state']=State::whereIn('country_id',$country_id)->get();
        $data['city']=City::whereIn('state_id',$state_id)->get();
   
         $data['year']='1950';
          $data['year_to']='2099';
          if($request->year){
          $data['year']=$request->year;
          } 
          if($request->year_to){
          $data['year_to']=$request->year_to;
          }
          $mytime = Carbon::now();

         $query=Lot::with('lot')
         ->join('auctions','lot.auction_id','auctions.id')
          ->select('lot.*','auctions.start_date')
          ->where('year','>=',$data['year'])
          ->where('year','<=',$data['year_to'])->where('trading_date','>',$mytime->toDateTimeString());
        
       if(isset($data['brand']) &&  !empty($data['brand']) && $data['brand'] !="all-make"){
        // dd($data['brand']);
              $query=$query->where('make_id',$data['brand']);
          }
           if(isset($data['model']) &&  !empty($data['model']) && $data['model'] !="all-model"){
              $query=$query->where('model_id',$data['model']);
          }

                    
    $data['search']=$query->take($data['per_page'])->where('buy_now','=',0)->get();
    // dd($query->toSql());
    $data['total']=count($query->take(env('CATALOG_TOTAL'))->get());
    // dd($data);
     $data['brand']=['COPART'=>"COPART",'IAAI'=>"IAAI"];  
    
    return view("frontend.search.index",compact("data"));
   }

  public function lotsearch(){
    // $lots=Lot::offset(34000)->take(10000)->get();

    // foreach($lots as $key=>$value){
    //   $data=array('lot_title'=>$value->year.' '.$value->lot_title);

    //   Lot::where('id',$value->id)->update($data);
    // }
    //   dd($data);
    $data['per_page']=env('PER_PAGE');
    // dd($_GET['brand']);  
      $data['offset']=1;
      $data['cur_page']=2;
      
    $data['makeid']=isset($_GET['brand'])?$_GET['brand']:'';
    $data['vehicletype']=isset($_GET['vehicletype'])?$_GET['vehicletype']:'';

    $data['make']=Make::orderBy('name')->get();
    // $data['models']=Models::get();
    $data['models']=[];
    $data['auction']=Auction::get();
  $mytime = Carbon::now();
    if(isset($_GET['brand']) && !empty($_GET['brand'])){
    $data['search']= Lot::where('make_id',$_GET['brand'])->orderBy('created_at','desc')->where('trading_date','>',$mytime->toDateTimeString())->with('lot')->take($data['per_page'])->get();
    $data['brandinfo']=Make::where('id',$_GET['brand'])->first();
     $data['vehicletypeinfo']=$data['search'][0]->vehicle_type;
    }
     else if(isset($_GET['model']) && !empty($_GET['model'])){
      $data['models']=Models::where('make_id',$_GET['make'])->get();
    $data['makeid']=isset($_GET['make'])?$_GET['make']:'';
    $data['modelid']=isset($_GET['model'])?$_GET['model']:'';
    $data['modelinfo']=Models::where('id',$_GET['model'])->first();
    $data['brandinfo']=Make::where('id',$_GET['make'])->first();

    $data['search']= Lot::where('model_id',$_GET['model'])->orderBy('created_at','desc')->where('trading_date','>',$mytime->toDateTimeString())->with('lot')->take($data['per_page'])->get();
     $data['vehicletypeinfo']=$data['search'][0]->vehicle_type;
    }
     else if(isset($_GET['vehicletype']) && !empty($_GET['vehicletype'])){
    $data['search']= Lot::where('vehicle_type',$_GET['vehicletype'])
        ->orderBy('created_at','desc')->where('trading_date','>',$mytime->toDateTimeString())
        ->with('lot')->take($data['per_page'])->get();
     $data['vehicletypeinfo']=$_GET['vehicletype'];
     // dd($data['search']);
    }

    else{
      // dd($mytime->toDateTimeString());
         $data['search']= Lot::orderBy('created_at','asc')
                      ->where('vehicle_type','Automobile')
                    ->where('trading_date','>=',$mytime->toDateTimeString())
                    ->where('buy_now','=',0)
                    ->with('lot')->take(env('CATALOG_TOTAL'))->get();
      }
    
  
      $data['total']=count($data['search']);
      $data['search']= $data['search']->take($data['per_page']);
    // dd($data['total']);
     // dd($data['search']);

      
     $data['brand']=['COPART'=>"COPART",'IAAI'=>"IAAI"];  

    $country_id=$data['auction']->pluck('location');
    $state_id=$data['auction']->pluck('state');
    $data['state']=State::whereIn('country_id',$country_id)->get();
    $data['city']=City::whereIn('state_id',$state_id)->get();
    $brand=['search'=>'','brand'=>'','model'=>'','year'=>''];
    $section=array('search'=>'','data'=>$brand);
    Session::put('data', $section);
    return view("frontend.search.index",compact("data"));

   }

	public function savebookmark(Request $request){
		$data=$request->all();
         if($data['bookmark']==0){
         	$data['bookmark']=1;
         	$response=Bookmark::create($data);
         }else{
         	$data['bookmark']=0;
           $response=Bookmark::where('user_id',$data['user_id'])->where('lot_id',$data['lot_id'])->delete();
         }
        $response=array('response'=>$response);
        return json_encode($response);

	}

	public function bookmarks(){
		 $data['bookmark']=Bookmark::where('user_id',Auth::user()->id)->with('lot')->get();
        $id=0;
          if(Auth::check()){
            $id=Auth::user()->id;
          } 
        foreach($data['bookmark'] as $key=>$row){
            $row->bookmark=Bookmark::where('lot_id',$row->lot_id)->where('user_id',$id)->count();
        }
        // dd($data);
		return view('frontend.bookmarks.index', compact('data'));
	}

   public function getbrandmodels($lang,$id){
            // dd($id);
            $models= Models::where('make_id',$id)->orderBy('name')->get();
            // dd($states);
            $options='';
            foreach($models as $model){
              $options.='<option value='.$model->id.'>'.$model->name.'</option>';
            }
           // dd($options);
        return $options;
   } 
   public function getmultiplemodel(Request $request){
          $data=$request->all();
           
            $models= Models::whereIn('make_id',isset($data['id']) ? $data['id'] : [])->orderBy('name')->get();
            // dd($models);

            $options='';
            foreach($models as $model){
              $options.='<option value='.$model->id.'>'.$model->name.'</option>';
            }
           // dd($options);
        return $options;
   }  

   public function multiplefilter(Request $request){

          $data=$request->all();
           $data['offset']=1;
          Session::put('sidebarfilter',$data);
          Session::forget('data');
          $page=$request->page;
            $data['cur_page']=$request->page+1;
          
          if($page > 0){
            $page=$page-1;
          }
          $offset=$page*env('PER_PAGE');
          // dd($data['type']);
          $data['year']='1950';
          $data['year_to']='2099';
          $data['date_from']='1920-1-1';
          $data['date_to']='2099-12-12';

          if($request->year){
         $data['year'] =$request->year;
          } 
          if($request->year_to){
          $data['year_to']=$request->year_to;
          }

          if($request->year=="Any"){
          $data['year']='1950';
          }
            if($request->date_from ){
          $data['date_from']=$request->date_from;
          } 
          if($request->date_to){
          $data['date_to']=$request->date_to;
          }

          $data['mileage_min']='0';
          $data['mileage_max']='10000000';
          if($request->mileage_min){
            $data['mileage_min']=$request->mileage_min;
          }
          if($request->mileage_max){
          $data['mileage_max']=$request->mileage_max;
          }
          if($data['sort']=="Select"){$data['sort']='lot.created_at|asc';}
          $sort=explode("|", $data['sort']);
          $data['sort']=$sort[0];
          $data['sort_order']=$sort[1];
            // $yeartest=Lot::where('year','>=',$data['year'])->where('year','<=',$data['year_to'])->get();
            // dd($yeartest);
          // dd($sort[0]);
          // dd($data['excludeacution'],$data['excludetrading']);
          $unset_trading_date="0000-00-00 00:00:00";
          $mytime = Carbon::now();
          // dd($mytime->toDateTimeString());
          // dd($data['starting_price']);
          $query=Lot::with('lot')
          ->join('auctions','lot.auction_id','auctions.id')
          ->select('lot.*','auctions.start_date')
          ->where('year','>=',$data['year'])
          ->where('year','<=',$data['year_to'])
          ->whereBetween('odometer', [$data['mileage_min'], $data['mileage_max']])
          ->where('trading_date','>=',$data['date_from'])
          ->where('trading_date','<=',$data['date_to']);
          // ->where('trading_date','<',$mytime->toDateTimeString());
          // ->whereIn('auctions.state',$data['location'])
          // ->whereIn('auctions.city',$data['area']);
           if(isset($data['brand']) &&  !empty($data['brand'])){
              $data['search']=$query->whereIn('lot.brand',$data['brand']);
          }
           if(isset($data['make']) &&  !empty($data['make'])){
              $data['search']=$query->whereIn('make_id',$data['make']);
              $data['makename']=Make::whereIn('id',$data['make'])->get();
          }
           if(isset($data['model']) && !empty($data['model'])){
              $data['search']=$query->whereIn('model_id',$data['model']);
              $data['modelname']=Models::whereIn('id',$data['model'])->get();
          }
           if(isset($data['damage']) &&  !empty($data['damage'])){
              $data['search']=$query->whereIn('primary_damage',$data['damage']);
          }
          if(isset($data['buynowcheck']) &&  !empty($data['buynowcheck'])){
              // $data['search']=$query->whereNotNull('buy_now');
              $data['search']=$query->where('buy_now','>',0);
            if(isset($data['starting_price']) &&  !empty($data['starting_price'])){
              $data['search']=$query->where('buy_now','<=',$data['starting_price']);
              }
          }else{
              $data['search']=$query->where('buy_now','=',0);
          }
          if(isset($data['engine']) &&  !empty($data['engine'])){
          $data['search']=$query->whereIn('engine_type',$data['engine']);
          }
          if(isset($data['fuel_type']) &&  !empty($data['fuel_type'])){
          $data['search']=$query->whereIn('fuel',$data['fuel_type']);
          }
          if(isset($data['transmission']) &&  !empty($data['transmission'])){
          $data['search']=$query->whereIn('transmission',$data['transmission']);
          }
          if(isset($data['document_type']) &&  !empty($data['document_type']) ){
          $data['search']=$query->whereIn('lot.document_type',$data['document_type']);
          }
          if(isset($data['body_type']) &&  !empty($data['body_type']) ){
          $data['search']=$query->whereIn('lot.body_style',$data['body_type']);
          }
          if(isset($data['excludeacution']) &&  !empty($data['excludeacution'])){
            $data['search']=$query->where('trading_date','>',$mytime->toDateTimeString());
          }
          if(isset($data['excludetrading'])  &&  !empty($data['excludetrading'])){
              $data['search']=$query->where('trading_date','>',$unset_trading_date);
          }
          if(isset($data['type']) &&  !empty($data['type'])){
          $data['search']=$query->whereIn('lot.vehicle_type',$data['type']);
          }
          // dd($data['sort']);

           $data['per_page']=env('PER_PAGE');
           $data['search']=$query->offset($offset)->take($data['per_page'])->orderBy($data['sort'],$data['sort_order'])->get();

           // dd(count($data['search']));
           $data['total'] = count($data['search']);
           // dd($query->toSql());
         
    // dd($data['makename']);
           // dd( $data['total']);
           if($data['total']==0){
            $linktrigger=1;
           }else{
            $linktrigger=0;

           }
    $data['total']=count($query->take(env('CATALOG_TOTAL'))->get());

           // $data['total']=$query->count();
           $response= view("frontend.search.main_section",compact('data'))->render();
           $link= view("frontend.search.links",compact('data'))->render();
           $tags= view("frontend.search.tag",compact('data'))->render();
          $response=array('response'=>$response,"link"=>$link,'offset'=>$offset,'status'=>count($data['search']),'tags'=>$tags,'total_results'=>$data['search'],'linktrigger'=>$linktrigger,'pagination'=>$request->pagination);
          return json_encode($response);
   } 




}
?>