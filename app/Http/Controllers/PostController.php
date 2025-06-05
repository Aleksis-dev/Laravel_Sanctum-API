<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::all();
        return response()->json([
            "posts" => $posts
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "title" => "required|max:255",
            "content" => "required|max:1000",
            "image" => "nullable|image|mimes:jpg,jpeg,png,gif,svg|max:2048"
        ]);

        $post = Post::create($request->all());

        if ($request->file('image')) {
            $imageExtension = $request->file('image')->getExtension();
            $path = $request->file('image')->storeAs('images', $post->id . '.' . $imageExtension, 'public');
            $post->update([
                "image" => $path
            ]);
        }

        return response()->json([
            "post" => $post,
            "message" => "Post created successfully!"
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return response()->json([
            "post" => $post
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $request->validate([
            "title" => "required|max:255",
            "content" => "required|max:1000",
            "image" => "nullable|image|mimes:jpg,jpeg,png,gif,svg|max:2048"
        ]);

        $post->update($request->all());

        if ($request->file('image')) {
            $imageExtension = $request->file('image')->getExtension();
            $path = $request->file('image')->storeAs('images', $post->id . '.' . $imageExtension, 'public');
            $post->update([
                "image" => $path
            ]);
        }

        return response()->json([
            "post" => $post,
            "message" => "Successfully updated post " . $post->title
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $temp = $post;
        $post->delete();
        return response()->json([
            "message" => "Post " . $temp->title . " was successfully deleted!"
        ], 200);
    }
}
