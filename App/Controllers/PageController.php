<?php

namespace kiwi\Http;

use kiwi\Database\Post;
use kiwi\Error\HttpException;

class PageController extends Controller
{
    /**
     * Render the main page.
     *
     * @return void
     */
    public function index()
    {
        View::render('index', ['posts' => Post::all()]);
    }

    /**
     * Render a specific post page.
     *
     * @return void
     */
    public function show(Post $post)
    {
        //$post = Post::from($id);

        if (!$post) {
            throw new HttpException("That post doesn't exist.");
        }

        View::render('post', ['post' => $post]);
    }
}
