<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz1 extends Model
{
    use HasFactory;
    protected $fillable = [
        '氏名',
        '項目',
        '回答項目',
        '提案№',
        'お勧め進路',
        '回答日'
    ];
}
