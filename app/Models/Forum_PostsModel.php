<?php

namespace App\Models;

use CodeIgniter\Model;

class Forum_PostsModel extends Model
{
    protected $table = 'forum_posts';
    protected $primaryKey = 'post_id';
    protected $returnType = 'array';


    // ========================
    // PAGINATED POSTS (15)
    // ========================
    public function getPostsPaginated($perPage = 15)
    {
        return $this
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
            ->paginate($perPage);
    }


    // ========================
    // PAGINATED COMMENTS (20)
    // ========================
    public function getCommentsPaginated($postId, $perPage = 20)
    {
        return $this->db->table('forum_comments')
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
            ->join('user', 'user.student_id = forum_comments.student_id', 'left')
            ->where('forum_comments.post_id', $postId)
            ->orderBy('forum_comments.date_time', 'ASC')
            ->paginate($perPage);
    }


    // ========================
    // ATTACHMENTS (keep raw SQL)
    // ========================
    public function getAttachmentsByPostIds($postIds)
    {
        if (empty($postIds)) return [];

        $placeholders = implode(',', array_fill(0, count($postIds), '?'));

        $sql = <<<SQL
        SELECT
            post_id,
            file_path,
            arrangement
        FROM forum_posts_attachment
        WHERE post_id IN ($placeholders)
        ORDER BY arrangement ASC
        SQL;

        return $this->db->query($sql, $postIds)->getResultArray();
    }


    public function getAttachmentsByPostId($postId)
    {
        $sql = <<<SQL
        SELECT
            file_path,
            arrangement
        FROM forum_posts_attachment
        WHERE post_id = ?
        ORDER BY arrangement ASC
        SQL;

        return $this->db->query($sql, [$postId])->getResultArray();
    }

    // ========================
    // BOOKMARKS 
    // ========================

    public function getBookmarks($studentId)
    {
    $sql = <<<SQL
    SELECT
        b.bookmark_id,
        b.post_id,
        p.post_title,
        p.date_time
    FROM forum_bookmarks b
    JOIN forum_posts p ON p.post_id = b.post_id
    WHERE b.student_id = ?
    ORDER BY p.date_time DESC
    SQL;

    return $this->db->query($sql, [$studentId])->getResultArray();
    }
}