<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImagePoll extends Model
{
    use HasFactory;
    protected $table = 'tbl_image_polls';

    protected $fillable = [
        'vote',
        'poll_id','location','name','session_id'
    ];

}
