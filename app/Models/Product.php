<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name','price','description','category_id','user_id']; 

   public function category()
   {
        return $this->belongsTo('App\Models\Category');
   }

   public function User()
   {
        return $this->belongsTo('App\Models\User');
   }
   public function images()
   {
        return $this->hasMany('App\Models\Image');
   }
}
