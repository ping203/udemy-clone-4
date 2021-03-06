<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class Course extends Model
{
    protected $with = ['reviews', 'lessons', 'category'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'course_user', 'id', 'course_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function scopeSearchCourse($query)
    {
        $search_keyword = Request::input('search_course');
        if ($search_keyword) {
            return $query->where('title', 'like', "%{$search_keyword}%");
        }
        return $query;
    }

    public function scopeStarCount($query)
    {
        $star_count = Request::input('star_count');
        if ($star_count) {
            return $query->where('star_count', '>=', $star_count);
        }
        return $query;
    }

    public function scopePriceSearch($query)
    {
        $price_search = Request::input('price_search');
        if ($price_search) {
            return $query->where('price', '>=', $price_search);
        }
        return $query;
    }

    public function scopeLevelSearch($query)
    {
        $level_search = Request::input('level_search');
        if ($level_search) {
            return $query->where('level', '>=', $level_search);
        }
        return $query;
    }

    //セール中かどうか
    public function scopeIsSale($query)
    {
        $is_sale = Request::input('is_sale');
        if ($is_sale) {
            return $query->where('is_sale', 1);
        }
        return $query;
    }

    public function scopeStarRank()
    {
        return $this->star_sum->orderByDesc;
    }

    public function getStarCountAttribute()
    {
        return $this->attributes['star_count'] = $this->reviews->avg('star');
    }

    public function getLessonCountAttribute()
    {
        return $this->attributes['lesson_count'] = $this->lessons->count();
    }

    //reviewのstarの合計でランキングを決定
    public function getStarSumAttribute()
    {
        return $this->attributes['star_sum'] = $this->reviews->sum('star');
    }
}
