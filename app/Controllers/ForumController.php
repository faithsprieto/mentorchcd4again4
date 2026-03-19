<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\Forum_PostsModel;

class ForumController extends ResourceController
{
    protected $Forum_PostsModel;

    public function __construct()
    {
        $this->Forum_PostsModel = new Forum_PostsModel();
    }

    // ========================
    // GET POSTS (PAGINATED 15)
    // ========================
    public function getPosts()
    {
        $db = \Config\Database::connect();

        $db->transStart();

        // ✅ Use model paginate
        $posts = $this->Forum_PostsModel->getPostsPaginated(15);

        // 🔥 Attachments batching
        $postIds = array_column($posts, 'post_id');

        $attachments = [];
        if (!empty($postIds)) {
            $attachments = $this->Forum_PostsModel->getAttachmentsByPostIds($postIds);
        }

        $grouped = [];
        foreach ($attachments as $att) {
            $grouped[$att['post_id']][] = $att;
        }

        foreach ($posts as &$post) {
            $post['attachments'] = $grouped[$post['post_id']] ?? [];
        }

        $db->transComplete();

        return $this->respond([
            'data' => $posts,
            'pager' => $this->Forum_PostsModel->pager->getDetails()
        ]);
    }


    // ========================
    // GET SINGLE POST
    // ========================
    public function getPost($postId)
    {
        $db = \Config\Database::connect();

        $db->transStart();

        // ⚠️ Since paginate is used, we fetch directly
        $post = $this->Forum_PostsModel
            ->where('post_id', $postId)
            ->first();

        if (!$post) {
            return $this->failNotFound('Post not found');
        }

        // 🔥 Attachments
        $attachments = $this->Forum_PostsModel->getAttachmentsByPostId($postId);

        // 🔥 Comments (first page)
        $comments = $this->Forum_PostsModel->getCommentsPaginated($postId, 20);

        $db->transComplete();

        $post['attachments'] = $attachments;
        $post['comments'] = [
            'data' => $comments,
            'pager' => $this->Forum_PostsModel->pager->getDetails()
        ];

        return $this->respond($post);
    }


    // ========================
    // GET COMMENTS (PAGINATED 20)
    // ========================
    public function getComments($postId)
    {
        $db = \Config\Database::connect();

        $db->transStart();

        $comments = $this->Forum_PostsModel->getCommentsPaginated($postId, 20);

        $db->transComplete();

        return $this->respond([
            'data' => $comments,
            'pager' => $this->Forum_PostsModel->pager->getDetails()
        ]);
    }


    // ========================
    // GET BOOKMARKS
    // ========================
    public function getBookmarks($studentId)
    {
        $db = \Config\Database::connect();

        $db->transStart();

        $bookmarks = $this->Forum_PostsModel->getBookmarks($studentId);

        $db->transComplete();

        return $this->respond($bookmarks);
    }
}