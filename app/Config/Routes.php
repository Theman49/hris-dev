<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->group('admin', ['filter' => 'authfilter'], function($routes){
//     $routes->get('/', 'Home::index');
// });


$routes->get('/', 'Home::index', ['filter' => 'authfilter']);


// recruitment
$routes->group('recruitment', ['filter' => 'authfilter'], function($routes){
    $routes->get('request', 'Recruitment::request', ['filter' => 'adminfilter']);
    $routes->get('request/add', 'Recruitment::requestAdd', ['filter' => 'adminfilter']);
    $routes->post('request/add', 'Recruitment::requestSubmit', ['filter' => 'adminfilter']);

    $routes->get('applicant', 'Recruitment::applicant', ['filter' => 'adminfilter']);
    $routes->get('applicant/add', 'Recruitment::applicantAdd', ['filter' => 'adminfilter']);
    $routes->post('applicant/add', 'Recruitment::applicantSubmit', ['filter' => 'adminfilter']);
});

// authenticate
$routes->get('/login', 'Authenticate::login');
$routes->post('/login', 'Authenticate::loginSubmit');
$routes->get('/logout', 'Authenticate::logout');


// career
$routes->get('/career', 'Career::index');
$routes->get('/career/edit', 'Career::edit');

// employee
$routes->group('employee', ['filter' => 'authfilter'], function($routes){
    $routes->get('/', 'Employee::information');
    $routes->get('/edit', 'Employee::edit', ['filter' => 'adminfilter']);
});

// leave
$routes->get('/leave', 'Leave::index');
$routes->get('/leave/request', 'Leave::request');

//setting
$routes->group('setting', ['filter' => 'authfilter'], function($routes){
    $routes->get('position', 'Setting::position');
    $routes->get('position/add', 'Setting::positionAdd');
    $routes->get('position/edit/(:segment)', 'Setting::positionEdit/$1');
    $routes->post('position/add', 'Setting::positionInsert');
    $routes->post('position/edit', 'Setting::positionUpdate');
    $routes->post('position/delete', 'Setting::positionRemove');

    $routes->get('level', 'Setting::level');
    $routes->get('level/add', 'Setting::levelAdd');
    $routes->get('level/edit/(:segment)', 'Setting::levelEdit/$1');
    $routes->post('level/add', 'Setting::levelInsert');
    $routes->post('level/edit', 'Setting::levelUpdate');
    $routes->post('level/delete', 'Setting::levelRemove');

    $routes->get('career-type', 'Setting::careerType');
});