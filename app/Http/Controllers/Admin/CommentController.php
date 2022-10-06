<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    public function index()
    {
        $comments = Comment::whereApproved(1)->latest()->paginate(20);
        return view('admin.comments.all' , compact('comments'));
    }

    public function unapproved()
    {
        $comments = Comment::whereApproved(0)->latest()->paginate(20);
        return view('admin.comments.unapproved' , compact('comments'));

    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, Comment $comment)
    {
        $comment->update([ 'approved' => 1]);

        alert()->success('نظر مورد نظر تایید شد');
        return back();
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();
        alert()->success('نظر شما با موفقیت حذف شد');

        return back();
    }
}
