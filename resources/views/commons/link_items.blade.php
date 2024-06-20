@if (Auth::check())
    {{-- ユーザ一覧ページへのリンク --}}
    <li><a class="link-opacity-100 text-primary text-decoration-none fs-5" href="{{ route('users.index') }}">Users</a></li>
    {{-- ユーザ詳細ページへのリンク --}}
    <li><a class="link-opacity-100 text-primary text-decoration-none fs-5" href="{{ route('users.show', Auth::user()->id) }}">{{ Auth::user()->name }}&#39;s profile</a></li>
    <li class="divider lg:hidden"></li>
    {{-- ログアウトへのリンク --}}
    <li><a class="link-opacity-100 text-primary text-decoration-none fs-5" href="#" onclick="event.preventDefault();this.closest('form').submit();">Logout</a></li>
@else
    {{-- ユーザ登録ページへのリンク --}}
    <li><a class="link-opacity-100 text-decoration-none fs-5" href="{{ route('register') }}">Signup</a></li>
    <li class="divider lg:hidden"></li>
    {{-- ログインページへのリンク --}}
    <li><a class="link-opacity-100 text-decoration-none fs-5" href="{{ route('login') }}">Login</a></li>
@endif        