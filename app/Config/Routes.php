<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->post('auth/login', 'AuthController::login');

//LIBRARY 
$routes->get('library', 'LibraryController::getAllLibraryFiles');

//MESSAGES
$routes->get('messages', 'MessagesController::getAllMessages');
$routes->get('messages/chat/(:num)', 'MessagesController::getMessagesByChat/$1');

//CALENDAR
$routes->get('calendar', 'CalendarController::getAllCalendar');
$routes->get('calendar/student/(:num)', 'CalendarController::getStudentCalendar/$1');

//FORUM
$$routes->get('forum/posts', 'ForumController::getAllPosts');
$routes->get('forum/post/(:num)', 'ForumController::getPost/$1');
$routes->get('forum/bookmarks/(:num)', 'ForumController::getBookmarks/$1');

$routes->options('(:any)', static function(){
    return service ('response')
    ->setStatusCode(200);
});
