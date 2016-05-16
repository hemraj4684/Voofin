<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RevenueSharing extends Model
{
    protected $table='revenue_sharing';
    protected $fillable = ['company_id'];
}
