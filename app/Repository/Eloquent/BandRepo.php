<?php

namespace Repository\Eloquent;

use Mail, Validator, Crypt, Request, Input, DB;
use Repository\BandInterface;
use App\Models\Band;

use App\Models\BandConfiguration;


class BandRepo implements BandInterface
{

	public $bandId = '';
	public $finalarr = array();
    public $i=0;
    public $success;
    public $buyerId = '';
    public $bandConfId = '';

	public function getBands()
	{
		$query = Band::orderBy('name', 'Asc');
        
		if($this->bandId){
			$result = $query->where('id',$this->bandId)->first();
		}
		else{
			$result = $query->get();
		}
        return $result;
	}

	public function save($data) {
        $jsonArray['error'] = 'error';
        $rules = array('name' => 'required', 'manualDiscounting' => 'required');
        $validator = Validator::make($data->all(), $rules);
        if ($validator->fails()) {
            $messaages = $validator->messages();
            $this->success = false;
            return redirect()->route('bank.band.add')
                             ->withErrors($validator)
                             ->withInput();
        } 
        else{
                $band = Band::findOrNew($this->bandId);
                $band->name =$data->name;
                $band->discounting=$data->discounting;
                $band->manualDiscounting=$data->manualDiscounting;
                $band->autoDiscounting=$data->autoDiscounting;
                $band->status=$data->status;
                $band->save();
                $jsonArray['error'] = 'success';
                return $jsonArray;
        }
    }

    


    public function getBuyerData()
    {

        $buyerData = BandConfiguration::find($this->buyerId); 
       // return $buyerData;

       $join = BandConfiguration::join('companies','band_configurations.seller_id', '=', 'companies.id')
                    ->where('buyer_id',$this->buyerId)
                    ->select('band_configurations.id','companies.name','tax_percentage','payment_terms');
                    

        if($this->bandConfId)
            $join = $join->where('band_configurations.id',$this->bandConfId)->first();
        else
            $join = $join->paginate(15);


        return $join;

    }

    public function saveBuyerData($request)
    {
        $bandconfig = BandConfiguration::find($request->id);
        $bandconfig->tax_percentage=$request->taxPercentage;
        $bandconfig->payment_terms=$request->paymentTerms;
        $bandconfig->save();   
        return true;
    }



    public function bandmappingsave($request)
    {
         $bcId = BandConfiguration::where('buyer_id',$request->buyerId)   
                          ->where('seller_id',$request->sellerId)
                          ->first();
        
         //dd($request->bandId);
         if(isset($bcId->id)) 
            $bandconfig = BandConfiguration::find($bcId->id);

         else
            $bandconfig = new BandConfiguration;


         //$bandconfig = BandConfiguration::firstOrNew($bcId->id);
         $bandconfig->buyer_id=$request->buyerId;
         $bandconfig->seller_id=$request->sellerId;
         $bandconfig->band_id=$request->bandId;
         //dd($request->sellerId);
         $bandconfig = $bandconfig->save();
         return $bandconfig;
    }

