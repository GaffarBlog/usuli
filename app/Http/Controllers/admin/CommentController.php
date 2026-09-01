<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CommentController extends Controller
{
    public function index(Request $request): Response
    {
        $query = Comment::with(['post', 'user', 'parent'])
            ->whereNull('parent_id');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('body', 'like', "%{$search}%")
                    ->orWhereHas('user', fn ($q) => $q->where('name', 'like', "%{$search}%"))
                    ->orWhereHas('post', fn ($q) => $q->where('title', 'like', "%{$search}%"));
            });
        }

        if ($request->filled('status')) {
            $query->where('is_seen', $request->input('status') === 'seen');
        }

        $comments = $query->latest()->paginate(15)->withQueryString();

        return response()->view('admin.comments.index', [
            'pageTitle' => 'মন্তব্যসমূহ',
            'comments' => $comments,
        ]);
    }

    public function show(Comment $comment): Response
    {
        $comment->load(['post', 'user', 'replies.admin', 'replies.user']);

        $comment->update(['is_seen' => true]);

        return response()->view('admin.comments.show', [
            'pageTitle' => 'মন্তব্য বিস্তারিত',
            'comment' => $comment,
        ]);
    }

    public function reply(Request $request, Comment $comment)
    {
        $validated = $request->validate([
            'body' => 'required|string|max:2000',
        ]);

        $admin = Auth()->user();

        Comment::create([
            'post_id' => $comment->post_id,
            'admin_id' => $admin->id,
            'body' => $validated['body'],
            'parent_id' => $comment->id,
            'is_seen' => true,
        ]);

        return redirect()->route('admin.comments.show', $comment)->with('success', 'আপনার উত্তর সফলভাবে পোস্ট করা হয়েছে।');
    }

    public function destroy(Comment $comment): Response
    {
        $comment->delete();

        return redirect()->route('admin.comments.index')->with('success', 'মন্তব্য সফলভাবে মুছে ফেলা হয়েছে।');
    }
}
