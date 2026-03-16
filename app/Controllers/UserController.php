<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\UserModel;

class UserController extends ResourceController
{
    protected $userModel;
    protected $db;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->db = \Config\Database::connect();
    }

    public function getAllUsers()
    {
        $this->db->transStart();

        $users = $this->userModel->findAll();

        $this->db->transComplete();

        return $this->respond([
            'status' => 'success',
            'data' => $users
        ]);
    }
}