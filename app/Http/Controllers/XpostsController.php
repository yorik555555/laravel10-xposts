<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\xpost;

class xpostsController extends Controller
{
    public function index()
    {
        $data = [];
        if (\Auth::check()) { // 認証済みの場合
            // 認証済みユーザを取得
            $user = \Auth::user();
            // ユーザの投稿の一覧を作成日時の降順で取得
            // （後のChapterで他ユーザの投稿も取得するように変更しますが、現時点ではこのユーザの投稿のみ取得します）
            $xposts = $user->feed_xposts()->orderBy('created_at', 'desc')->paginate(10);
            $data = [
                'user' => $user,
                'xposts' => $xposts,
            ];
        }
        
        // dashboardビューでそれらを表示
        return view('dashboard', $data);
    }
    
   public function store(Request $request)
    {
        // バリデーション
        $request->validate([
            'content' => 'required|max:255',
        ]);
        
        // 認証済みユーザ（閲覧者）の投稿として作成（リクエストされた値をもとに作成）
        $request->user()->xposts()->create([
            'content' => $request->content,
        ]);
        
        // 前のURLへリダイレクトさせる　
        return back();
    }
    
    public function destroy($id)
    {
        // idの値で投稿を検索して取得
        $xpost = \App\Models\Xpost::findOrFail($id);
        
        // 認証済みユーザ（閲覧者）がその投稿の所有者である場合は投稿を削除
        if (\Auth::id() === $xpost->user_id) {
            $xpost->delete();
            return back()
                ->with('success','Delete Successful');
        }

        // 前のURLへリダイレクトさせる
        return back()
            ->with('Delete Failed');
    }
    
}