<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Repository\Eloquent;

use Repository\POInterface;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\Company;
use App\Models\Attachment;
use App\Models\Role;
use DB;

class PORepo implements POInterface {

    public $buyerId = "";
    public $sellerId = "";
    public $piId = "";
    public $uuid = "";
    public $userTypr;
    public $poID;
    public $isApi = false;
    public $isSingle = false;
    public $statusArray = [];
    public $loggedInUser;
    
    public function getPos() {
        return $this->getData();
    }

    public function getPoByAttibute() {
        return $this->getData();
    }

    public function getData() {
        $query = PurchaseOrder::Join('companies','companies.id', '=','purchase_orders.seller_id');
        $query->leftJoin('invoices', 'purchase_orders.id', '=', 'invoices.purchase_order_id');
        $query->Join('companies as buyer','buyer.id','=','purchase_orders.buyer_id');
        $query->Join('companies as seller','seller.id','=','purchase_orders.seller_id');
        $query->selectRaw('purchase_orders.*, IFNULL(invoices.id, "N") as invYN, IFNULL(sum(invoices.final_amount), 0) as sum, IFNULL(sum(invoices.final_amount)-purchase_orders.final_amount, 0) as minus, companies.name as compName');
        $query->addSelect('buyer.name as buyerName','buyer.uuid as buyerUuid');
        $query->addSelect('seller.name as sellerName','seller.uuid as sellerUuid');
        $query->groupBy('purchase_orders.id');

        if ($this->sellerId){
            $query->where('purchase_orders.seller_id', $this->sellerId);
        }
        if ($this->buyerId){
            $query->where('purchase_orders.buyer_id', $this->buyerId);
        }
        if($this->statusArray){
            $query->whereIn('purchase_orders.status', $this->statusArray);
        }
        
        if ($this->uuid) {
            $query->where('purchase_orders.uuid', $this->uuid);
            $result = $query->first();
            $result->poItems; //= $this->getItems();
            $this->poID = $result->id;
            $result->poAttachments = $this->getPOAttachment();
            return $result;
        }
        if ($this->poID) {
            $query->where('purchase_orders.id', $this->poID);
            $result = $query->first();
            $result->poItems;
            $result->poAttachments = $this->getPOAttachment();
            return $result;
        }

        if ($this->isApi)
            return $query->get();
        
        $result = $query->paginate(15);

        return $result;
    }
    
    public function approveOrRejectPO() {
        $podelete = PurchaseOrder::where('uuid', $this->uuid)
                ->update(['status' => $this->status]);
    }

    public function getPOAttachment() {
          $poAttachData = Attachment::where('type_id', $this->poID)
                    ->where('type', 'purchaseOrder')
                    ->where('status', '0')
                    ->get();
        return $poAttachData;
    }
        

}
