<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostCreateRequest;
//use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
//use Pest\Mutate\Mutators\Sets\ReturnSet;


class PostController extends Controller {

    public function index() {
        
        // DB::listen(function ($query) {
        //     Log::info($query->sql);
        // });

        $user = auth()->user();

        $query = Post::with(['user', 'media'])
            ->withCount('claps')
            ->latest();
        if ($user) {
            $ids = $user->following()->pluck('users_id');
            $query->whereIn('user_id', $ids);
        }

        $posts = $query->simplePaginate(5);
        return view('post.index', [
            'posts' => $posts,
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        $categories = Category::get();
        return view('post.create', [
            'categories' => $categories,
        ]);
    }
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostCreateRequest $request) {
        // dd($request->all());
        $data = $request->validated();

        // $image = $data['image'];
        // unset($data['image']);
        $data['user_id'] = Auth::id();
        $data['slug'] = Str::slug($data['title']);

        // $imagePath = $image->store('posts', 'public');
        // $data['image'] = $imagePath;
        
        // dd($data);
        $post = Post::create($data);
        $post->addMediaFromRequest('image')
            ->toMediaCollection();

        return redirect()->route('dashboard');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $username, Post $post) {

        // return 'Works '.$post->slug;
        return view('post.show', [
            'post' => $post,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }

    public function category(Category $category) {

        $posts = $category->posts()
            ->with(['user', 'media'])
            ->withCount('claps')
            ->latest()
            ->simplePaginate(5);

        return view('post.index', [
            'posts' => $posts,
        ]);
    }
}
