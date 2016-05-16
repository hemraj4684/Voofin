<?php
namespace Repository\Eloquent;

use Mail, Validator, Crypt, Request, Input;
use Uuid, Session;
use Repository\FundingInterface;
use App\Models\Company;
use DB,URL;

class FundingRepo implements FundingInterface
{
  public function getfundinglimitview()
  {
    $fundinglimits=DB::table('companies')
    					            ->join('users','contact_user_id','=','users.id') 	
                          ->join('roles','users.role_id','=','roles.id')

                          ->leftJoin('payment_instructions as pi', function ($join) {
                                $join->on('pi.seller_id','=','companies.id')->orOn('pi.buyer_id','=','companies.id');
                            })
                          ->leftjoin('discountings as d','d.pi_id','=','pi.id')
                          ->selectRaw('sum(d.loan_amount) as Total, companies.name , roles.type ,companies.id as compID , companies.buyer_limit,companies.seller_limit,pi.seller_id,pi.buyer_id')
                          ->WhereIn('roles.type',[roleId('Buyer'),roleId('Both'),roleId('Seller')])
                          // ->whereIn('d.status',[0,1])
                          ->groupBy('companies.id');
                          

                          if(Input::has('rolesearch')){
                           $rolesearch=Input::get('rolesearch');
                           $fundinglimits->Where('companies.name','like',"%$rolesearch%");
                            }
                           $fundinglimits=$fundinglimits->get();

                           return $fundinglimits;
                          
 }
                          
                        
 

  public function savefundinglimit($request)
   {

     $savefundlimit=company::find($request->companyId);
       if($request->buyer_approved_limit){
          $savefundlimit->buyer_limit = $request->buyer_approved_limit;
        }
       elseif($request->seller_approved_limit){
          $savefundlimit->seller_limit=$request->seller_approved_limit;
        }
     
        $savefundlimit=$savefundlimit->save();
    
   }     
    

    
   

      
    public function pipeline_request()
    {
       $pipeline_request=DB::table('companies')
                          ->join('users','contact_user_id','=','users.id')  
                          ->join('roles','users.role_id','=','roles.id')

                          ->leftJoin('payment_instructions as pi', function ($join) {
                                $join->on('pi.seller_id','=','companies.id')->orOn('pi.buyer_id','=','companies.id');
                            })
                          ->leftjoin('discountings as d','d.pi_id','=','pi.id')
                          ->selectRaw('sum(d.loan_amount) as total, companies.name , roles.type ,companies.id as compID , companies.buyer_limit,companies.seller_limit,pi.seller_id,pi.buyer_id')
                          //->WhereIn('roles.type',[roleId('Buyer'),roleId('Both'),roleId('Seller')])
                          ->whereIn('d.status',[0,1,2])
                          ->groupBy('companies.id')
                          ->get();

                          
                           return $pipeline_request ;
      

    }


    // public function available_limit()
    // {
    //    $available_limit=DB::table('companies')
    //                            ->join('users','contact_user_id');


    // }

}