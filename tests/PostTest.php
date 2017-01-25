<?php

  use Illuminate\Foundation\Testing\WithoutMiddleware;
  use Illuminate\Foundation\Testing\DatabaseMigrations;
  use Illuminate\Foundation\Testing\DatabaseTransactions;

  class PostTest extends TestCase
  {

    public $post_stucture
      = [
        'data' => [
          '*' => [
            'id',
            'userId',
            'title',
            'body',
          ],
        ],
      ];

    /**
     * Posts list test
     *
     * @return void
     */
    public function testPostList()
    {
      $this
        ->get('/api/posts')
        ->seeJsonStructure($this->post_stucture);
    }

    /**
     * One post test
     *
     * @param $id
     */
    public function testPostOne($id = null)
    {
      $id = !is_null($id) ? $id : rand(1, 150);
      $this
        ->get('/api/posts/' . $id)
        ->seeJsonStructure($this->post_stucture['data']['*']);
    }

    /**
     * Create post test
     */
    public function testCreatePost()
    {
      $post = $this
        ->post('/api/posts',
          [
            'userId' => rand(1, 5),
            'title'  => 'My test post',
            'body'   => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s',
          ])
        ->seeJsonStructure($this->post_stucture['data']['*']);

      $this->testPostOne($post->response->original->id);
    }

    /**
     * Edit post test
     */
    public function testEditPost()
    {
      $id   = rand(1, 150);
      $post = $this
        ->patch('/api/posts/' . $id,
          [
            'userId' => rand(1, 5),
            'title'  => 'My EDIT post',
            'body'   => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s',
          ])
        ->seeJsonStructure($this->post_stucture['data']['*']);

      $this->testPostOne($post->response->original->id);
    }

    /**
     * Search by userId
     */
    public function testSearch()
    {
      // user doesnt exists
      $this->get('/api/posts/?userId=666');
      $this->isJson();
      // user exists
      $this->get('/api/posts/?userId=1');
      $this->seeJsonStructure($this->post_stucture);
    }

    /**
     * Delete post
     */
    public function testDelete()
    {
      $id = rand(1, 150);
      $this
        ->delete('/api/posts/' . $id)
        ->get('/api/posts/' . $id)
        ->isJson();
    }
  }
