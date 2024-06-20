<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class xpost extends Model
{
    use HasFactory;

    protected $fillable = ['content'];

    /**
     * この投稿を所有するユーザ。（ Userモデルとの関係を定義）
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /******* お気に入りに必要な機能   ********/
    /**
    * この投稿をお気に入りのユーザ。（Favoriteモデルとの関係を定義）
    *  $xpost を お気に入りしているuserを取得
    * $xpost->xpostsFavoriters
    */
    public function favorite_users() {
        return $this->belongsToMany(User::class, 'favorites', 'xpost_id', 'user_id')->withTimestamps();
    }

}