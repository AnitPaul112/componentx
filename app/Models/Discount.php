<?php

// app/Models/Discount.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    protected $table = 'discounts';

    protected $fillable = [
        'code',
        'discount_percentage',
        'valid_from',
        'valid_until',
    ];
}

