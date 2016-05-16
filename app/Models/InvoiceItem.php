<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    protected $table = "invoice_items";

    public function invoices()
    {
        return $this->belongsTo('Invoice');
    }
}

