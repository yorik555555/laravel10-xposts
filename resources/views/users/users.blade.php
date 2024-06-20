@if (isset($users))
    <ul class="list-none position-relative">
        @foreach ($users as $user)
            @if (Auth::id() == $user->id)
            <div class="flex items-center gap-x-2">
                {{-- ユーザのメールアドレスをもとにGravatarを取得して表示 --}}
                <div class="avatar">
                    <div class="w-12 rounded">
                        <img class="blue" src="{{ Gravatar::get($user->email) }}" alt="" />
                    </div>
                </div>
                <div>
                    <div class="text-primary fs-5 mt-4">
                        {{ $user->name }}
                    </div>
                    <div>
                        {{-- ユーザ詳細ページへのリンク --}}
                        <p><a class="link link-hover text-info" href="{{ route('users.show', $user->id) }}">View profile</a></p>
                    </div>
                </div>
            </div>
            @else
            <div>
            <li class="flex items-center gap-x-2">
                {{-- ユーザのメールアドレスをもとにGravatarを取得して表示 --}}
                <div class="avatar">
                    <div class="w-12 rounded">
                        <img src="{{ Gravatar::get($user->email) }}" alt="" />
                    </div>
                </div>
                <div>
                    <div class="mt-4">
                        {{ $user->name }}
                    </div>
                    <div>
                        {{-- ユーザ詳細ページへのリンク --}}
                        <p><a class="link link-hover text-info" href="{{ route('users.show', $user->id) }}">View profile</a></p>
                    </div>
                </div>
            </li>
            
            @endif
        @endforeach
    </ul>
    {{-- ページネーションのリンク --}}
    {{ $users->links() }}
@endif