<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rescue extends Model
{
    use HasFactory;

    protected $table = 'rescues';

    protected $fillable = [
        'donation_id',
        'user_id',
        'rescue_date',
        'rescued_quantity',
    ];
}
