<?php

namespace App\Models;

use CodeIgniter\Model;

class OrganisationsModel extends Model
{
    protected $table            = 'organisations';
    protected $primaryKey       = 'org_id';
    protected $useAutoIncrement = false;

    protected $returnType       = 'array';
    protected $protectFields    = true;

    protected $allowedFields = [
        'org_title',
        'file_path',
        'description',
        'created_at',
        'is_deleted',
    ];

    


}
