<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    //everycategory has many news كل تصنيف لديه أكثر من خبر
    public function category_news(){
        return $this->hasMany(News::class,'Category');
    }

    public function category_news_one(){
        return $this->hasOne(News::class,'Category');
    }

}
