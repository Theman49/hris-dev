<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// recruitment
$routes->get('/recruitment', 'Recruitment::index');
$routes->get('/recruitment/request', 'Recruitment::request');

// career
$routes->get('/career', 'Career::index');
$routes->get('/career/edit', 'Career::edit');

// employee
$routes->get('/employee', 'Employee::index');
$routes->get('/employee/edit', 'Employee::edit');

// leave
$routes->get('/leave', 'Leave::index');
$routes->get('/leave/request', 'Leave::request');

//setting
$routes->get('/setting/position', 'Setting::position');
$routes->get('/setting/position/add', 'Setting::positionAdd');
$routes->get('/setting/position/edit/(:segment)', 'Setting::positionEdit/$1');
$routes->post('/setting/position/add', 'Setting::positionInsert');
$routes->post('/setting/position/edit', 'Setting::positionUpdate');
$routes->post('/setting/position/delete', 'Setting::positionRemove');

$routes->get('/setting/level', 'Setting::level');
$routes->get('/setting/level/add', 'Setting::levelAdd');
$routes->get('/setting/level/edit/(:segment)', 'Setting::levelEdit/$1');
$routes->post('/setting/level/add', 'Setting::levelInsert');
$routes->post('/setting/level/edit', 'Setting::levelUpdate');
$routes->post('/setting/level/delete', 'Setting::levelRemove');

$routes->get('/setting/career-type', 'Setting::careerType');