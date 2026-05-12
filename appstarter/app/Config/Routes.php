<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Home
$routes->get('/', 'Home::index');

// Auth Routes
$routes->group('auth', function ($routes) {
    $routes->get('login', 'AuthController::login');
    $routes->post('login', 'AuthController::login');
    $routes->get('register', 'AuthController::register');
    $routes->post('register', 'AuthController::register');
    $routes->get('logout', 'AuthController::logout');
});

// Post Routes
$routes->group('posts', function ($routes) {
    $routes->get('feed', 'PostController::feed');
    $routes->get('create', 'PostController::create');
    $routes->post('create', 'PostController::create');
    $routes->get('edit/(:num)', 'PostController::edit/$1');
    $routes->post('edit/(:num)', 'PostController::edit/$1');
    $routes->get('delete/(:num)', 'PostController::delete/$1');
    $routes->get('view/(:num)', 'PostController::view/$1');
    $routes->post('like/(:num)', 'PostController::like/$1');
    $routes->get('like/(:num)', 'PostController::like/$1');
    $routes->get('search', 'PostController::search');
});

// Comment Routes
$routes->group('comments', function ($routes) {
    $routes->post('create', 'CommentController::create');
    $routes->get('edit/(:num)', 'CommentController::edit/$1');
    $routes->post('edit/(:num)', 'CommentController::edit/$1');
    $routes->get('delete/(:num)', 'CommentController::delete/$1');
    $routes->post('like/(:num)', 'CommentController::like/$1');
    $routes->get('like/(:num)', 'CommentController::like/$1');
});

// User Routes
$routes->group('users', function ($routes) {
    $routes->get('profile/(:any)', 'UserController::profile/$1');
    $routes->get('edit', 'UserController::edit');
    $routes->post('edit', 'UserController::edit');
    $routes->post('follow/(:num)', 'UserController::follow/$1');
    $routes->get('followers/(:any)', 'UserController::followers/$1');
    $routes->get('following/(:any)', 'UserController::following/$1');
    $routes->get('search', 'UserController::search');
});

// Admin Routes
$routes->group('admin', function ($routes) {
    $routes->get('dashboard', 'AdminController::dashboard');
    $routes->get('manage-users', 'AdminController::manageUsers');
    $routes->post('toggle-status/(:num)', 'AdminController::toggleUserStatus/$1');
    $routes->post('delete-user/(:num)', 'AdminController::deleteUser/$1');
    $routes->get('manage-posts', 'AdminController::managePosts');
    $routes->post('delete-post/(:num)', 'AdminController::deletePost/$1');
});
