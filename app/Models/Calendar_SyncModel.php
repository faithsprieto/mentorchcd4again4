<?php

namespace App\Models;

use CodeIgniter\Model;

class Calendar_SyncModel extends Model
{
    protected $table            = 'calendar_sync';
    protected $primaryKey       = 'calendar_sync_id';
    protected $useAutoIncrement = true; 

    protected $returnType       = 'array';
    protected $protectFields    = true;

    protected $allowedFields = [
        'date_time',
        'event',
        'description',
        'owner_id',
        'permission',
        'is_deleted',
    ];

    protected $useTimestamps = true;
}