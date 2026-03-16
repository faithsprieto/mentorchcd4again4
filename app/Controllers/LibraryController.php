<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\LibraryModel;

class LibraryController extends ResourceController
{
    protected $libraryModel;
    protected $db;

    public function __construct()
    {
        $this->libraryModel = new LibraryModel();
        $this->db = \Config\Database::connect();
    }

    public function getAllLibraryFiles()
    {
        $this->db->transStart();

        $files = $this->libraryModel->getAllLibraryFiles();

        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            return $this->fail("Failed to retrieve library files.");
        }

        return $this->respond($files);
    }
}