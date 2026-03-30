<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\Library_UploadModel;
use App\Models\Library_Upload_RequestModel;

class LibraryController extends ResourceController
{
    protected $Library_UploadModel;
    protected $Library_Upload_RequestModel;
    protected $db;

    public function __construct()
    {
        $this->Library_Upload_RequestModel = new Library_Upload_RequestModel();
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
    public function uploadFile()
    {
        try {
            $userId    = $this->request->getPost('user_id');
            $title     = $this->request->getPost('title');
            $keywordIds = $this->request->getPost('keyword_id'); // can be array
            $file      = $this->request->getFile('file');

            if (empty($userId)) {
                return $this->respond([
                    'status'  => false,
                    'message' => 'user_id is required.'
                ], 400);
            }

            if (empty($title)) {
                return $this->respond([
                    'status'  => false,
                    'message' => 'title is required.'
                ], 400);
            }

            if (!$file || !$file->isValid()) {
                return $this->respond([
                    'status'  => false,
                    'message' => 'Valid file is required.'
                ], 400);
            }

            if (empty($keywordIds)) {
                return $this->respond([
                    'status'  => false,
                    'message' => 'At least one keyword_id is required.'
                ], 400);
            }

            // make sure keywordIds is always an array
            if (!is_array($keywordIds)) {
                $keywordIds = [$keywordIds];
            }

            $newName = $file->getRandomName();
            $uploadPath = ROOTPATH . 'writable/uploads/library';

            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            $file->move($uploadPath, $newName);

            $filePath = 'writable/uploads/library/' . $newName;
            $fileName = $file->getClientName();

            $result = $this->Library_Upload_RequestModel->processUpload([
                'student_id' => $userId,
                'title'      => $title,
                'file_name'  => $fileName,
                'file_path'  => $filePath,
                'keyword_ids'=> $keywordIds,
            ]);

            if (!$result['status']) {
                // optional cleanup if db failed after file upload
                if (file_exists(ROOTPATH . $filePath)) {
                    unlink(ROOTPATH . $filePath);
                }

                return $this->respond([
                    'status'  => false,
                    'message' => $result['message']
                ], 500);
            }

            return $this->respondCreated([
                'status'  => true,
                'message' => 'File uploaded successfully.',
                'data'    => $result['data']
            ]);

        } catch (\Throwable $e) {
            return $this->respond([
                'status'  => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function getFilesWithTags()
    {
        try {
            $studentId = $this->request->getGet('student_id'); // optional

            $result = $this->Library_Upload_RequestModel->getFilesWithTags($studentId);

            return $this->respond([
                'status'  => true,
                'message' => 'Files retrieved successfully.',
                'data'    => $result,
            ], 200);

        } catch (\Throwable $e) {
            return $this->respond([
                'status'  => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    
}