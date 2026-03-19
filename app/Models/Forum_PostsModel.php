<?php

namespace App\Models;

use CodeIgniter\Model;

class Forum_PostsModel extends Model
{
    protected $table = 'forum_posts';
    protected $primaryKey = 'post_id';
    protected $returnType = 'array';

    public function getPosts()
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
        SQL;

        return $this->query($sql)->getResultArray();
    }


    public function getComments($postId)
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
        ORDER BY c.date_time ASC
        SQL;

        return $this->db->query($sql, [$postId])->getResultArray();
    }


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
}