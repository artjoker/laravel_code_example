<?php

  namespace App\Http\Controllers;

  use App\Post;
  use Illuminate\Http\Request;

  class PostController extends Controller
  {
    /**
     * Return all posts
     * GET /api/posts[?userId={id}]
     *
     * @param Request $request
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function index(Request $request)
    {
      if (!empty($request->userId))
        $post = Post::where('userId', $request->userId)->paginate(50);
      else
        $post = Post::paginate(50);
      return $post;
    }

    /**
     * Return one post
     * GET /api/posts/{id}
     *
     * @param $id
     *
     * @return mixed
     */
    public function show($id)
    {
      return Post::findOrFail($id);
    }

    /**
     * Create new post
     * POST /api/posts
     *
     * @param Request $request
     *
     * @return Post
     */
    public function store(Request $request)
    {
      $post = new Post();
      $post->title  = $request->title;
      $post->body   = $request->body;
      $post->userId = $request->userId;
      $post->save();
      return $post;
    }

    /**
     * Update post
     * PATCH /api/posts/{id}
     *
     * @param Request $request
     *
     * @return Post
     */
    public function update($id, Request $request)
    {
      $post = Post::find($id);
      $post->title  = $request->title;
      $post->body   = $request->body;
      $post->userId = $request->userId;
      $post->save();
      return $post;
    }

    /**
     * Delete post
     * DELETE /api/posts/{id}
     *
     * @param $id
     *
     * @return array
     */
    public function destroy($id)
    {
      Post::find($id)->delete();
      return [];
    }
  }
