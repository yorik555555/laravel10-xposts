<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;                      
use App\Models\User; 

class UsersController extends Controller
{
    public function index()                                       
    {                                                       
        // ユーザ一覧をidの降順で取得
        $users = User::orderBy('id', 'desc')->paginate(10); 

        // ユーザ一覧ビューでそれを表示　
        // views/users/index.blade.php
        return view('users.index', [                        
            'users' => $users,                              
        ]);                                                 
    }                                                       
    
    public function show($id)
    {
        // idの値でユーザを検索して取得
        $user = User::findOrFail($id);
        
        // 関係するモデルの件数をロード
      $user->loadRelationshipCounts();
        
        // ユーザーの投稿一覧を作成日時の降順で取得
    $xposts = $user->xposts()->orderBy('created_at', 'desc')->paginate(10);

        // ユーザ詳細ビューでそれを表示
        return view('users.show', [
            'user' => $user,
            'xposts' => $xposts,
        ]);
    } 

    /**
     * ユーザのフォロー一覧ページを表示するアクション。
     *
     * @param  $id  ユーザのid
     * @return \Illuminate\Http\Response
     */
    public function followings($id)
    {
        // Userモデルのidの値でユーザを検索して取得
        $user = User::findOrFail($id);

        // 関係するモデル(データ)の件数をロード
        $user->loadRelationshipCounts();

        // ユーザのフォロー一覧を取得
        $followings = $user->followings()->paginate(10);

        // フォロー一覧ビューでそれらを表示
        return view('users.followings', [
            'user' => $user,
            'users' => $followings,
        ]);
    }


    /**
     * ユーザのフォロワー一覧ページを表示するアクション。
     *
     * @param  $id  ユーザのid
     * @return \Illuminate\Http\Response
     */
    public function followers($id)
    {
        // idの値でユーザを検索して取得
        $user = User::findOrFail($id);

        // 関係するモデルの件数をロード
        $user->loadRelationshipCounts();

        // ユーザのフォロワー一覧を取得
        $followers = $user->followers()->paginate(10);

        // フォロワー一覧ビューでそれらを表示
        return view('users.followers', [
            'user' => $user,
            'users' => $followers,
       ]);
    }

    /**
     * ユーザのお気に入り一覧ページを表示するアクション。
     *
     * @param  $id  ユーザのid
     * @return \Illuminate\Http\Response
     */
    public function favorites($id)
    {
        // idの値でユーザを検索して取得
        $user = User::findOrFail($id);

        // userモデルからfavoritesの件数をロード
        $user->loadRelationshipCounts();
        //これがnavtab.blade.phpの{{ $user->favorites_count }}にいく
        /*
        UsersController@favorites アクションで呼び出した 
        loadRelationshipCounts メソッドの中で、
        リレーション favorites の件数をロードしたことより可能
        */

        // ユーザのお気に入り一覧を取得
        $favorites = $user->favorites()->orderBy('created_at', 'desc')->paginate(10);
       

        // お気に入り一覧ビューでそれらを表示
        return view('users.favorites', [
            'user' => $user,
            'xposts' => $favorites,
        ]);
    }
}
