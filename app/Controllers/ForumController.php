<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\Forum_PostsModel;

class ForumController extends ResourceController
{
    protected $forumPostsModel;

    public function __construct()
    {
        $this->forumPostsModel = new Forum_PostsModel();
    }

    // ========================
    // GET POSTS (PAGINATED 15)
    // Example: /forum/posts?page=1
    // ========================
    public function getPosts()
    {
        $perPage = (int) ($this->request->getGet('per_page') ?? 15);

        $posts = $this->forumPostsModel->getPostsPaginated($perPage);

        $postIds = array_column($posts, 'post_id');

        $attachments = [];
        if (!empty($postIds)) {
            $attachments = $this->forumPostsModel->getAttachmentsByPostIds($postIds);
        }

        $groupedAttachments = [];
        foreach ($attachments as $attachment) {
            $groupedAttachments[$attachment['post_id']][] = $attachment;
        }

        foreach ($posts as &$post) {
            $post['attachments'] = $groupedAttachments[$post['post_id']] ?? [];
        }

        return $this->respond([
            'data'  => $posts,
            'pager' => $this->forumPostsModel->pager->getDetails(),
        ]);
    }

    // ========================
    // GET SINGLE POST
    // Example: /forum/post?post_id=12
    // ========================
    public function getPost()
    {
        $postId = $this->request->getGet('post_id');

        if (empty($postId)) {
            return $this->failValidationErrors([
                'post_id' => 'post_id is required.'
            ]);
        }

        $post = $this->forumPostsModel
            ->where('post_id', $postId)
            ->first();

        if (!$post) {
            return $this->failNotFound('Post not found');
        }

        $attachments = $this->forumPostsModel->getAttachmentsByPostId($postId);
        $comments    = $this->forumPostsModel->getCommentsPaginated($postId, 20);

        $post['attachments'] = $attachments;
        $post['comments'] = [
            'data'  => $comments,
            'pager' => $this->forumPostsModel->pager->getDetails(),
        ];

        return $this->respond($post);
    }

    // ========================
    // GET COMMENTS (PAGINATED 20)
    // Example: /forum/comments?post_id=12
    // ========================
    public function getComments()
    {
        $postId = $this->request->getGet('post_id');

        if (empty($postId)) {
            return $this->failValidationErrors([
                'post_id' => 'post_id is required.'
            ]);
        }

        $perPage = (int) ($this->request->getGet('per_page') ?? 20);

        $comments = $this->forumPostsModel->getCommentsPaginated($postId, $perPage);

        return $this->respond([
            'data'  => $comments,
            'pager' => $this->forumPostsModel->pager->getDetails(),
        ]);
    }

    // ========================
    // GET BOOKMARKS
    // Example: /forum/bookmarks?student_id=2024001
    // ========================
    public function getBookmarks()
    {
        $studentId = $this->request->getGet('student_id');

        if (empty($studentId)) {
            return $this->failValidationErrors([
                'student_id' => 'student_id is required.'
            ]);
        }

        $bookmarks = $this->forumPostsModel->getBookmarks($studentId);

        return $this->respond([
            'data' => $bookmarks
        ]);
    }
} 