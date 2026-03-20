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
$routes->get('forum/posts', 'ForumController::getAllPosts');
$routes->get('forum/post/(:num)', 'ForumController::getPost/$1');
$routes->get('forum/bookmarks/(:num)', 'ForumController::getBookmarks/$1');

// MENTORCHIP
$routes->get('mentorchip', 'MentorchipController::getAllMentorchip');
$routes->get('mentorchip/user', 'MentorchipController::getUserMentorchip');

//      - create, update, delete
$routes->post('mentorchip', 'MentorchipController::createMentorchip');
$routes->post('mentorchip/update', 'MentorchipController::updateMentorchip');
$routes->post('mentorchip/delete', 'MentorchipController::deleteMentorchip');

//ADMIN - department
$routes->get('admin/departments', 'AdminController::getDepartments');
$routes->post('admin/departments', 'AdminController::createDepartment');
$routes->delete('admin/departments/(:num)', 'AdminController::deleteDepartment/$1');

//      - courses
$routes->get('admin/courses/(:num)', 'AdminController::getCourses/$1');
$routes->post('admin/courses', 'AdminController::createCourse');

//     - announcements
$routes->get('admin/announcements', 'AdminController::getAnnouncements');
$routes->post('admin/announcements', 'AdminController::createAnnouncement');

//     - orgs
$routes->get('admin/orgs', 'AdminController::getOrgs');
$routes->post('admin/orgs', 'AdminController::createOrg');

//     - keywords
$routes->get('admin/keywords', 'AdminController::getKeywords');
$routes->post('admin/keywords', 'AdminController::createKeyword');



$routes->options('(:any)', static function(){
    return service ('response')
    ->setStatusCode(200);
});
