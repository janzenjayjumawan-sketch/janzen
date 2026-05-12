<?php

namespace App\Controllers;

/**
 * Home Controller
 *
 * Handles the main landing page and redirects authenticated users to the feed.
 */
class Home extends BaseController
{
    /**
     * Display the home page.
     *
     * If user is logged in, redirect to feed.
     * Otherwise, show the welcome message.
     *
     * @return string|\CodeIgniter\HTTP\RedirectResponse
     */
    public function index(): string
    {
        if (session()->get('user_id')) {
            return redirect()->to('/posts/feed');
        }
        return view('welcome_message_new');
    }
}
