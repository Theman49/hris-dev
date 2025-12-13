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
    $routes->get('request/edit/(:segment)', 'Recruitment::requestEdit/$1', ['filter' => 'adminfilter']);
    $routes->post('request/revise', 'Recruitment::requestRevise', ['filter' => 'adminfilter']);
    $routes->post('request/approve', 'Recruitment::requestApprove', ['filter' => 'adminfilter']);
    $routes->post('request/resubmit', 'Recruitment::requestResubmit', ['filter' => 'adminfilter']);

    $routes->get('applicant', 'Recruitment::applicant', ['filter' => 'adminfilter']);
    $routes->get('applicant/add', 'Recruitment::applicantAdd', ['filter' => 'adminfilter']);
    $routes->post('applicant/add', 'Recruitment::applicantSubmit', ['filter' => 'adminfilter']);
    $routes->get('applicant/edit/(:segment)', 'Recruitment::applicantEdit/$1', ['filter' => 'adminfilter']);
    $routes->post('applicant/edit', 'Recruitment::applicantUpdate', ['filter' => 'adminfilter']);
});

// authenticate
$routes->get('/login', 'Authenticate::login');
$routes->post('/login', 'Authenticate::loginSubmit');
$routes->get('/logout', 'Authenticate::logout');


// employee
$routes->group('employee', ['filter' => 'authfilter'], function($routes){
    $routes->get('/', 'Employee::information');
    $routes->get('/edit', 'Employee::edit', ['filter' => 'adminfilter']);
});

// career
$routes->group('career', ['filter' => 'authfilter'], function($routes){
    $routes->get('/', 'Career::transition');
    $routes->get('detail/(:segment)', 'Career::transitionDetail/$1');
    $routes->get('detail/add/(:segment)', 'Career::transitionDetailAdd/$1', ['filter' => 'adminfilter']);
    $routes->post('detail/add/', 'Career::transitionDetailSubmit', ['filter' => 'adminfilter']);
});

// leave
$routes->group('leave', ['filter' => 'authfilter'], function($routes){
    $routes->get('/', 'Leave::request');
    $routes->get('request/add', 'Leave::requestAdd');
    $routes->get('request/edit/(:segment)', 'Leave::requestEdit/$1');
    $routes->post('request/add', 'Leave::requestSubmit');
    $routes->post('request/approve', 'Leave::requestApprove');
    $routes->post('request/revise', 'Leave::requestRevise');
    $routes->post('request/resubmit', 'Leave::requestResubmit');

    $routes->get('balance', 'Leave::balance');
    $routes->get('balance/detail/(:segment)', 'Leave::balanceDetail/$1');
    $routes->post('balance/generate', 'Leave::generateBalance');

    //API
    $routes->post('balance/get', 'Leave::getBalance');
    $routes->get('setting/get', 'Leave::getLeaveSetting');
    $routes->get('image/(:any)', 'Leave::showAttachment/$1');
});

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

    $routes->get('company', 'Setting::company');
    $routes->get('company/edit/(:segment)', 'Setting::companyEdit/$1');
    $routes->post('company/edit', 'Setting::companyUpdate');
});