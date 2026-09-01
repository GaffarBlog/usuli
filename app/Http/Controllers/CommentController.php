<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, Post $post): Response
    {
        $validated = $request->validate([
            'body' => 'required|string|max:2000',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        $user = Auth::guard('frontend')->user();

        Comment::create([
            'post_id' => $post->id,
            'frontend_user_id' => $user->id,
            'body' => $validated['body'],
            'parent_id' => $validated['parent_id'] ?? null,
        ]);

        return redirect()->route('blog.show', $post->slug)->with('success', 'আপনার মন্তব্য সফলভাবে পোস্ট করা হয়েছে।');
    }
}
