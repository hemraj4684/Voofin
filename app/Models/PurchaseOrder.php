<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseOrder extends Model
{
    use SoftDeletes;
    protected $table = "purchase_orders";
    protected $dates = ['deleted_at'];


    public function poItems()
    {
        return $this->hasMany('App\Models\PurchaseOrderItem', 'purchase_order_id');
    }
}
