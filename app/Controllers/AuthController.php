<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\RESTful\ResourceController;

class AuthController extends ResourceController
{
    public function login()
    {
        $userModel = new UserModel();

        // Get JSON input
        $input = $this->request->getJSON(true);

        $identifier = $input['identifier'] ?? null; // student_id OR email
        $password   = $input['password'] ?? null;

        if (!$identifier || !$password) {
            return $this->failValidationErrors('Student ID/Email and password are required.');
        }

        // Check if identifier is email or student_id
        $user = $userModel
            ->groupStart()
                ->where('student_id', $identifier)
                ->orWhere('school_email', $identifier)
            ->groupEnd()
            ->first();

        if (!$user) {
            return $this->failNotFound('User not found.');
        }

        // Verify password
        if (!password_verify($password, $user['password'])) {
            return $this->failUnauthorized('Invalid credentials.');
        }

        // Set session
        session()->set([
            'student_id' => $user['student_id'],
            'first_name' => $user['first_name'],
            'last_name'  => $user['last_name'],
            'user_type'  => $user['user_type'],
            'isLoggedIn' => true,
        ]);

        return $this->respond([
            'status'  => 'success',
            'message' => 'Login successful.',
            'user'    => [
                'student_id' => $user['student_id'],
                'first_name' => $user['first_name'],
                'last_name'  => $user['last_name'],
                'user_type'  => $user['user_type'],
            ]
        ]);
    }
}