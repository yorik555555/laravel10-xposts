@if (!Auth::user()->is_favorite($xpost->id))
    <form action="{{ route('userfavorite.store', $xpost) }}" method="post">
        @csrf
        <button type="submit" class="mt-2 btn btn-outline-primary">
          お気に入り登録
        </button>
    </form>

    @else
    <form action="{{ route('userfavorite.destroy', $xpost) }}" method="post">
        @csrf
        @method('delete')
        <button type="submit" class="mt-2 btn btn-outline-success">
            お気に入り解除
        </button>
    </form>
@endif