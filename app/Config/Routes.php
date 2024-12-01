<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Frontend Routes
$routes->get('/', 'FrontController::index', ['as' => 'front.index']);
$routes->get('/details/(:segment)', 'FrontController::details/$1', ['as' => 'front.details']);
$routes->get('/category/(:segment)', 'FrontController::category/$1', ['as' => 'front.category']);
$routes->get('/pricing', 'FrontController::pricing', ['as' => 'front.pricing']);

// Authentication Routes
$routes->get('/logout', 'AuthController::logout');
$routes->get('/login', 'AuthController::login');
$routes->get('/register', 'AuthController::register');
$routes->post('/register/store', 'AuthController::registerUser');  // Menangani form registrasi
$routes->post('/auth/authenticate', 'AuthController::authenticate');


// Profile Routes
$routes->group('', ['filter' => 'auth'], function ($routes) {
    $routes->get('/profile', 'ProfileController::edit', ['as' => 'profile.edit']);
    $routes->patch('/profile', 'ProfileController::update', ['as' => 'profile.update']);
    $routes->delete('/profile', 'ProfileController::destroy', ['as' => 'profile.destroy']);

    // Dashboard route, based on role redirection in AuthController
    $routes->get('/admin/dashboard', 'AdminController::dashboard', ['filter' => 'role:owner']);
    $routes->get('/teacher/dashboard', 'TeacherController::dashboard', ['filter' => 'role:teacher']);
    $routes->get('/student/dashboard', 'StudentController::dashboard', ['filter' => 'role:student']);

    // Routes for student, teacher, and owner
    $routes->group('', ['filter' => 'role:student,teacher,owner'], function ($routes) {
        $routes->get('/checkout', 'FrontController::checkout', ['as' => 'front.checkout']);
        $routes->post('/checkout/store', 'FrontController::checkout_store', ['as' => 'front.checkout.store']);
        $routes->get('/learning/(:segment)/(:segment)', 'FrontController::learning/$1/$2', ['as' => 'front.learning']);
    });

    // ['filter' => 'role:owner', 'as' => 'admin.']
    // Admin Routes with Role 'owner'
    $routes->group('admin', ['namespace' => 'App\Controllers', 'filter' => 'role:owner'], function ($routes) {
        // Rute untuk mengelola kategori
        $routes->get('categories', 'CategoryController::index'); // Menampilkan kategori
        $routes->get('categories/create', 'CategoryController::create'); // Halaman create
        $routes->post('categories/store', 'CategoryController::store'); // Menyimpan kategori baru
        $routes->get('categories/edit/(:segment)', 'CategoryController::edit/$1');
        $routes->post('categories/update/(:segment)', 'CategoryController::update/$1');
        $routes->post('categories/delete/(:segment)', 'CategoryController::delete/$1'); // Menghapus kategori

        // Rute untuk mengelola teachers
        $routes->get('teachers', 'TeacherController::index');
        $routes->get('teachers/create', 'TeacherController::create');
        $routes->post('teachers/store', 'TeacherController::store');




        // $routes->resource('teachers', ['controller' => 'TeacherController']);
        $routes->resource('subscribe_transactions', ['controller' => 'SubscribeTransactionController']);
    });

    // Courses Routes for 'owner' and 'teacher' roles
    $routes->group('', ['filter' => 'role:owner,teacher'], function ($routes) {
        $routes->resource('courses', ['controller' => 'CourseController']);
        // Add Video Routes for Teachers and Owners
        $routes->get('/add/video/(:segment)', 'CourseVideoController::create/$1', ['filter' => 'role:teacher,owner', 'as' => 'course.add_video']);
        $routes->post('/add/video/save/(:segment)', 'CourseVideoController::store/$1', ['filter' => 'role:teacher,owner', 'as' => 'course.add_video.save']);
        $routes->resource('course_videos', ['controller' => 'CourseVideoController']);
    });
});
