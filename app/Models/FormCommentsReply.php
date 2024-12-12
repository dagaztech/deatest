<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormCommentsReply extends Model
{
    use HasFactory;
    protected $table = 'tbl_form_comments_replies';

    protected $fillable = [
        'name','reply','form_id','comment_id',
    ];
}