    public function getbandmappingview()
    {
        /*$data = DB::table('band_configurations')
                 ->join('bands','bands.id','=','band_configurations.band_id')
                 ->join('companies','companies.id','=','band_configurations.buyer_id')
                 ->join('companies AS c1','c1.id','=','band_configurations.seller_id')
                 ->select('bands.name as bandName','companies.name as buyerName','c1.name as sellerName', 'band_configurations.tax_percentage', 'band_configurations.payment_terms')
                 ->get();
                
         return $data;*/

         /*---- raw query made in mysql-----
         select abc.buyerId, abc.buyerName, abc.sellerID, abc.sellerNAme, x.band_id, bands.name, 
         x.tax_percentage from band_configurations x JOIN bands ON x.band_id = bands.id 
         right join (select b.id as buyerId,b.name as buyer, a.id sellerID,a.name seller FROM companies as a JOIN companies b 
         on a.id <> b.id WHERE (a.industry="4" OR a.industry="5" ) and (b.industry="3"  OR b.industry='5')  as abc 
         ON abc.buyerId = x.buyer_id AND abc.sellerID = x.seller_id ORDER BY `x`.`band_id` 
         DESC, abc.buyer ASC
         ---- raw query made in mysql-----*/
        // dd(Input::get('buyerSearch'));
         $buyerID = roleId('Buyer');
         $sellerID = roleId('Seller');


         $bothID = roleId('Both');

         /* laravel query of above query*/
         $bandMapping = DB::table('band_configurations AS bd')
                             ->select('abc.buyerId', 'abc.buyerName', 'abc.sellerId', 'abc.sellerName', 'bd.band_id as bandId', 'bands.name as bandName', 'bands.discounting','bands.manualDiscounting','bands.autoDiscounting',
                             'bd.tax_percentage')
                             ->join('bands', 'bd.band_id', '=','bands.id')
                             //select b.id as buyerId,b.name as buyer, a.id sellerID,a.name seller FROM companies as a JOIN companies b on a.id <> b.id WHERE (a.industry="4" OR a.industry="5" ) and (b.industry="3"  OR b.industry='5') 
                             ->rightJoin(DB::raw("(select b.id buyerId,b.name buyerName, a.id sellerId,a.name sellerName FROM companies as a JOIN companies b on a.id <> b.id WHERE (a.industry=$sellerID OR a.industry=$bothID ) and (b.industry=$buyerID  OR b.industry=$bothID))as abc") , function($join)
                                        {
                                            $join->on('abc.buyerId','=','bd.buyer_id')
                                            ->on('abc.sellerID','=','bd.seller_id');
                                        })
                             ->orderBy('abc.buyerName', 'Asc')
                             ->orderBy('band_id', 'desc');


          if(Input::has('bandSearch')) {
            $bandsearch = Input::get('bandSearch');
            if($bandsearch == "notmapped")
                $bandsearch = null;
            
            $bandMapping->where('bd.band_id', $bandsearch)
                        ->get();
          }

          if(Input::has('buyerSearch')) {
            $buyerSearch = Input::get('buyerSearch');
            $bandMapping->orWhere('abc.buyerName', 'like', "$buyerSearch%");
                        // ->orWhere('abc.sellerName', 'like', "$buyerSellerSearch%");
           } 

           if(Input::has('sellersearch')){
            $sellersearch=Input::get('sellersearch');
            $bandMapping->orWhere('abc.sellerName','like',"$sellersearch%");


           }             
                        
          

         //dd($bandMapping->toSql());    
          $bandMapping = $bandMapping->paginate(15);

         
         $bandMapping->setPath(route('bank.band.bandMapping.view'));
         return $bandMapping;
    }


    public function getbandmappingdisplay($request)
    {    

          $inputs=$request->all();
          if(isset($request->bandmaplist)){

             foreach($request->bandmaplist as $val){
                 $band_id=$inputs["band_Id"];
                 $buyer_id=$inputs["buyerId_".$val];
                 $seller_id=$inputs["sellerId_".$val];
         //  dd($buyer_id,$seller_id);

                 $findQuery=BandConfiguration::select('id')
                                       ->where('seller_id',$seller_id)
                                       ->where('buyer_id',$buyer_id)->first();
       
                  if(!empty($findQuery->id)){
                     $query=DB::table('band_configurations')
                                ->where('id',$findQuery->id)
                                ->update(['band_id'=>$band_id]);
                                  
                    }else{
                         //dd($buyer_id,$seller_id);
                            $query=new BandConfiguration;
                            $query->band_id=$band_id;
                            $query->buyer_id=$buyer_id;
                            $query->seller_id=$seller_id;
                            $query->save();
                     }   
                } 
                     return $query;  
            }   
                
          }
      }       
        
         
         
       
    



  





