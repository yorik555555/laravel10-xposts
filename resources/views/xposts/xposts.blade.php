<div class="mt-8">
    @if (isset($xposts))
        <ul class="list-none">
            @foreach ($xposts as $xpost)
                <li class="flex items-start gap-x-2 mb-4">
                    {{-- 投稿の所有者のメールアドレスをもとにGravatarを取得して表示 --}}
                    <div class="avatar">
                        <div class="w-12 rounded">
                            <img src="{{ Gravatar::get($xpost->user->email) }}" alt="" />
                        </div>
                    </div>
                    <div>
                        <div>
                            {{-- 投稿の所有者のユーザ詳細ページへのリンク --}}
                            <a class="link link-hover text-secondary-emphasis text-lg" href="{{ route('users.show', $xpost->user->id) }}">{{ $xpost->user->name }}</a>
                            <span class="text-muted text-gray-500">posted at {{ $xpost->created_at }}</span>
                        </div>
                        <div>
                            {{-- 投稿内容 --}}
                            <p class="mb-0">{!! nl2br(e($xpost->content)) !!}</p>
                        </div>
                        <div class="flex">
                            <div class="flex-none  px-4 ml-5">
                                {{-- お気に入り 追加/削除 ボタン --}}
                                @include('user_favorite.favorite_button')
                            </div>
                            <div class="flex-none">
                                 @if (Auth::id() == $xpost->user_id)
                                {{-- 投稿削除ボタンのフォーム --}}
                                <form method="POST" action="{{ route('xposts.destroy', $xpost->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="mt-2 btn btn-outline-danger" onclick="return confirm('Delete id = {{ $xpost->id }} ?')">Delete</button>
                                </form>
                            @endif
                            </div>

                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
        {{-- ページネーションのリンク --}}
        {{ $xposts->links() }}
    @endif
</div>