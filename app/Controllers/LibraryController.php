<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\Library_UploadModel;

class LibraryController extends ResourceController
{
    protected $Library_UploadModel;
    protected $db;

    public function __construct()
    {
        $this->Library_UploadModel = new Library_UploadModel();
        $this->db = \Config\Database::connect();
    }

    public function getAllLibraryFiles()
    {
        $this->db->transStart();

        $files = $this->Library_UploadModel->getAllLibraryFiles();

        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            return $this->fail("Failed to retrieve library files.");
        }

        return $this->respond($files);
    }
}