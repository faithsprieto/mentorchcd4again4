<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\CalendarModel;

class CalendarController extends ResourceController
{
    protected $calendarModel;

    public function __construct()
    {
        $this->calendarModel = new CalendarModel();
    }

    public function getAllCalendar()
    {
        $calendar = $this->calendarModel->getAllCalendar();

        return $this->respond([
            "status" => 200,
            "data" => $calendar
        ]);
    }
}