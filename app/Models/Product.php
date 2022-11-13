<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table='products';
    protected $fillable=[
        'categorySlug',
        'slug',
        'title',
        'description',
        'selling_price',
        'price',
        'qty',
        'image01',
        'image02',
    ];

    protected $casts = [
        'size' => 'array'
    ];

    protected $with=['category'];
    public function category(){
        return $this->belongsTo(Category::class,'categorySlug','categorySlug');
    }
}
