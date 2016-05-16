<?php

namespace Repository\Eloquent;

use App\Models\Attachment;
use App\Models\Company;
use App\Models\CompanyBank;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\Notification;
use DB;
use redirect;
use Repository\SellerInterface;
use Schema;
use Session;
use Uuid;
use Validator;

class SellerRepo implements SellerInterface {

    public $loggedInUser;
    public $buyerId = "";
    public $sellerId = "";
    public $poId = "";
    public $uuid = "";
    public $roleId = "";
    public $attachId = "";
    public $keyword = "";
    public $filterRequest = "";
    public $folder = "";
    public $companyConf = "";
    public $userType = "";
    public $success = false;
    public $deleteAtt = false;
    public $deleteInv = false;
    public $isApi = false;
    public $isInvoiceLimit = false;
    public $limit = 10;
    public $offset = 0;
    public $companyType = "";
    public $toId;
    public $objectType;

    /* get buyer autocomplet start */

    public function getBuyerAutocomplete() {

        $query = Company::select('uuid', 'companies.id', 'name', 'bc.tax_percentage', 'bc.payment_terms', 'configurations')
                ->join('band_configurations as bc', 'bc.buyer_id', '=', 'companies.id')
                ->where('bc.seller_id', $this->sellerId);
        if($this->keyword)
        $query->where('name', 'like', "$this->keyword%");
        $query->whereIn('industry', [roleId('Buyer'), roleId('Both')]);
        $data = $query->get();

        $dataValue = array();
        foreach ($data as $k => $v) {
            $dataValue[$k]['label'] = $v->name;
            $dataValue[$k]['id'] = $v->uuid;
            $dataValue[$k]['buyerId'] = $v->id;
            if ($v->payment_terms != 0) { //m/d/Y
                $dataValue[$k]['payTerm'] = date("d M Y", strtotime("+" . $v->payment_terms . " days"));
            } elseif (!empty($v->configurations) && $v->configurations != 0) {
                $config = json_decode($v->configurations, true);
                $dataValue[$k]['payTerm'] = date("d M Y", strtotime("+" . $config['buyer']['other_configuration']['payment_terms'] . " days"));
            } else {
                $dataValue[$k]['payTerm'] = date("d M Y");
            }
        }
        return $dataValue;
    }

    /* get po autocomplet */


    public function getPoData() {
        $bId = $this->getId('companies', $this->uuid)->id;
        $data = PurchaseOrder::select('id', 'uuid', 'purchase_order_number', 'payment_terms', 'currency')
                ->where('purchase_order_number', 'like', "$this->keyword%")
                ->where('buyer_id', $bId)
                ->where('status', 3)
                ->get();
        $dataValue = array();
        foreach ($data as $k => $v) {
            $due_date = date("d M Y", strtotime("+" . $v->payment_terms . " days"));
            //$d        = $v->purchase_order_number . "|" . $v->uuid . "|" . $due_date . "|" . $v->currency;
            $dataValue[$k]['po_number'] = $v->purchase_order_number;
            $dataValue[$k]['po_uuid'] = $v->uuid;
            $dataValue[$k]['due_date'] = $due_date;
            $dataValue[$k]['currency'] = $v->currency;
            //array_push($dataValue, $d);
        }

        return $dataValue;
    }

    /* get po items autocomplet */

    public function getPoItem() {
        $this->poId = $this->getId('purchase_orders', $this->uuid)->id;

        $data = PurchaseOrderItem::select('id', 'purchase_order_id', 'name', 'description', 'unit_price', 'quantity', 'total')
                ->where('purchase_order_id', $this->poId)
                ->get();
        return $data;
    }

    /* get all taxes */

    public function getTax() {
        return $this->companyConf['tax_configuration'];
    }

    /* get all taxes */

    /* delete invoice start */

    public function deleteInvoice() {
        if ($this->deleteAtt) {
            $attData = Attachment::where('id', $this->uuid)
                    ->update(['status' => '1']);
            return $attData;
        }
        if ($this->deleteInv) {
            $invData = Invoice::where('uuid', $this->uuid)->delete();

            return $invData;
        }
    }

    /* delete invoice end */


    /* approve invoice start */

    public function approveInvoice() {
        if ($this->userType == 'buyer') {
            if ($this->companyConf['maker_checker']['invoice_approval'] == 1 && !(\Entrust::can('buyer.invoice.checker'))) {
                $status = "3";
            } elseif ($this->companyConf['maker_checker']['invoice_approval'] == 0 || (\Entrust::can('buyer.invoice.checker'))) {
                $status = "5";
            }
            $invData = Invoice::where('uuid', $this->uuid)
                    ->update(['status' => $status]);
        } elseif ($this->userType == 'seller') {
            //calculating due date from date of submited
            $queryData = Invoice::select('due_date', 'created_at')->where('uuid', $this->uuid)->first();
            $date      = strtotime($queryData->created_at);
            $now       = time();
            $diffDay   = round(($now - $date) / 86400);
            $dueDate   = date('Y-m-d', strtotime("+" . $diffDay . "days", strtotime($queryData->due_date)));
            $invData   = Invoice::where('uuid', $this->uuid)
                                 ->update(['status' => 1, 'due_date' => $dueDate, 'created_at' => date('Y-m-d H:i:s')]);
        }
        return $invData;
    }

