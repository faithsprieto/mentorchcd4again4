<?php

namespace App\Models;

use CodeIgniter\Model;

class Forum_BookmarksModel extends Model
{
    protected $table            = 'forum_bookmarks';
    protected $primaryKey       = 'bookmarks_id';
    protected $useAutoIncrement = true; 

    protected $returnType       = 'array';
    protected $protectFields    = true;

    protected $allowedFields = [
        'student_id',
        'thread_id',
        'post_id',
    ];


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