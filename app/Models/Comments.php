<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Post;

class Comments extends Model
{
    use HasFactory;

    public function user(){
        return $this->belongsTo(User::class);
        }


        protected $fillable = [
            'post',
            'post_id'
        ];

        public function post(){
            return $this->belongsTo(Post::class);
            }

}
