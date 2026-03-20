<?php

namespace App\Models;

use CodeIgniter\Model;

class Forum_DenormalizedModel extends Model
{
    protected $table            = 'forum_denormalized';
    protected $primaryKey       = 'post_id';
    protected $useAutoIncrement = true; 

    protected $returnType       = 'array';
    protected $protectFields    = true;

    protected $allowedFields = [
        'comments_count',
        'bookmarks_count',
    ];

}