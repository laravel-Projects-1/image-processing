<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class imageProcessing extends Model
{
    use HasFactory;

    protected $table = 'image-processing';
    protected $fillable = ['name','type','path','output_path','data'];
    const TYPE_RESIZE = 1;
}
