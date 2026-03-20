<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\CalendarModel;

class CalendarController extends ResourceController
{
    protected $CalendarModel;

    public function __construct()
    {
        $this->CalendarModel = new CalendarModel();
    }

    public function getAllCalendar()
    {
        $calendar = $this->CalendarModel->getAllCalendar();

        return $this->respond([
            "status" => 200,
            "data" => $calendar
        ]);
    }

    public function getStudentCalendar()
    {
        $studentId = $this->request->getGet('student_id');

        if (!$studentId) {
            return $this->failValidationErrors('Student ID is required');
        }

        $this->db->transStart();

        $calendar = $this->CalendarModel->getStudentCalendar($studentId);

        $this->db->transComplete();

        return $this->respond([
            "status" => 200,
            "data" => $calendar
        ]);
    }
}