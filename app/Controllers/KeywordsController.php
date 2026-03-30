<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\KeywordsModel;

class KeywordsController extends ResourceController
{
    protected $keywordsModel;
    protected $db;

    public function __construct()
    {
        $this->keywordsModel = new KeywordsModel();
        $this->db = \Config\Database::connect();
    }

    // ========================
    // GET ALL KEYWORDS
    // ========================
    public function getAllKeywords()
    {
        try {
            $this->db->transStart();

            $keywords = $this->keywordsModel->getKeywords();

            $this->db->transComplete();

            return $this->respond([
                'status' => 'success',
                'data' => $keywords
            ]);
        } catch (\Exception $e) {
            $this->db->transRollback();

            return $this->failServerError($e->getMessage());
        }
    }

    // ========================
    // CREATE KEYWORD
    // ========================
    public function createKeyword()
    {
        try {
            $this->db->transStart();

            $tag = $this->request->getPost('keyword');

            if (empty($tag)) {
                return $this->failValidationErrors('Keyword tag is required');
            }

            // OPTIONAL: prevent duplicates
            $sql = <<<SQL
            SELECT keyword_id 
            FROM keywords 
            WHERE keyword_tag = ?
            SQL;

            $existing = $this->db->query($sql, [$tag])->getRow();

            if ($existing) {
                return $this->fail('Keyword already exists');
            }

            $this->keywordsModel->createKeyword($tag);

            $this->db->transComplete();

            return $this->respondCreated([
                'status' => 'success',
                'message' => 'Keyword created successfully'
            ]);
        } catch (\Exception $e) {
            $this->db->transRollback();

            return $this->failServerError($e->getMessage());
        }
    }
}