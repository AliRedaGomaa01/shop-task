<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function image() : Attribute
    {

        return Attribute::make(
            get: fn ($value) => $value != false ? asset( $value) : false,
        );
    }

    public function scopeOfTitle($query , $title)
    {
        $query->when($title , function ($query) use ($title) {
            $query->where('title' , 'like' , "%$title%");
        });
    } 

    public function scopeOfDetails($query , $details)
    {
        $query->when($details , function ($query) use ($details) {
            $query->where('details' , 'like' , "%$details%");
        });
    }

    public function scopeOfCategory($query , $category_id)
    {
        $query->when($category_id , function ($query) use ($category_id) {
            $query->where('category_id' , $category_id );
        });
    } 

    public function scopeMoreThanPrice($query , $price)
    {
        $query->when($price , function ($query) use ($price) {
            $query->where->Where('price' , '>' , $price);
        });
    } 

    public function scopeLessThanPrice($query , $price)
    {
        $query->when($price , function ($query) use ($price) {
            $query->where->Where('price' , '<' , $price);
        });
    } 

    ## Relations
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

}
