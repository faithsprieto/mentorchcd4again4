<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\MessagesModel;

class MessagesController extends ResourceController
{
    protected $messagesModel;

    public function __construct()
    {
        $this->messagesModel = new MessagesModel();
    }

    public function getMessagesByChat($chatId)
    {
        $db = \Config\Database::connect();
        $db->transStart();

        try {

            $perPage = 20;

            $messages = $this->messagesModel->getPaginatedChatMessages($chatId, $perPage);

            $pager = $this->messagesModel->pager;

            $db->transComplete();

            return $this->respond([
                "status" => "success",
                "data" => $messages,
                "pager" => [
                    "currentPage" => $pager->getCurrentPage(),
                    "totalPages" => $pager->getPageCount(),
                    "perPage" => $perPage
                ]
            ]);

        } catch (\Exception $e) {

            $db->transRollback();

            return $this->respond([
                "status" => "error",
                "message" => $e->getMessage()
            ], 500);
        }
    }
}