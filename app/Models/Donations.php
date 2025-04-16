<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donations extends Model
{
    use HasFactory;
    protected $table = 'donations';

    protected $fillable = [
        'user_id',
        'category_id',
        'name',
        'description',
        'quantity',
        'status',
    ];
}
