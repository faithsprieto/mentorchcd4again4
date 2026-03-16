<?php

namespace App\Models;

use CodeIgniter\Model;

class ForumModel extends Model
{
    protected $table = 'forum_posts';
    protected $primaryKey = 'post_id';

    public function getPosts($limit, $offset)
    {
        $sql = <<<SQL
        SELECT
            p.post_id,
            p.student_id,
            u.first_name,
            u.last_name,
            u.profile_picture,
            u.department,
            u.course_program,
            p.post_title,
            p.post_description,
            p.post_attachment,
            p.date_time
        FROM forum_posts p
        LEFT JOIN user u ON u.student_id = p.student_id
        ORDER BY p.date_time DESC
        LIMIT ? OFFSET ?
        SQL;

        return $this->db->query($sql, [$limit, $offset])->getResultArray();
    }


    public function getComments($postId, $limit, $offset)
    {
        $sql = <<<SQL
        SELECT
            c.comment_id,
            c.post_id,
            c.student_id,
            u.first_name,
            u.last_name,
            u.profile_picture,
            c.comment_description,
            c.date_time
        FROM forum_comments c
        LEFT JOIN user u ON u.student_id = c.student_id
        WHERE c.post_id = ?
        ORDER BY c.date_time DESC
        LIMIT ? OFFSET ?
        SQL;

        return $this->db->query($sql, [$postId, $limit, $offset])->getResultArray();
    }


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
        SQL;

        return $this->db->query($sql, [$studentId])->getResultArray();
    }

   
}