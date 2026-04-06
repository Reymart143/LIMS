<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSetting extends Model
{
    protected $fillable = [
        'user_id',
        'color_mode',
        'theme_color',
        'sidebar_color',
        'sidebar_type',
        'sidebar_item',
        'navbar_type',
    ];
}
