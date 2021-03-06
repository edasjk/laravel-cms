<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Posts\CreatePostsRequest;
use App\Http\Requests\Posts\UpdatePostsRequest;
use App\Post;
use App\Category;
use App\Tag;


class PostsController extends Controller
{

    public function __contruct()
    {
        $this->middleware('verifyCategoriesCount')->only(['create', 'store']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('posts.index')->with('posts', Post::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create')->with('categories', Category::all())->with('tags', Tag::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePostsRequest $request)
    {
        //upload image to storage
        $image = $request->image->store('posts');
       
        $post = Post::create([
            'title'         => $request->title,
            'description'   => $request->description,
            'content'       => $request->content,
            'image'         => $image,
            'published_at'  => $request->published_at,
            'category_id'   => $request->category,  //name of select is category
        ]);

        if ($request->tags) {
            $post->tags()->attach($request->tags);  //because belongsToMany relationshop
        }

        session()->flash('success', 'Post created successfully');

        return redirect( route('posts.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //dd($post->tags->pluck('id')->toArray());
        return view('posts.create')->with('post', $post)->with('categories', Category::all())->with('tags', Tag::all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostsRequest $request, Post $post)
    {
        //$data = $request->all();
        $data = $request->only(['title', 'description', 'content', 'published_at']);

        //check if new image
        if ($request->hasFile('image')) {
            //uploaded it
            $image = $request->image->store('posts');
            //delete old image
            //Storage::delete($post->image);
            $post->deleteImage();
         
            $data['image'] = $image;
        }

        if ($request->tags) {
           $post->tags() ->sync($request->tags);
        }
        //update attributes
        $post->update($data);
        
        //flash message
        session()->flash('success', 'Post Updated Successfully');

        //redirect user
        return redirect( route('posts.index'));



    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::withTrashed()->where('id', $id)->firstOrFail();

        if ($post->trashed()) {
            $post->deleteImage();
            $post->forceDelete();
            session()->flash('success', 'Post deleted successfully');
        } else {
            $post->delete();
            session()->flash('success', 'Post trashed successfully');
        }

        return redirect(route('posts.index'));
    }

        /**
     * Display a list of all trashed posts
     *
     * @return \Illuminate\Http\Response
     */
    public function trash()
    {
        $trashed  = Post::onlyTrashed()->get();
        
        //return view('posts.index')->withPosts($trashed);

        return view('posts.index')->with('posts', $trashed);
    }

    public function restore($id) 
    {
        $post = Post::withTrashed()->where('id', $id)->firstOrFail();

        $post->restore();

        session()->flash('success', 'Post restored successfully');

        return redirect()->back();
    }
}
