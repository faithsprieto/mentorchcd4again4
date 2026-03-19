<?php

namespace App\Models;

use CodeIgniter\Model;

class Forum_Posts_AttachmentModel extends Model
{
    protected $table            = 'forum_posts_attachment';
    protected $primaryKey       = 'post_id';
    protected $useAutoIncrement = false; 

    protected $returnType       = 'array';
    protected $protectFields    = true;

    protected $allowedFields = [
        'post_id',
        'file_path',
        'arrangement',
    ];

}