<div class="tabs">
    {{-- ユーザ詳細タブ --}}  
    <a href="{{ route('users.show', $user->id) }}" class="tab text-primary text-decoration-none text-lg tab-lifted grow {{ Request::routeIs('users.show') ? 'tab-active' : '' }}">
        TimeLine
        <span class="ml-1 badge bg-primary text-wrap text-decoration-none" style="height: 1.5rem;text-decoration:none;">{{ $user->xposts_count }}</span>
    </a>
    {{-- フォロー一覧タブ --}}     
    <a href="{{ route('users.followings', $user->id) }}" class="tab text-primary text-decoration-none text-lg tab-lifted grow {{ Request::routeIs('users.followings') ? 'tab-active' : '' }}">
        Followings
        <span class="ml-1 badge bg-primary text-wrap text-decoration-none" style="height: 1.5rem;text-decoration:none;">{{ $user->followings_count }}</span>
        
    </a>
    {{-- フォロワー一覧タブ --}}
    <a href="{{ route('users.followers', $user->id) }}" class="tab text-primary text-decoration-none text-lg tab-lifted grow {{ Request::routeIs('users.followers') ? 'tab-active' : '' }}">
        Followers
        <span class="ml-1 badge bg-primary text-wrap text-decoration-none" style="height: 1.5rem;text-decoration:none;">{{ $user->followers_count }}</span>
    </a>
    @if (Auth::id() == $user->id)
        {{-- お気に入り一覧タブ --}}
        <a href="{{ route('favorites', $user->id) }}" class="tab text-primary text-decoration-none text-lg tab-lifted grow {{ Request::routeIs(' favorites') ? 'tab-active' : '' }}">
            Favorites
            <span class="ml-1 badge bg-primary text-wrap text-decoration-none" style="height: 1.5rem;text-decoration:none;">{{ $user->favorite_xposts_count }}</span>
        </a>
    @endif
</div>