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

    //GET POSTS
    public function getPosts()
    {
        $posts = $this->Forum_PostsModel
            ->select('
                forum_posts.post_id,
                forum_posts.student_id,
                user.first_name,
                user.last_name,
                user.profile_picture,
                user.department,
                user.course_program,
                forum_posts.post_title,
                forum_posts.post_description,
                forum_posts.post_attachment,
                forum_posts.date_time
            ')
            ->join('user', 'user.student_id = forum_posts.student_id', 'left')
            ->orderBy('forum_posts.date_time', 'DESC')
            ->paginate(15);


    // GET ATTACHMENTS
        $postIds = array_column($posts, 'post_id');
        $attachments = $this->Forum_PostsModel->getAttachmentsByPostIds($postIds);

        $grouped = [];
        foreach ($attachments as $att) {
            $grouped[$att['post_id']][] = $att;
        }

        foreach ($posts as &$post) {
            $post['attachments'] = $grouped[$post['post_id']] ?? [];
        }

        return $this->respond([
            'data' => $posts,
            'pager' => $this->Forum_PostsModel->pager->getDetails()
        ]);
    }

    //GET COMMENTS
    public function getComments($postId)
    {
        $comments = $this->Forum_PostsModel
            ->select('
                forum_comments.comment_id,
                forum_comments.post_id,
                forum_comments.student_id,
                user.first_name,
                user.last_name,
                user.profile_picture,
                forum_comments.comment_description,
                forum_comments.date_time
            ')
            ->from('forum_comments')
            ->join('user', 'user.student_id = forum_comments.student_id', 'left')
            ->where('forum_comments.post_id', $postId)
            ->orderBy('forum_comments.date_time', 'ASC')
            ->paginate(20);

        return $this->respond([
            'data' => $comments,
            'pager' => $this->Forum_PostsModel->pager->getDetails()
        ]);
    }

    //GET BOOKMARKS
    public function getBookmarks($studentId)
    {
        $bookmarks = $this->Forum_PostsModel->getBookmarks($studentId);

        return $this->respond($bookmarks);
    }
}