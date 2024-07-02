<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserFavoriteController extends Controller
{
    /**
     * xpostをお気に入りするアクション。
     * 
     * @param  $id  xpostのid
     * @return \Illuminate\Http\Response
     */
    public function store($xpostId) {
        // 認証済みユーザ（閲覧者）のお気に入りになければ
        //favorites() ...UserモデルbelongsToMany
        $user = \Auth::user();
        if (!$user->is_favorite($xpostId)) {
            $user->favorites()->attach($xpostId);
        }
        // 前のURLへリダイレクトさせる
        return back();
    }

    /**
     * xpostをお気に入りから外すアクション。
     *
     * @param  $id  xpostのid
     * @return \Illuminate\Http\Response
     */
    public function destroy($xpostId) {
        // 認証済みユーザ（閲覧者）が
        $user = \Auth::user();
        if ($user->is_favorite($xpostId)) {
            $user->favorites()->detach($xpostId);
        }
        // 前のURLへリダイレクトさせる
        return back();
    }

}