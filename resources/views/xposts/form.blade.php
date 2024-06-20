@if (Auth::id() == $user->id)
    <div class="mt-4">
        <form method="POST" action="{{ route('xposts.store') }}">
            @csrf
        
            <div class="mt-4">
                <textarea rows="4" name="content" class="input input-bordered  border border-primary w-full h-50"></textarea>
            </div>
        
            <button type="submit" class="mt-3 btn btn-primary btn-block normal-case">Post</button>
        </form>
    </div>
@endif


