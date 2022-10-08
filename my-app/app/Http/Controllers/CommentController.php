<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function get_comments(Post $post) 
    {
        foreach($post->comments as $comment) {
            $comment->user = $comment->user;
        }
        return $post->comments;
    }
 
    public function store(Post $post, Request $request)
    {
        $comment = new Comment();
        $comment->text = $request->comment;
        $comment->user_id = Auth::id();
        
        $post->comments()->save($comment);
    }
 
    public function update(Post $post, Comment $comment, Request $request)
    {
        if(Auth::id() == $comment->user_id) {
            $comment->text = $request->text;
            $comment->save();
        }
    }
 
    public function destroy(Post $post, Comment $comment)
    {
        if(Auth::id() == $comment->user_id || Auth::id() == $post->user_id) {
            $comment->delete();
        }
    }
}
