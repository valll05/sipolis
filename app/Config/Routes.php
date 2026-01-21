<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Public routes
$routes->get('/', 'Home::index');

// Auth routes
$routes->group('auth', function($routes) {
    $routes->get('login', 'Auth::login');
    $routes->post('login', 'Auth::processLogin');
    $routes->get('register', 'Auth::register');
    $routes->post('register', 'Auth::processRegister');
    $routes->get('logout', 'Auth::logout');
});

// Admin routes (protected by admin filter)
$routes->group('admin', ['filter' => 'admin'], function($routes) {
    $routes->get('dashboard', 'Admin\Dashboard::index');
    
    // Modul management
    $routes->get('modul', 'Admin\Modul::index');
    $routes->get('modul/create', 'Admin\Modul::create');
    $routes->post('modul/store', 'Admin\Modul::store');
    $routes->get('modul/edit/(:num)', 'Admin\Modul::edit/$1');
    $routes->post('modul/update/(:num)', 'Admin\Modul::update/$1');
    $routes->get('modul/delete/(:num)', 'Admin\Modul::delete/$1');
    
    // User management
    $routes->get('user', 'Admin\User::index');
    $routes->get('user/pengajar', 'Admin\User::pengajar');
    $routes->get('user/pengajar/create', 'Admin\User::createPengajar');
    $routes->post('user/pengajar/store', 'Admin\User::storePengajar');
    $routes->get('user/delete/(:num)', 'Admin\User::delete/$1');
    
    // Jadwal management
    $routes->get('jadwal', 'Admin\Jadwal::index');
    $routes->get('jadwal/events', 'Admin\Jadwal::getEvents');
    $routes->get('jadwal/create', 'Admin\Jadwal::create');
    $routes->post('jadwal/store', 'Admin\Jadwal::store');
    $routes->get('jadwal/edit/(:num)', 'Admin\Jadwal::edit/$1');
    $routes->post('jadwal/update/(:num)', 'Admin\Jadwal::update/$1');
    $routes->get('jadwal/delete/(:num)', 'Admin\Jadwal::delete/$1');
});

// Pengajar routes (protected by pengajar filter)
$routes->group('pengajar', ['filter' => 'pengajar'], function($routes) {
    $routes->get('dashboard', 'Pengajar\Dashboard::index');
    $routes->get('jadwal', 'Pengajar\Jadwal::index');
    $routes->get('jadwal/events', 'Pengajar\Jadwal::getEvents');
    $routes->post('jadwal/status/(:num)', 'Pengajar\Jadwal::updateStatus/$1');
});

// User routes (protected by auth filter)
$routes->group('user', ['filter' => 'auth'], function($routes) {
    $routes->get('dashboard', 'User\Dashboard::index');
    $routes->get('modul', 'User\Modul::index');
    $routes->get('modul/download/(:num)', 'User\Modul::download/$1');
    $routes->post('modul/complete/(:num)', 'User\Modul::markComplete/$1');
    $routes->post('modul/bookmark/(:num)', 'User\Modul::toggleBookmark/$1');
    
    // Jadwal Konsultasi
    $routes->get('jadwal', 'User\Jadwal::index');
    $routes->get('jadwal/events', 'User\Jadwal::getEvents');
    
    // Presensi/Check-in
    $routes->get('presensi', 'User\Presensi::index');
    $routes->get('presensi/events', 'User\Presensi::getEvents');
    $routes->post('presensi/checkin', 'User\Presensi::checkIn');
    $routes->get('presensi/date/(:segment)', 'User\Presensi::getByDate/$1');
});

// Profile routes (protected by auth filter - all roles)
$routes->group('profile', ['filter' => 'auth'], function($routes) {
    $routes->get('/', 'Profile::index');
    $routes->post('update', 'Profile::update');
    $routes->post('password', 'Profile::changePassword');
});
