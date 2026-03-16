<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\ForumModel;

class ForumController extends ResourceController
{
    protected $forumModel;

    public function __construct()
    {
        $this->forumModel = new ForumModel();
    }

    public function getAllPosts()
    {
        $db = \Config\Database::connect();

        $db->transStart();

        $posts = $this->forumModel->getAllPosts();

        $this->forumModel->logAction(1);

        $db->transComplete();

        if ($db->transStatus() === FALSE) {
            return $this->fail("Failed retrieving forum posts");
        }

        return $this->respond($posts);
    }

    public function getPost($postId)
    {
        $db = \Config\Database::connect();

        $db->transStart();

        $post = $this->forumModel->getSinglePost($postId);
        $comments = $this->forumModel->getComments($postId);

        $this->forumModel->logAction(2);

        $db->transComplete();

        if (!$post) {
            return $this->failNotFound("Post not found");
        }

        $post['comments'] = $comments;

        return $this->respond($post);
    }

    public function getBookmarks($studentId)
    {
        $db = \Config\Database::connect();

        $db->transStart();

        $bookmarks = $this->forumModel->getBookmarks($studentId);

        $db->transComplete();

        if ($db->transStatus() === FALSE) {
            return $this->fail("Failed retrieving bookmarks");
        }

        return $this->respond($bookmarks);
    }
}