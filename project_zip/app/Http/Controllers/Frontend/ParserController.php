<?php
namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting\Settings;
use App\Models\Lot\Lot;
use App\Models\Lot\FileUpload;
use App\Models\Model\Make;
use App\Models\Model\Models;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
class ParserController extends Controller
{
	public function copylotdata(){
		$url = 'https://carsfromwest.com/api/auction/lots?auctions=copart%2Ciaai&type=AM&yearMin=2022&yearMax=2022&onlyActive=true&page=1';
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HEADER, false);
		$data = curl_exec($curl);
		curl_close($curl);
		$lot_data = json_decode($data);
		// dd($lot_data->data);
		foreach ($lot_data->data as $key => $value) {
       // dd($value->attributes);

			$lot_no = Lot::where('lot_no',$value->attributes->auctionLotId)->first();
      //dd($lot_no);
			if(empty($lot_no))
			{
				$make_id=null;
				$model_id=null;
				$make=isset($value->attributes->lotData->make) ? $value->attributes->lotData->make : '-1';
				$model=isset($value->attributes->lotData->model) ? $value->attributes->lotData->model : '-1';
				$make=Make::where('name',$make)->first();
				if(!empty($make)){
					$make_id=$make->id;
					$modeldata=Models::where('name',$model)->where('make_id',$make_id)->first();
					if(!empty($modeldata)){
						$model_id=$modeldata->id;
					}else{
						$data=array('name'=>$model,'make_id'=>$make_id);
						$model=Models::Create($data);
						$model_id=$model->id;
					}

				}else{
					if(isset($value->attributes->lotData->make)){
						$data=array('name'=>$value->attributes->lotData->make);
						$make=Make::Create($data);
						$make_id=$make->id;
						$data=array('name'=>$model,'make_id'=>$make_id);
						$model=Models::Create($data);
						$model_id=$model->id;
					}
				}


				$lot_images = $value->attributes->lotData->images;
				$lotData = $value->attributes->lotData;
				$feature_image = $lot_images[0]->i;
				$sale=$lotData->sale;
				$saleDocument=$sale->saleDocument;
				$seller=$sale->seller;
				$branch=$sale->branch;
				$lotinfo=$lotData->info;
				$madeyear=$lotData->year;
				// dd($madeyear);
				$odometer="N/A";
				if(isset($lotinfo->odometer->unit)){
					$odometer="";
					$mileage="";
					$odometer=$lotinfo->odometer->value;
					$mileage=$lotinfo->odometer->value.' '.$lotinfo->odometer->unit;
					if($lotinfo->odometer->status==1){
						$mileage.='(actual)';
					}else{
						$mileage.='(not actual)';
					}
				}

				if(isset($lotinfo->fuelType) && $lotinfo->fuelType==1){
					$fuelType='Gas';
				}
				else if(isset($lotinfo->fuelType) && $lotinfo->fuelType==2){
					$fuelType='Petrol';
				}else{
					$fuelType='N/A';
				}

				if(isset($lotinfo->transmissionType) && $lotinfo->transmissionType==1){
					$transmissionType='Manual';
				}
				else if(isset($lotinfo->transmissionType) && $lotinfo->transmissionType==2){
					$transmissionType='Automatic';
				}
				else if(isset($lotinfo->transmissionType) && $lotinfo->transmissionType==3){
					$transmissionType='Continuously variable';
				}
				else if(isset($lotinfo->transmissionType) && $lotinfo->transmissionType==4){
					$transmissionType='Semi-automatic and dual-clutch';
				}
				else{
					$transmissionType='N/A';
				}

				if(isset($lotinfo->drivelineType) && $lotinfo->drivelineType==1){
					$drivelineType='FWD';
				}
				else if(isset($lotinfo->drivelineType) && $lotinfo->drivelineType==2){
					$drivelineType='RWD';
				}
				else if(isset($lotinfo->drivelineType) && $lotinfo->drivelineType==3){
					$drivelineType='4WD';
				}
				else if(isset($lotinfo->drivelineType) && $lotinfo->drivelineType==4){
					$drivelineType='AWD';
				}
				else{
					$drivelineType='N/A';
				}

				if(isset($saleDocument->group) && $saleDocument->group==1){
					$saleDocument='Clean title';
				}
				else if(isset($saleDocument->group) && $saleDocument->group==2){
					$saleDocument='Salvage title';
				}
				else if(isset($saleDocument->group) && $saleDocument->group==3){
					$saleDocument='Non repairable';
				}
				else if(isset($saleDocument->group) && $saleDocument->group==4){
					$saleDocument='Other';
				}
				else{
					$saleDocument='N/A';
				}

				$lot_array = array(
					'lot_title'=>$lotData->make.' '.$lotData->model,
					'feature_image'=>$feature_image,
					'lot_no'=>isset($value->attributes->auctionLotId)? $value->attributes->auctionLotId:'',
					'trading_date'=>isset($value->attributes->auctionDate) ? $value->attributes->auctionDate:'' ,
					'vin'=>isset($value->attributes->lotData->vin)? $value->attributes->lotData->vin:'',
					'insurance'=>isset($seller->insurance) ? $seller->insurance : '',
					'seller'=>isset($seller->displayName) ? $seller->displayName:'',
					'brand'=>strtoupper($value->attributes->auction),
					'auction_id'=>$value->attributes->auction=='iaai' ? 2 : 4,
					'status'=>'Approved',
					'make_id'=>$make_id,
					'model_id'=>$model_id,
					'repair_cost'=>isset($sale->repairCost) ? $sale->repairCost :'' ,
					'starting_price'=>isset($sale->currentBid) ? $sale->currentBid :'' ,
					'est_retail_value'=>isset($sale->retailPrice) ? $sale->retailPrice :'',
					'buy_now'=>isset($sale->buyNowPrice) ? $sale->buyNowPrice :'',
					'document_type'=>$saleDocument,
					'primary_damage'=>isset($lotinfo->primaryDamage) ? $lotinfo->primaryDamage :'',
					'secondary_damage'=>isset($lotinfo->secondaryDamage) ? $lotinfo->secondaryDamage :'N/A',
					'country'=>isset($branch->country) ? $branch->country :'',
					'state'=>isset($branch->state) ? $branch->state :'',
					'city'=>isset($branch->city) ? $branch->city :'',
					'zip'=>isset($branch->zip) ? $branch->zip :'',
					'locationName'=>isset($branch->locationName) ? $branch->locationName :'',
					'odometer'=> $odometer,
					'mileage'=> isset($mileage)?$mileage:'',
					'fuel'=>$fuelType,
					'sold'=>$sale->sold==true?1:0,
					'transmission'=>$transmissionType,
					'drivelineType'=>$drivelineType,
					'cylinder'=>isset($lotinfo->engine->cylinders) ? $lotinfo->engine->cylinders :'N/A',
					'body_style'=>isset($lotinfo->bodyStyle) ? $lotinfo->bodyStyle :'',
					'color'=>isset($lotinfo->color) ? $lotinfo->color :'' ,
					'key'=>isset($lotinfo->keys) ? $lotinfo->keys :'',
					'engine_type'=>isset($lotinfo->engine->capacity) ? isset($lotinfo->engine->type) ? $lotinfo->engine->type : ''.$lotinfo->engine->capacity :'N/A',
					'vehicleCondition'=>isset($lotinfo->vehicleCondition) ? $lotinfo->vehicleCondition :'',
					'brand_logo'=>$value->attributes->auction=='iaai' ? '/public/uploads/lot/1078137875.jpg' :'/public/uploads/lot/1081035701.jpg'
				);
      // dd($lot_array);
				$affected_rows =  Lot::create($lot_array);
				$id=$affected_rows->id;
				foreach ($lot_images as $key => $value) {
					$parser =1;
					$data = array('lot_id'=>$id,'images'=>$value->i,'parser'=>1,'thumbnail'=>$value->t);
					FileUpload::create($data);
				}
			}
		}
		dd('Import Completed');
		return redirect()->back();
	}



	public function manualparser(Request $request){
		$data1=$request->all();
		$url = 'https://carsfromwest.com/api/auction/lots?auctions='.$data1['type'].'&type='.$data1['vehicle_type'].'&yearMin='.$data1['year'].'&yearMax='.$data1['year'].'&onlyActive=true&page='.$data1['page'].'';
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HEADER, false);
		$data = curl_exec($curl);
		curl_close($curl);
		$lot_data = json_decode($data);
    // dd($lot_data->data);


		foreach ($lot_data->data as $key => $value) {
       // dd($value->attributes);

			$lot_no = Lot::where('lot_no',$value->attributes->auctionLotId)->first();
      //dd($lot_no);

			$make_id=null;
			$model_id=null;
			$make=isset($value->attributes->lotData->make) ? $value->attributes->lotData->make : '-1';
			$model=isset($value->attributes->lotData->model) ? $value->attributes->lotData->model : '-1';
			$make=Make::where('name',$make)->first();
			if(!empty($make)){
				$make_id=$make->id;
				$modeldata=Models::where('name',$model)->where('make_id',$make_id)->first();
				if(!empty($modeldata)){
					$model_id=$modeldata->id;
				}else{
					$data=array('name'=>$model,'make_id'=>$make_id);
					$model=Models::Create($data);
					$model_id=$model->id;
				}

			}else{
				if(isset($value->attributes->lotData->make)){
					$data=array('name'=>$value->attributes->lotData->make);
					$make=Make::Create($data);
					$make_id=$make->id;
					$data=array('name'=>$model,'make_id'=>$make_id);
					$model=Models::Create($data);
					$model_id=$model->id;
				}
			}


			$lot_images = $value->attributes->lotData->images;
			$lotData = $value->attributes->lotData;
			$feature_image = $lot_images[0]->i;
			$sale=$lotData->sale;
			$saleDocument=isset($sale->saleDocument)?$sale->saleDocument:'';
			$seller=$sale->seller;
			$sold=$sale->sold;
			$branch=$sale->branch;
			$lotinfo=$lotData->info;
        	$madeyear=$lotData->year;

			$odometer="N/A";
			if(isset($lotinfo->odometer->unit)){
				$odometer="";
				$mileage="";
				$odometer=$lotinfo->odometer->value;
				$mileage=$lotinfo->odometer->value.' '.$lotinfo->odometer->unit;
				if(isset($lotinfo->odometer->status)==1){
					$mileage.='(actual)';
				}else{
					$mileage.='(not actual)';
				}
			}

			if(isset($lotinfo->fuelType) && $lotinfo->fuelType==1){
				$fuelType='Gas';
			}
			else if(isset($lotinfo->fuelType) && $lotinfo->fuelType==2){
				$fuelType='Petrol';
			}else{
				$fuelType='N/A';
			}

			if(isset($lotinfo->transmissionType) && $lotinfo->transmissionType==1){
				$transmissionType='Manual';
			}
			else if(isset($lotinfo->transmissionType) && $lotinfo->transmissionType==2){
				$transmissionType='Automatic';
			}
			else if(isset($lotinfo->transmissionType) && $lotinfo->transmissionType==3){
				$transmissionType='Continuously variable';
			}
			else if(isset($lotinfo->transmissionType) && $lotinfo->transmissionType==4){
				$transmissionType='Semi-automatic and dual-clutch';
			}
			else{
				$transmissionType='N/A';
			}

			if(isset($lotinfo->drivelineType) && $lotinfo->drivelineType==1){
				$drivelineType='FWD';
			}
			else if(isset($lotinfo->drivelineType) && $lotinfo->drivelineType==2){
				$drivelineType='RWD';
			}
			else if(isset($lotinfo->drivelineType) && $lotinfo->drivelineType==3){
				$drivelineType='4WD';
			}
			else if(isset($lotinfo->drivelineType) && $lotinfo->drivelineType==4){
				$drivelineType='AWD';
			}
			else{
				$drivelineType='N/A';
			}

			if(isset($saleDocument->group) && $saleDocument->group==1){
				$saleDocument='Clean title';
			}
			else if(isset($saleDocument->group) && $saleDocument->group==2){
				$saleDocument='Salvage title';
			}
			else if(isset($saleDocument->group) && $saleDocument->group==3){
				$saleDocument='Non repairable';
			}
			else if(isset($saleDocument->group) && $saleDocument->group==4){
				$saleDocument='Other';
			}
			else{
				$saleDocument='N/A';
			}  


			if ($data1['vehicle_type']=="AM") {
				$vehicle_type='Automobile';
			}else if($data1['vehicle_type']=="ATV"){
				$vehicle_type='ATV';
			}else if($data1['vehicle_type']=="BT"){
				$vehicle_type='Boat';
			}else if($data1['vehicle_type']=="BUS"){
				$vehicle_type='Bus, minibus';
			}else if($data1['vehicle_type']=="IEQ"){
				$vehicle_type='Industrial equipment';
			}else if($data1['vehicle_type']=="JSK"){
				$vehicle_type='Jet ski';
			}else if($data1['vehicle_type']=="MC"){
				$vehicle_type='Motorcycle';
			}else if($data1['vehicle_type']=="RVE"){
				$vehicle_type='Recreational vehicle';
			}else if($data1['vehicle_type']=="SNM"){
				$vehicle_type='Snowmobile';
			}else if($data1['vehicle_type']=="TL"){
				$vehicle_type='Trailer';
			}else if($data1['vehicle_type']=="TR"){
				$vehicle_type='Truck';
			}else if($data1['vehicle_type']=="OTR"){
				$vehicle_type='Other';
			}
      // dd($data1);

			$lot_array = array(
				'lot_title'=>$lotData->make.' '.$lotData->model,
				'feature_image'=>$feature_image,
				'lot_no'=>isset($value->attributes->auctionLotId)? $value->attributes->auctionLotId:'',
				'trading_date'=>isset($value->attributes->auctionDate) ? $value->attributes->auctionDate:'' ,
				'vin'=>isset($value->attributes->lotData->vin)? $value->attributes->lotData->vin:'',
				'insurance'=>isset($seller->insurance) ? $seller->insurance : '',
				'seller'=>isset($seller->displayName) ? $seller->displayName:'',
				'brand'=>strtoupper($value->attributes->auction),
				'auction_id'=>$value->attributes->auction=='iaai' ? 2 : 4,
				'status'=>'Approved',
				'make_id'=>$make_id,
				'model_id'=>$model_id,
				'repair_cost'=>isset($sale->repairCost) ? $sale->repairCost :'' ,
				'starting_price'=>isset($sale->currentBid) ? $sale->currentBid :'' ,
				'est_retail_value'=>isset($sale->retailPrice) ? $sale->retailPrice :'',
				'buy_now'=>isset($sale->buyNowPrice) ? $sale->buyNowPrice :'',
				'document_type'=>$saleDocument,
				'primary_damage'=>isset($lotinfo->primaryDamage) ? $lotinfo->primaryDamage :'',
				'secondary_damage'=>isset($lotinfo->secondaryDamage) ? $lotinfo->secondaryDamage :'N/A',
				'country'=>isset($branch->country) ? $branch->country :'',
				'state'=>isset($branch->state) ? $branch->state :'',
				'city'=>isset($branch->city) ? $branch->city :'',
				'zip'=>isset($branch->zip) ? $branch->zip :'',
				'locationName'=>isset($branch->locationName) ? $branch->locationName :'',
				'odometer'=> $odometer,
				'mileage'=> isset($mileage)?$mileage:'',
				'fuel'=>$fuelType,
				'sold'=>$sold,
				'transmission'=>$transmissionType,
				'drivelineType'=>$drivelineType,
				'cylinder'=>isset($lotinfo->engine->cylinders) ? $lotinfo->engine->cylinders :'',
				'body_style'=>isset($lotinfo->bodyStyle) ? $lotinfo->bodyStyle :'',
				'color'=>isset($lotinfo->color) ? $lotinfo->color :'' ,
				'key'=>isset($lotinfo->keys) ? $lotinfo->keys :'',
				'engine_type'=>isset($lotinfo->engine->capacity) ? isset($lotinfo->engine->type) ? $lotinfo->engine->type : ''.$lotinfo->engine->capacity :'',
				'vehicleCondition'=>isset($lotinfo->vehicleCondition) ? $lotinfo->vehicleCondition :'',
				'brand_logo'=>$value->attributes->auction=='iaai' ? '/public/uploads/lot/1078137875.jpg' :'/public/uploads/lot/1081035701.jpg',
				'vehicle_type'=>isset($vehicle_type)?$vehicle_type:'',
				'year'=>isset($madeyear)?$madeyear:''
			);
			if(empty($lot_no))
			{

      // dd($lot_array);
				$affected_rows =  Lot::create($lot_array);
				$id=$affected_rows->id;
				$lotIDs[]=$id;
				foreach ($lot_images as $key => $value) {
					$parser =1;
					$data = array('lot_id'=>$id,'images'=>$value->i,'parser'=>1,'thumbnail'=>$value->t);
					FileUpload::create($data);
				}
			}else{
				$affected_rows =  Lot::where('id',$lot_no->id)->update($lot_array);
				$lotIDs[]=$lot_no->id;
			}
		}


		// dd($lotIDs);
		$message['title']= 'Success';
		$message['text'] = 'Parser Data Fetched Successfully';
		$data=[];
		$data['page_title']='Parsed Lots';
		$data['results']=Lot::wherein('id',$lotIDs)->get();
		Session::put('message', $message);
		return view('parser.index',compact('data'));
      // dd('Import Completed');
		return redirect()->back();
	}

	public function autoparser(){

		
		$currentYear=date('Y');
		$auctionTypes=array('copart','iaai');
		$vehicleTypes=array('AM','ATV','BT','BUS','IEQ','JSK','MC','RVE','SNM','TL','TR','OTR');
	    // $auctionTypes=array('copart');
	    if(isset($_GET['yearMin'])){
			$yearMin=$_GET['yearMin'];
	    }
	    if(isset($_GET['yearMax'])){
			$yearMax=$_GET['yearMax'];
	    }
	    if(isset($_GET['vehicleTypes'])){
	    $vehicleTypes=array($_GET['vehicleTypes']);
	    }
	      if(isset($_GET['auctionTypes'])){
	       $auctionTypes=array($_GET['auctionTypes']);
	    }

	    // dd($auctionTypes);
		foreach ($auctionTypes as  $auctionType) {
			for($year=$yearMax; $year>=$yearMin; $year--){
				foreach ($vehicleTypes as  $vehicleType) {
					for($page=1; $page<=40; $page++){
						$url = 'https://carsfromwest.com/api/auction/lots?auctions='.$auctionType.'&type='.$vehicleType.'&yearMin='.$year.'&yearMax='.$year.'&onlyActive=true&page='.$page.'';
						$curl = curl_init();
						curl_setopt($curl, CURLOPT_URL, $url);
						curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
						curl_setopt($curl, CURLOPT_HEADER, false);
						$data = curl_exec($curl);
						curl_close($curl);
						$lot_data = json_decode($data);
    // dd($lot_data->data);
						foreach ($lot_data->data as $key => $value) {
       // dd($value->attributes);
							$lot_no = Lot::where('lot_no',$value->attributes->auctionLotId)->first();
      //dd($lot_no);

								$make_id=null;
								$model_id=null;
								$make=isset($value->attributes->lotData->make) ? $value->attributes->lotData->make : '-1';
								$model=isset($value->attributes->lotData->model) ? $value->attributes->lotData->model : '-1';
								$make=Make::where('name',$make)->first();
								if(!empty($make)){
									$make_id=$make->id;
									$modeldata=Models::where('name',$model)->where('make_id',$make_id)->first();
									if(!empty($modeldata)){
										$model_id=$modeldata->id;
									}else{
										$data=array('name'=>$model,'make_id'=>$make_id);
										$model=Models::Create($data);
										$model_id=$model->id;
									}

								}else{
									if(isset($value->attributes->lotData->make)){
										$data=array('name'=>$value->attributes->lotData->make);
										$make=Make::Create($data);
										$make_id=$make->id;
										$data=array('name'=>$model,'make_id'=>$make_id);
										$model=Models::Create($data);
										$model_id=$model->id;
									}
								}


								$lot_images = isset($value->attributes->lotData->images)?$value->attributes->lotData->images:'';
								$lotData = $value->attributes->lotData;
								$feature_image = isset($lot_images[0]->i)?$lot_images[0]->i:'';
								$sale=$lotData->sale;
								$saleDocument=isset($sale->saleDocument)?$sale->saleDocument:'';
								$seller=isset($sale->seller)?$sale->seller:'';
								$sold=$sale->sold;
								$branch=$sale->branch;
								$lotinfo=$lotData->info;
								$odometer="N/A";
			                	$madeyear=$lotData->year;

								if(isset($lotinfo->odometer->unit)){
									$odometer="";
									$mileage="";
									$odometer=$lotinfo->odometer->value;
									$mileage=$lotinfo->odometer->value.' '.$lotinfo->odometer->unit;
									if(isset($lotinfo->odometer->status)==1){
										$mileage.='(actual)';
									}else{
										$mileage.='(not actual)';
									}
								}

								if(isset($lotinfo->fuelType) && $lotinfo->fuelType==1){
									$fuelType='Gas';
								}
								else if(isset($lotinfo->fuelType) && $lotinfo->fuelType==2){
									$fuelType='Petrol';
								}else{
									$fuelType='N/A';
								}

								if(isset($lotinfo->transmissionType) && $lotinfo->transmissionType==1){
									$transmissionType='Manual';
								}
								else if(isset($lotinfo->transmissionType) && $lotinfo->transmissionType==2){
									$transmissionType='Automatic';
								}
								else if(isset($lotinfo->transmissionType) && $lotinfo->transmissionType==3){
									$transmissionType='Continuously variable';
								}
								else if(isset($lotinfo->transmissionType) && $lotinfo->transmissionType==4){
									$transmissionType='Semi-automatic and dual-clutch';
								}
								else{
									$transmissionType='N/A';
								}

								if(isset($lotinfo->drivelineType) && $lotinfo->drivelineType==1){
									$drivelineType='FWD';
								}
								else if(isset($lotinfo->drivelineType) && $lotinfo->drivelineType==2){
									$drivelineType='RWD';
								}
								else if(isset($lotinfo->drivelineType) && $lotinfo->drivelineType==3){
									$drivelineType='4WD';
								}
								else if(isset($lotinfo->drivelineType) && $lotinfo->drivelineType==4){
									$drivelineType='AWD';
								}
								else{
									$drivelineType='N/A';
								}

								if(isset($saleDocument->group) && $saleDocument->group==1){
									$saleDocument='Clean title';
								}
								else if(isset($saleDocument->group) && $saleDocument->group==2){
									$saleDocument='Salvage title';
								}
								else if(isset($saleDocument->group) && $saleDocument->group==3){
									$saleDocument='Non repairable';
								}
								else if(isset($saleDocument->group) && $saleDocument->group==4){
									$saleDocument='Other';
								}
								else{
									$saleDocument='N/A';
								}  


								if ($vehicleType=="AM") {
									$vehicle_type='Automobile';
								}else if($vehicleType=="ATV"){
									$vehicle_type='ATV';
								}else if($vehicleType=="BT"){
									$vehicle_type='Boat';
								}else if($vehicleType=="BUS"){
									$vehicle_type='Bus, minibus';
								}else if($vehicleType=="IEQ"){
									$vehicle_type='Industrial equipment';
								}else if($vehicleType=="JSK"){
									$vehicle_type='Jet ski';
								}else if($vehicleType=="MC"){
									$vehicle_type='Motorcycle';
								}else if($vehicleType=="RVE"){
									$vehicle_type='Recreational vehicle';
								}else if($vehicleType=="SNM"){
									$vehicle_type='Snowmobile';
								}else if($vehicleType=="TL"){
									$vehicle_type='Trailer';
								}else if($vehicleType=="TR"){
									$vehicle_type='Truck';
								}else if($vehicleType=="OTR"){
									$vehicle_type='Other';
								}
     					 // dd($data1);
								$lot_array = array(
									'lot_title'=>$madeyear.' '.$lotData->make.' '.$lotData->model,
									'feature_image'=>$feature_image,
									'lot_no'=>isset($value->attributes->auctionLotId)? $value->attributes->auctionLotId:'',
									'trading_date'=>isset($value->attributes->auctionDate) ? $value->attributes->auctionDate:'' ,
									'vin'=>isset($value->attributes->lotData->vin)? $value->attributes->lotData->vin:'',
									'insurance'=>isset($seller->insurance) ? $seller->insurance : '',
									'seller'=>isset($seller->displayName) ? $seller->displayName:'N/A',
									'brand'=>strtoupper($value->attributes->auction),
									'auction_id'=>$value->attributes->auction=='iaai' ? 2 : 4,
									'status'=>'Approved',
									'make_id'=>$make_id,
									'model_id'=>$model_id,
									'repair_cost'=>isset($sale->repairCost) ? $sale->repairCost :'' ,
									'starting_price'=>isset($sale->currentBid) ? $sale->currentBid :'' ,
									'est_retail_value'=>isset($sale->retailPrice) ? $sale->retailPrice :'',
									'buy_now'=>isset($sale->buyNowPrice) ? $sale->buyNowPrice :'',
									'document_type'=>$saleDocument,
									'primary_damage'=>isset($lotinfo->primaryDamage) ? $lotinfo->primaryDamage :'',
									'secondary_damage'=>isset($lotinfo->secondaryDamage) ? $lotinfo->secondaryDamage :'N/A',
									'country'=>isset($branch->country) ? $branch->country :'',
									'state'=>isset($branch->state) ? $branch->state :'',
									'city'=>isset($branch->city) ? $branch->city :'',
									'zip'=>isset($branch->zip) ? $branch->zip :'',
									'locationName'=>isset($branch->locationName) ? $branch->locationName :'',
									'odometer'=> $odometer,
									'mileage'=> isset($mileage)?$mileage:'',
									'fuel'=>$fuelType,
									'sold'=>$sold,
									'transmission'=>$transmissionType,
									'drivelineType'=>$drivelineType,
									'cylinder'=>isset($lotinfo->engine->cylinders) ? $lotinfo->engine->cylinders :'N/A',
									'body_style'=>isset($lotinfo->bodyStyle) ? $lotinfo->bodyStyle :'N/A',
									'color'=>isset($lotinfo->color) ? $lotinfo->color :'N/A' ,
									'key'=>isset($lotinfo->keys) ? $lotinfo->keys :'',
									'engine_type'=>isset($lotinfo->engine->capacity) ? isset($lotinfo->engine->type) ? $lotinfo->engine->type : ''.$lotinfo->engine->capacity :'',
									'vehicleCondition'=>isset($lotinfo->vehicleCondition) ? $lotinfo->vehicleCondition :'',
									'brand_logo'=>$value->attributes->auction=='iaai' ? '/public/uploads/lot/1078137875.jpg' :'/public/uploads/lot/1081035701.jpg',
									'vehicle_type'=>isset($vehicle_type)?$vehicle_type:'',
									'year'=>isset($madeyear)?$madeyear:''
								);
      // dd($lot_array);
								if(empty($lot_no))
							{
								// $last_inserted_id=[];
								$affected_rows =  Lot::create($lot_array);
								$id=$affected_rows->id;
								$lotIDs[]=$id;
								$last_inserted_id=['id'=>$id];
								foreach ($lot_images as $key => $value) {
									$parser =1;
									$data = array('lot_id'=>$id,'images'=>$value->i,'parser'=>1,'thumbnail'=>$value->t);
									FileUpload::create($data);
								}
							}else{
								$affected_rows =  Lot::where('id',$lot_no->id)->update($lot_array);
								$lotIDs[]=$lot_no->id;
							}
							sleep(1);
						}
					}
				}
			}

			if(!Auth::check()){
				dd('Data Imported');
			}

			
		$message['title']= 'Success';
		$data=[];
		$data['page_title']='Parsed Lots';
		$message['text'] = 'Data Parsed Successfully';
		if(!empty($lotIDs)){
		$data['results']=Lot::wherein('id',$lotIDs)->get();
		}else{
		$data['results']=[];
		$message['text'] = 'No Data Found for this query';
		}
		Session::put('message', $message);
		return view('parser.index',compact('data'));
      // dd('Import Completed');
			return redirect(app()->getLocale().'/admin/home');;
		}
}

		public function parser(){
			$data['page_title'] = "Manual Parser";
			return view('parser.save',compact('data'));

		}


		public function copylotdata1()
		{
			        $ch = curl_init();
        $uri='https://carsfromwest.com/api/fee/lot-fees-calculation/copart-42411172?winningAmount=12200';
			curl_setopt($ch, CURLOPT_URL, $uri); //$uri is the same that I use in terminal
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, array());
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			$headers = array(
			    'Content-Type: application/xml', //expect an xml response
			);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			$curl_result = curl_exec($ch);

			        dd($curl_result);
		}
}
	?>