<?php

namespace App\Models;

use CodeIgniter\Model;

class Forum_CommentsModel extends Model
{
    protected $table            = 'forum_comments';
    protected $primaryKey       = 'comment_id';
    protected $useAutoIncrement = false; // not marked AUTO_INCREMENT in dump

    protected $returnType       = 'array';
    protected $protectFields    = true;

    protected $allowedFields = [
        'post_id',
        'student_id',
        'comment_description',
        'date_time',
    ];

    protected $useTimestamps = true;
}