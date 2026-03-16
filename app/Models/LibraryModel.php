<?php

namespace App\Models;

use CodeIgniter\Model;

class LibraryModel extends Model
{
    protected $table = 'library_upload';
    protected $primaryKey = 'file_id';
    protected $returnType = 'array';

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