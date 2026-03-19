<?php

namespace App\Models;

use CodeIgniter\Model;

class Library_UploadModel extends Model
{
    protected $table            = 'library_upload';
    protected $primaryKey       = 'file_id';
    protected $useAutoIncrement = true; 

    protected $returnType       = 'array';
    protected $protectFields    = true;

    protected $allowedFields = [
        'student_id',
        'title',
        'file_name',
        'badges',
        'file_type',
        'file_path',
        'file_size',
        'upload_date',
    ];

    protected $useTimestamps = true;
    
    public function getAllLibraryFiles()
    {
        $db = \Config\Database::connect();

        $sql = <<<SQL
            SELECT 
                file_id,
                student_id,
                title,
                file_name,
                badges,
                file_type,
                file_path,
                file_size,
                upload_date
            FROM library_upload
            ORDER BY upload_date DESC
        SQL;

        return $db->query($sql)->getResultArray();
    }
}