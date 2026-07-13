<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    protected $table = 'equipment';

    protected $fillable = [
        'equipment',
        'equipment_no',
        'qty',
        'unit',
        'rfl_control_no',
        'description',
        'brand_model',
        'date_acquired',
        'unit_cost',
        'total_cost',
        'status_remarks',
        'received_quantity',
        'used_quantity',
        'balance_quantity',
        'location',
        'person_in_charge',
        'updates',
    ];

    protected $casts = [
        'date_acquired' => 'date',
        'unit_cost' => 'decimal:2',
        'total_cost' => 'decimal:2',
        'qty' => 'integer',
        'received_quantity' => 'integer',
        'used_quantity' => 'integer',
        'balance_quantity' => 'integer',
        'person_in_charge' => 'array',
    ];
}