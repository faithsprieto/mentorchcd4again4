<?php

namespace App\Controllers;

use App\Models\MentorchipModel;
use CodeIgniter\Controller;

class MentorchipController extends Controller
{
    protected $mentorchipModel;
    protected $db;

    public function __construct()
    {
        $this->mentorchipModel = new MentorchipModel();
        $this->db = \Config\Database::connect();
    }

    public function getAllMentorchips()
    {
        $this->db->transStart();

        try {
            $data = $this->mentorchipModel->getAllMentorchips();

            $this->db->transComplete();

            if ($this->db->transStatus() === false) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Transaction failed'
                ]);
            }

            return $this->response->setJSON([
                'status' => 'success',
                'data' => $data
            ]);

        } catch (\Exception $e) {
            $this->db->transRollback();

            return $this->response->setJSON([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
}