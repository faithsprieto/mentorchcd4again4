<?php

namespace App\Models;

use CodeIgniter\Model;

class LibraryModel extends Model
{
    protected $table = 'library_upload';
    protected $primaryKey = 'file_id';
    protected $returnType = 'array';

    
}