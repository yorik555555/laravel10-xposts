<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * このユーザが所有する投稿。（ xpostモデルとの関係を定義）
     */
    public function xposts()
    {
        return $this->hasMany(Xpost::class);
    }

    /**
     * このユーザに関係するモデルの件数をロードする。
     */
    public function loadRelationshipCounts()
    {
        $this->loadCount(['xposts', 'followings', 'followers' ,'favorite_xposts']);
    }

    /**********
     * このユーザがフォロー中のユーザ。（Userモデルとの関係を定義）
     */
    public function followings()
    {
        return $this->belongsToMany(User::class, 'user_follow', 'user_id', 'follow_id')->withTimestamps();
    }
    
    /**
     * このユーザをフォロー中のユーザ。（Userモデルとの関係を定義）
     */
    public function followers()
    {
        return $this->belongsToMany(User::class, 'user_follow', 'follow_id', 'user_id')->withTimestamps();
    }

    /**
     * $userIdで指定されたユーザをフォローする。
     *
     * @param  int  $userId
     * @return bool
     */
    public function follow($userId)
    {
        $exist = $this->is_following($userId);
        $its_me = $this->id == $userId;
        
        if ($exist || $its_me) {
            return false;
        } else {
            $this->followings()->attach($userId);
            return true;
        }
    }
    
    /**
     * $userIdで指定されたユーザをアンフォローする。
     * 
     * @param  int $usereId
     * @return bool
     */
    public function unfollow($userId)
    {
        $exist = $this->is_following($userId);
        $its_me = $this->id == $userId;
        
        if ($exist && !$its_me) {
            $this->followings()->detach($userId);
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * 指定された$userIdのユーザをこのユーザがフォロー中であるか調べる。
     フォロー中ならtrueを返す。
     * 
     * @param  int $userId
     * @return bool
     */
    public function is_following($userId)
    {
        return $this->followings()->where('follow_id', $userId)->exists();
    }

    /**
    * このユーザとフォロー中ユーザの投稿に絞り込む。
    */
    public function feed_xposts()
    {
        // このユーザがフォロー中のユーザのidを取得して配列にする
        $userIds = $this->followings()->pluck('users.id')->toArray();
        // このユーザのidもその配列に追加
        $userIds[] = $this->id;
        // それらのユーザが所有する投稿に絞り込む
        return Xpost::whereIn('user_id', $userIds);
    }

    /******* お気に入りに必要な機能   ********/
    
     /**
     多対多リレーションメソッドの定義
     */
    public function favorite_xposts() {
        return $this->belongsToMany(Xpost::class, 'favorites', 'user_id', 'xpost_id')->withTimestamps();
    }
    
    /**
     * $userIdで指定されたxpostをお気に入りする。
     *
     * @param  int  $xpostId
     * @return bool
     */
    public function favorite($xpostId)
    {
        $exist = $this->on_favorite($xpostId);
        //$its_me = $this->id == $usersId;
        
        if ($exist) {
            return false;
        } else {
            $this->favorite_xposts()->attach($xpostId);
            return true;
        }
    }
    
    /**
     * $userIdで指定されたxpostをお気に入りから外す。
     * 
     * @param  int $xpostId
     * @return bool
     */
    public function unfavorite($xpostId)
    {
        $exist = $this->on_favorite($xpostId);
        //$its_me = $this->id == $usersId;
        
        if ($exist) {
            $this->favorite_xposts()->detach($xpostId);
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * xpostが既にお気に入りかチェック
     * 
     * @param  int $xpostId
     * @return bool
     */
    public function is_favorite($xpostId)
    {
        return $this->favorite_xposts()->where('xpost_id', $xpostId)->exists();
    }
}
