<?php

namespace App\Models;

use CodeIgniter\Model;

class AnnouncementsModel extends Model
{
    protected $table            = 'announcements';
    protected $primaryKey       = 'announcement_id';
    protected $useAutoIncrement = false;

    protected $returnType       = 'array';
    protected $protectFields    = true;

    protected $allowedFields = [
        'department_id',
        'title',
        'description',
        'image',
        'created_at',
        'is_deleted',
    ];

    

}
