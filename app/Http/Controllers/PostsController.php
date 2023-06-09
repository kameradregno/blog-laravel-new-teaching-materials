<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostCreateRequest;
use App\Http\Requests\PostsRequest;
use App\Models\Posts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Posts::get();

        $data = [
            'post' => $posts
        ];

        return view('posts.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostCreateRequest $request)
    {
        $title = $request->input('title'); // Ambil judul dari input


        Posts::create([
            'title'     => $title,
            'content'   => $request->input('content'),
            'user_id'   => Auth::user()->id,
            'slug'      => $this->makeSlug($title),
            'image'     => $request->file('image')->store('berita')
        ]);

        return redirect('posts');
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        $post_id      = Posts::where('slug', $slug)->first();

        $data = [
            'post'               => $post_id,
        ];



        return view('posts.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($slug)
    {
        $post_id = Posts::where('slug', $slug)->first();

        $data = [
            'post' => $post_id
        ];

        return view('posts.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Posts $posts)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Posts $posts)
    {
        //
    }
}
