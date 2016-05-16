<?php 
define('SITE_URL','');
define('DEFAULT_TILE','VEEFIN');
define('INVOICE_CREATED_MSG','Invoice created successfully.');
define('INVOICE_INVALID_DATA_MSG','Invalid Data');

function random($length = 8) 
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString.= $characters[rand(0, $charactersLength - 1) ];
    }
    return $randomString;
}

function roleType($role_id)
{
	switch ($role_id) {
        case '2':
            return "Bank";
            break;
        case '3':
            return "Buyer";
            break;
        case '4':
            return "Seller";
            break;
        case '5':
            return "Both";
            break;
        case '6':
            return "Admin";
            break;
        default:
            return "$role_id";
            break;
    }   
}

function roleId($roleType)
{
    switch ($roleType) {
        case 'Bank':
            return "2";
            break;
        case 'Buyer':
            return "3";
            break;
        case 'Seller':
            return "4";
            break;
        case 'Both':
            return "5";
            break;
        case 'Admin':
            return "6";
            break;
        default:
            return "$roleType";
            break;
    }   
}


function saveDate($date){//change date format as per database
    return date("Y-m-d",strtotime($date)); 
}

function viewDate($date){//change date format as per bootstrap datepicker
    return date("m/d/Y",strtotime($podata->start_date));
}

function optionSelect($value, $compareValue){//to 

    if($value === $compareValue)
        return "selected";
    else
        return '';
}

/*php array data for storage json file starts here*/
    function loadJSON($filename) 
    {
       $path = storage_path() . "/json/${filename}.json"; // ie: /var/www/laravel/app/storage/json/filename.json
        if (!File::exists($path)) {
            throw new Exception("Invalid File");
        }
        $file = File::get($path); // string
        //dd($file);
        $jsonData = json_decode($file,true);
        
        return $jsonData;
    }
/*php array data for storage json file ends here*/
    
    function getNavigation($userType,$roleId){
        $role = App\Models\Role::find($roleId);
        $per = $role->permissions()->get(['name'])->toArray();
        $navArray = loadJSON($userType.'Navigation');
        $navPermArray = array();
        foreach($navArray as $key => $val){
            if (in_array($val['permission'], array_flatten($per))){
                $navPermArray[$key] = $val;
                $navPermArray[$key]['Child'] = array();
                if($navArray[$key]['Child']){
                    foreach($navArray[$key]['Child'] as $k => $v){
                        if (in_array($v['permission'], array_flatten($per))){
                            $navPermArray[$key]['Child'][$k] = $v;
                        }
                    }
                }
            }
        }
        return $navPermArray;
    }

function inr_number_format($number,$d){
  setlocale(LC_MONETARY, 'en_IN');
  $number = money_format($d, $number);
  return $number;
}
//echo inr_number_format(100000,'%!.0n')."<br>"; //for without decimal

//echo inr_number_format(100000,'%!i'); ////for with decimal 2
?>