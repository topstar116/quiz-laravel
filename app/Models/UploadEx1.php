<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UploadEx1 extends Model
{
    use HasFactory;
    protected $fillable = [
        'SKU',
        '注文商品売上',
    ];
}
