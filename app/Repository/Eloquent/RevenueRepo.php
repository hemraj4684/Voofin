<?php

namespace Repository\Eloquent;

use Mail, Validator, Crypt, Request, Input, DB, Session;
use App\Models\RevenueSharing;
use Repository\RevenueInterface;

//use App\Models\BandConfiguration;
class RevenueRepo implements RevenueInterface
{
   public $buyerId='';
   public function getrevenueshareview()
  {
    
      $revenuesharemap=DB::table('companies')
                              ->leftJoin('revenue_sharing','revenue_sharing.company_id','=','companies.id')
                              ->select('revenue_sharing.*', 'companies.id as comId','companies.name')
                              ->whereIn('industry',[roleId('Buyer'),roleId('Both')]);
           
          if(Input::has('buyersearch')){
              $buyersearch=Input::get('buyersearch');
              $revenuesharemap->Where('companies.name','like',"%$buyersearch%");
           }


           $revenuesharemap = $revenuesharemap->get();
           //dd($revenuesharemap);
            return $revenuesharemap;              
  }

  public function save_revenue_share($request)
  {
      
      // dd($request->revenueshare);
      $getdata=RevenueSharing::firstOrCreate(['company_id' => $request->companyId]);
      $getdata->company_id= $request->companyId;
      $getdata->organization=$request->companyName;
      $getdata->share_percent=$request->sharepercent;
      if($request->revenueshare)
      {
        $getdata->applicable =$request->revenueshare;
      }else
      {
        $getdata->applicable =0;
      }

      if($request->revenueshare == 0)
      {
        $getdata->share_percent = 0;
      }
      if(empty($request->sharepercent) ){
       
        Session::flash('revenueMessage',' Please Enter Revenue share');
      }else{
        $getdata->save();
      }
      


      // else{
      // $getdata->applicable = 0;
      // }
      // if(!empty($request->sharepercent)){
      // $getdata->share_percent=0;
      // }else
      // {
      //    $getdata->share_percent=$request->sharepercent;
      // }

      
    
      return $getdata;                          
    
  }

}