<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormData extends Model
{
    use HasFactory;

    protected $table = 'form_data'; // Asegúrate de que coincida con el nombre de tu tabla
    protected $fillable = ['form_id', 'month', 'count', 'created_at']; // Agrega los campos relevantes
}