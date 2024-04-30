<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'product_name',
        'codigo_producto',
        'descripcion',
        'cantidad_stock',
        'img_product',
        'precio_prodcuto',
    ] ;
}
