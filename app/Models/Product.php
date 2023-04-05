<?php

namespace App\Models;
//123

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    //protected $table = 'my_table';
    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'product_image',
    ];
}
