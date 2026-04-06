<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'company_name',
        'address',
        'contact_no',
        'source_sample',
        'sample_description',
        'sample_code',
        'analysis_requested',
        'status',
        'species',
        'classification',
        'date'
    ];
}
