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

    public function getStudentCalendar($studentId)
    {
        $calendar = $this->CalendarModel->getStudentCalendar($studentId);

        return $this->respond([
            "status" => 200,
            "data" => $calendar
        ]);
    }
}