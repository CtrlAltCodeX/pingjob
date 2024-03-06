<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Comment;
use Illuminate\Http\Request;


class CommentController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function store(Request $request)
    {
        $comment = new Comment;
        $comment->body = $request->get('comment_body');
        $comment->user()->associate($request->user());
        $comment->body = $request->get('comment_body');
        $job = Job::find($request->get('id'));
        $job->comments()->save($comment);
        return redirect()->back()->withSuccess('Your Questions / Comments was successfully submitted');
    }

    public function replyStore(Request $request)
    {
        $reply = new Comment();
        $reply->body = $request->get('comment_body');
        $reply->user()->associate($request->user());
        $reply->parent_id = $request->get('comment_id');
        $job = Job::find($request->get('id'));

        $job->comments()->save($reply);

        return redirect()->back()->withSuccess('Your Replies was successfully submitted');
    }
}
