<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;
    protected $table = 'tbl_testimonials';

    protected $fillable = ['name','title','desc','image','rating','status','designation'];
}
