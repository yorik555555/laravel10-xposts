<div class="card mb-4" style="width: 18rem;">
{{-- ユーザのメールアドレスをもとにGravatarを取得して表示 --}}
<img src="{{ Gravatar::get($user->email, ['size' => 200]) }}" alt="">
  <div class="card-body">
    <h5 class="card-title">{{ $user->name }}</h5>
    <p class="card-text">ここに自己紹介文が入ります。ここに自己紹介文が入ります。ここに自己紹介文が入ります。</p>
    <div class="mt-4">
        {{-- フォロー／アンフォローボタン --}}
        @include('user_follow.follow_button')
    </div>
  </div>
</div>
