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


}