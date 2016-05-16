<?php

namespace Repository\Eloquent;
use Repository\ BankInterface;
use App\Models\User;
use App\Models\Role;
class BankRepo implements BankInterface{
public $roleID = '';

  public function getData(){
  	
  }


  public function bankconfigurationsave($request)
  {
    $basic_configuration = array( 
                               "bank_base_rate"=>$request->bank_base_rate,
   	                           "auto_approve_finance"=>$request->auto_approve_finance,
   	                           "edit_maturity_date"=>$request->edit_maturity_date,
                               "no_of_days"=>$request->no_of_days,
                               "compoundFrequency"=>$request->compoundFrequency,
                               "min_dis_days"=>$request->minDisDays,
                               "max_dis_days"=>$request->maxDisDays
   	                        );

    $maker_checkers = array(
                        "discounting_request_approval"=>$request->disc_req_appr,
                        "buyer_supplier_creation"=>$request->buyer_supplier_creation
  	                  );
 
   $a = count($request->name);  //counts the no of text box used.
   $name = $request->name;//getting input value from name textbox.
   $value = $request->value;//getting input value from value textbox.
   $type = $request->type; //getting type value from type drop down.
   // print_r($type);exit;
   $description = $request->description;//getting input value from description text box
   $discounting_fees = array();//array defined
                
    for($i=0;$i<$a;$i++) 
    {
      $value[$i] = array(
                    'name'=>$name[$i],
                    'value'=>$value[$i],
                    'type'=>$type[$i],
                    'description'=>$description[$i]
                   );

      array_push($discounting_fees, $value[$i]);
    }
                
    $bankconfig = array(
                       "basic_configuration"=>$basic_configuration,
                       "maker_checkers"=>$maker_checkers,
                       "discounting_fees"=>$discounting_fees
                      );
 
    $bankconfig = json_encode($bankconfig);
    
    $jsonfile = fopen(storage_path()."/json/results.json","w");
    fwrite($jsonfile,$bankconfig);
    fclose($jsonfile);
  }    
                
}       
                

                
             
               
    

