<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;
    protected $table = 'tbl_faqs';

    protected $fillable = [
        'quetion',
        'answer',
        'order',
    ];
}
