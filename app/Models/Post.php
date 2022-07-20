<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Comments;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'post',
    ];

    public function user(){
            return $this->belongsTo(User::class);
    }

    public function comments(){
        return $this->hasMany(Comments::class);
    }


    public function scopeArrange($query)
    {
        return $query->orderBy('created_at','desc');
    }
    
}
