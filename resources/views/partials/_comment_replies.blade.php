<!-- _comment_replies.blade.php -->

 @foreach($comments as $comment)
    <div class="display-comment">
        <strong>{{ $comment->user->name }} &nbsp;<time style="    font-size: 12px;
    line-height: 1;
    color: rgb(180, 180, 180);" class="float-right"> {{$comment->created_at->diffForHumans()}} </time></strong>
        <p class="mt-2">{{ $comment->body }}</p>
        <a href="" id="reply"></a>
        <form method="post" action="{{ route('reply.add') }}">
            @csrf
            <div class="form-group">
                <input type="text" name="comment_body" class="form-control" />
                <input type="hidden" name="id" value="{{ $id }}" />
                <input type="hidden" name="comment_id" value="{{ $comment->id }}" />
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-warning" value="Reply" />
            </div>
        </form>
        @include('partials._comment_replies', ['comments' => $comment->replies])
    </div>
@endforeach