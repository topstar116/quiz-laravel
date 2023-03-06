<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz2 extends Model
{
    use HasFactory;
    protected $fillable = [
        '氏名',
        '項目',
        '回答項目',
        'ランク',
        '説明概要',
        '回答日'
    ];
}
