<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonationImage extends Model
{
    use HasFactory;

    protected $table = 'donations_images';

    protected $fillable = [
        'donation_id',
        'image_base64',
    ];
}
