<?php
// app/Models/Blog.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Blog extends Model
{
    protected $fillable = [
        'user_id', 'blog_category_id', 'title', 'slug',
        'excerpt', 'content', 'thumbnail', 'status', 'views', 'published_at',
    ];

    protected $casts = ['published_at' => 'datetime'];

    public function author()      { return $this->belongsTo(User::class, 'user_id'); }
    public function category()    { return $this->belongsTo(BlogCategory::class, 'blog_category_id'); }

    public function getRouteKeyName() { return 'slug'; }

    public function scopePublished($q) {
        return $q->where('status', 'published');
    }

    public function getReadTimeAttribute(): string {
        $words = str_word_count(strip_tags($this->content));
        $minutes = max(1, ceil($words / 200));
        return $minutes . ' min read';
    }
    
}