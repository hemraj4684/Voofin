<?php

namespace Repository\Eloquent;

use Request,DB;
use Repository\ReportInterface;
use App\Models\Company;
use App\Models\Invoice;
use App\Models\Discounting;
use App\Models\PaymentInstruction;


class ReportRepo implements ReportInterface 
{
    public $buyerId;
    public $sellerId;
    public $piId;
    public $piUuid;
    public $companyConf;
    public $roleId;
    public $bankData;
    public $piStatusArray =[];
    public $discountingStatusArray =[];
    public $discountingData;
    public $keywords;
    public $isPaginate = false;
    public $sellerIDis = false;
    public $isDiscounting = false;
    public $loggedInUser;
   /* View List Of Discounting Usage Report */

    public function getDiscountingReport() {
        
        $query = DB::table('pi_view as pv')
                ->join('company_band_view as cv', function ($join) {
                    $join->on('pv.seller_id', '=', 'cv.seller_id')->on('pv.buyer_id', '=', 'cv.buyer_id');
                });
        
        $query->select('cv.buyer_name','cv.seller_name','pv.invoice_currency');
        $query->addSelect(DB::raw('sum(pv.pi_net_amount) as total_pi_amount,sum((pv.pi_net_amount*cv.discounting)/100) as total_eligible_amount'));
        if($this->isDiscounting){
           $query->join('discountings', 'discountings.pi_id', '=', 'pv.pi_id');
           $query->addSelect(DB::raw('sum(discountings.loan_amount) as total_loan_amount')); 
        }
        if ($this->sellerIDis){
            $currentTime = time();
            $max_dis_days = $this->bankData['basic_configuration']['max_dis_days'];
            $min_dis_days = $this->bankData['basic_configuration']['min_dis_days'];
            $minDate = date("Y-m-d", strtotime("+$min_dis_days days", $currentTime)); //start date is multiples of min dis days
            $maxDate = date("Y-m-d", strtotime("+$max_dis_days days", $currentTime)); //end date is multiples of max dis days
            $query = $query->whereNotIn('pv.pi_id', function($query) {
                $query->select('pi_id')
                        ->from(with(new Discounting)->getTable())
                        ->whereNotIn('status', [2, 4, 6]); //if record  is rejected or internal rejected then should be avoid.
            });
          $query = $query->whereBetween('pv.due_date', [$minDate, $maxDate]);
        }

        if ($this->sellerId) {
           $query->where('pv.seller_id', $this->sellerId);
        } elseif ($this->buyerId) {
           $query->where('pv.buyer_id', $this->buyerId);
        }
        if ($this->piStatusArray) {
           $query->whereIn('pv.pi_status', $this->piStatusArray);
        }
        if ($this->discountingStatusArray) {
           $query->whereIn('discountings.status', $this->discountingStatusArray);
        }
        if ($this->keywords) {
            $key = $this->keywords;
            $query->where('cv.buyer_name', 'like', "$key%");
        }

        $query->orderBy('pv.due_date', 'DESC');
        $query->groupBy('cv.buyer_id');

        if($this->isPaginate)
            return $query->paginate(15);
           
        return $query->get();
    }
    public function discountingUsageExcel() {
        $content ="Sr No., Buyer Name, Currency, Approved PI Amount, Actual Discounted Amount, Eligible Discounting Amount";
        $content.= "\n";
        foreach ($this->discountingData as $key => $discounting) {
            $content.=($key+1).','.$discounting->buyer_name.','.$discounting->invoice_currency.','.$discounting->total_pi_amount.','.$discounting->total_loan_amount.','.$discounting->total_eligible_amount;
            $content.= "\n";
        }
        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename=DiscountingUsageReport_' . time() . '.csv');
        echo $content;exit;
    }

    public function potentialDiscountingExcel() {
        $content ="Sr No., Buyer Name, Currency, Approved PI Amount, Eligible Discounting Amount";
        $content.= "\n";
        foreach ($this->discountingData as $key => $discounting) {
            $content.=($key+1).','.$discounting->buyer_name.','.$discounting->invoice_currency.','.$discounting->total_pi_amount.','.$discounting->total_eligible_amount;
            $content.= "\n";
        }
        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename=PotentailDiscountingReport_' . time() . '.csv');
        echo $content;exit;
    }
}
