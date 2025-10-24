<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;
    public function Category(){
        return $this->belongsTo(Category::class,'category_id');
    }




    public  function Brand(){
        return $this->belongsTo(Brand::class,'brand_id');
    }
    public function Image(){
        return $this->hasMany(ProductImage::class,'product_id');
    }

    public function colors(){
        $colorIDs = array_filter(explode(',',$this->color));
        return \App\Models\Color::whereIn('id', $colorIDs);
    }
    // public function Color(){
    //     $colorIds = array_filter(explode(',',$this->color));
    //     return $this->whereIn('id', $colorIds)->get();
        
    // }
}
