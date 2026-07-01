<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id','title','slug','description','price',
        'thumbnail','file_path','preview_url','type','is_active','downloads'
    ];

    public function category() { return $this->belongsTo(Category::class); }
   public function orders()
{
    return $this->hasMany(Order::class);
}

    public function getRouteKeyName() { return 'slug'; }
    
}
