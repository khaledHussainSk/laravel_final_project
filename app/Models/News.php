<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    //many to one cuz everynews follow one category كل خبر يتبع تصنيف واحد
    public function category_(){
        return $this->belongsTo(Category::class,'Category');
    }

}
