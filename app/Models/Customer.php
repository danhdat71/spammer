<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'cccd',
        'address',
        'note',
        'is_bad',
        'is_sms_spamed',
        'is_zalo_spamed',
    ];
}
