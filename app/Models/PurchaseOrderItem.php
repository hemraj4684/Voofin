<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrderItem extends Model
{
    protected $table = "po_items";

    public function purchaseOrder()
    {
        return $this->belongsTo('PurchaseOrder');
    }
}
