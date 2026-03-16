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
        $limit = 30;
        $page = $this->request->getGet('page') ?? 1;
        $offset = ($page - 1) * $limit;

        $db = \Config\Database::connect();
        $db->transStart();

        try {

            $messages = $this->messagesModel->getChatMessages($chatId, $limit, $offset);

            $db->transComplete();

            return $this->respond([
                "status" => "success",
                "page" => $page,
                "limit" => $limit,
                "data" => $messages
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
