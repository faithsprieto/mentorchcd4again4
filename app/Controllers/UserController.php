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

    public function register()
{
    // Get POST data
    $data = [
        'first_name'     => $this->request->getPost('first_name'),
        'last_name'      => $this->request->getPost('last_name'),
        'school_email'   => $this->request->getPost('school_email'),
        'student_id'     => $this->request->getPost('student_id'),
        'school_name'    => $this->request->getPost('school_name'), // optional (you included it)
        'department'     => $this->request->getPost('department'),
        'course_program' => $this->request->getPost('course_program'),
        'year_level'     => $this->request->getPost('year_level'),
        'password'       => $this->request->getPost('password'),
        'user_type'      => $this->request->getPost('user_type'),
    ];

    // Validation rules (STRICT REQUIRED)
    $rules = [
        'first_name'     => 'required|min_length[2]',
        'last_name'      => 'required|min_length[2]',
        'school_email'   => 'required|valid_email',
        'student_id'     => 'required|min_length[3]',
        'department'     => 'required',
        'course_program' => 'required',
        'year_level'     => 'required',
        'password'       => 'required|min_length[8]',
        'user_type'      => 'required|in_list[1,2,3]',
    ];

    // Validate
    if (!$this->validateData($data, $rules)) {
        return $this->respond([
            'status'  => false,
            'message' => 'Validation failed.',
            'errors'  => $this->validator->getErrors()
        ], 400);
    }

    // Register user
    $result = $this->userModel->registerUser($data);

    if (!$result['status']) {
        return $this->respond($result, 400);
    }

    return $this->respondCreated($result);
}
}