    /* approve invoice end */

    /* reject invoice start */

    public function rejectInvoice($request) {
        if ($this->userType == 'buyer') {
            if ($this->companyConf['maker_checker']['invoice_approval'] == 1 && !(\Entrust::can('buyer.invoice.checker'))) {
                $status = "4";
            } elseif ($this->companyConf['maker_checker']['invoice_approval'] == 0 || (\Entrust::can('buyer.invoice.checker'))) {
                $status = "6";
            }
        } elseif ($this->userType == 'seller') {
            $status = "2";
        }

        $invData = Invoice::where('uuid', $request->invoice_uuid)
                ->update(['status' => $status, 'reject_remark' => $request->remarks]);
        return $invData;
    }

    /* reject invoice end */

    /* getId() function is used for getting id from uuid of any table */

    public function getId($table, $uuid) {
        $byrData = DB::table($table)
                ->select('id')
                ->where('uuid', $uuid)
                ->first();
        return $byrData;
    }

    /* check permission of invoice checker */

    /* djn code to save sellerconfigurations */

    public function sellerConfigurationsave($request) {
        $getid = CompanyBank::where('company_id', $this->sellerId)->first();
        if (!empty($getid)) {
            $getid = $getid->id;
        }

        $seller = CompanyBank::findOrNew($getid);

        $columns = Schema::getColumnListing('company_banks');
        foreach ($request->all() as $key => $value) {
            if (in_array($key, $columns)) {
                $seller->$key = $value;
            }
        }
        $seller->company_id = $this->sellerId;
        $selldata = $seller->save();

        if ($selldata) {

            //creation of maker_checker configuration array.
            $maker_checker = array(
                "invoice_creation" => $request->invoicecreation,
                "manual_discoutning" => $request->manualdiscoutning,
            );
            //creation of other_configuration array.
            $other_configuration = array(
                "auto_discounting" => $request->autodiscounting,
                "auto_accept_po" => $request->autoacceptpo,
            );
            //creation of tax configuartion array
            $tax_configuration = array();

            $a = count($request->name);
            $name = $request->name;
            $percentage = $request->percentage;

            for ($i = 0; $i < $a; $i++) {
                $tax_configuration[$name[$i]] = $percentage[$i];
            }

            //final array for json data
            $sellerconfig = array(session('typeUser') => array(
                    "tax_configuration" => $tax_configuration,
                    "maker_checker" => $maker_checker,
                    "other_configuration" => $other_configuration),
            );
            /* update company tabel configuartion column value with particular key (for ex. buyer or seller) json data */
            $res = Company::find($this->sellerId, ['configurations']);
            $updatedConfig = array();

            if (isset($res->configurations)) {
                $updatedConfig = json_decode($res->configurations, true);
            }

            if (isset($updatedConfig['seller'])) {
                $updatedConfig['seller'] = $sellerconfig[session('typeUser')];
            } elseif (isset($updatedConfig['buyer'])) {
                $updatedConfig = array_merge($updatedConfig, $sellerconfig);
            } else {
                $updatedConfig = $sellerconfig;
            }

            $sellerconfig = json_encode($updatedConfig);
            session()->put('company_conf', $sellerconfig);

            //code to update the company table config column with json data
            $res = Company::where('id', $this->sellerId)
                    ->update(['configurations' => $sellerconfig]);

            if ($res) {
                $message['success'] = "Configuration Saved Successfully";
            } else {
                $message['alert'] = "Configuration field not updated properly";
            }

            return $message;
        } else {
            $message['alert'] = "Company bank info not save/update properly";
            return $message;
        }
    }

    /* get all buyer auto complete */

    public function getAllBuyer() {
        if (isset($this->keyword) && !empty($this->keyword)) {
            $seller = array();
            $data = DB::table('companies')
                    ->select('uuid', 'id', 'name')
                    ->where('name', 'like', "$this->keyword%")
                    ->whereIn('industry', [roleId($this->companyType), roleId('Both')])
                    ->get();

            $dataValue = array();
            foreach ($data as $k => $v) {
                $dataValue[$k]['label'] = $v->name;
                $dataValue[$k]['id'] = $v->id;
            }

            return json_encode($dataValue);
        }
    }

    public function getNotifications(){
            $query = Notification::select('notifications.*')->where('to_id',$this->toId);
            if($this->objectType == 'invoice'){
              $query->addSelect('invoices.uuid as invoice_uuid');
              $query->join('invoices','invoices.id','=','object_id');
            }elseif($this->objectType == 'po'){
              $query->addSelect('po.uuid as po_uuid');
              $query->join('purchase_orders as po','po.id','=','object_id');
            }
            $result =  $query->get();
            return $result;
    }

}
