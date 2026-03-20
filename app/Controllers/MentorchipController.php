<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class MentorchipController extends Controller
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    // =========================
    // GET ALL (NO PARAMS)
    // =========================
    public function getAllMentorchip()
    {
        try {
            $this->db->transStart();

            $sql = <<<SQL
            SELECT *
            FROM mentorchip
            ORDER BY created_at DESC
            SQL;

            $data = $this->db->query($sql)->getResultArray();

            $this->db->transComplete();

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

    // =========================
    // GET USER (USES getGet)
    // =========================
    public function getUserMentorchip()
    {
        try {
            $this->db->transStart();

            // ✅ CORRECT: getGet for GET requests
            $user_id = $this->request->getGet('user_id');

            if (!$user_id) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'user_id is required'
                ]);
            }

            $sql = <<<SQL
            SELECT *
            FROM mentorchip
            WHERE mentor_id = ? OR mentee_id = ?
            ORDER BY created_at DESC
            SQL;

            $data = $this->db->query($sql, [$user_id, $user_id])->getResultArray();

            $this->db->transComplete();

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

    // =========================
    // CREATE (USES getPost)
    // =========================
    public function createMentorchip()
    {
        try {
            $this->db->transStart();

            // ✅ CORRECT: getPost for POST requests
            $mentor_id   = $this->request->getPost('mentor_id');
            $mentee_id   = $this->request->getPost('mentee_id');
            $requested_by = $this->request->getPost('requested_by');
            $request_type = $this->request->getPost('request_type');

            if (!$mentor_id || !$mentee_id || !$requested_by || !$request_type) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Missing required fields'
                ]);
            }

            $sql = <<<SQL
            INSERT INTO mentorchip (mentor_id, mentee_id, requested_by, request_type)
            VALUES (?, ?, ?, ?)
            SQL;

            $this->db->query($sql, [
                $mentor_id,
                $mentee_id,
                $requested_by,
                $request_type
            ]);

            $this->db->transComplete();

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Created successfully'
            ]);

        } catch (\Exception $e) {
            $this->db->transRollback();

            return $this->response->setJSON([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    // =========================
    // UPDATE (USES getPost)
    // =========================
    public function updateMentorchip()
    {
        try {
            $this->db->transStart();

            // ✅ CORRECT
            $id     = $this->request->getPost('mentorch_id');
            $status = $this->request->getPost('status');

            if (!$id || !$status) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Missing required fields'
                ]);
            }

            $sql = <<<SQL
            UPDATE mentorchip
            SET status = ?, responded_at = NOW()
            WHERE mentorch_id = ?
            SQL;

            $this->db->query($sql, [$status, $id]);

            $this->db->transComplete();

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Updated successfully'
            ]);

        } catch (\Exception $e) {
            $this->db->transRollback();

            return $this->response->setJSON([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    // =========================
    // DELETE (USES getPost)
    // =========================
    public function deleteMentorchip()
    {
        try {
            $this->db->transStart();

            // ✅ CORRECT
            $id = $this->request->getPost('mentorch_id');

            if (!$id) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'mentorch_id is required'
                ]);
            }

            $sql = <<<SQL
            DELETE FROM mentorchip
            WHERE mentorch_id = ?
            SQL;

            $this->db->query($sql, [$id]);

            $this->db->transComplete();

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Deleted successfully'
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