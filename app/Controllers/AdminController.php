<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

use App\Models\AdminDepartmentModel;
use App\Models\AdminCourseModel;
use App\Models\AdminAnnouncementModel;
use App\Models\AdminOrgModel;
use App\Models\AdminKeywordModel;
use App\Models\AdminDashboardModel;

class AdminController extends ResourceController
{
    protected $departmentModel;
    protected $courseModel;
    protected $announcementModel;
    protected $orgModel;
    protected $keywordModel;
    protected $dashboardModel;
    protected $db;

    public function __construct()
    {
        $this->departmentModel = new AdminDepartmentModel();
        $this->courseModel = new AdminCourseModel();
        $this->announcementModel = new AdminAnnouncementModel();
        $this->orgModel = new AdminOrgModel();
        $this->keywordModel = new AdminKeywordModel();
        $this->dashboardModel = new AdminDashboardModel();

        $this->db = \Config\Database::connect();
    }

    /*
    =============================
    DEPARTMENTS
    =============================
    */

    public function getDepartments()
    {
        return $this->respond($this->departmentModel->getDepartments());
    }

    public function createDepartment()
    {
        $data = $this->request->getJSON(true);

        $this->db->transStart();

        $this->departmentModel->createDepartment($data['department_title']);

        $this->db->transComplete();

        return $this->respond(["status"=>"success"]);
    }

    public function deleteDepartment($id)
    {
        $this->db->transStart();

        $this->departmentModel->deleteDepartment($id);

        $this->db->transComplete();

        return $this->respond(["status"=>"deleted"]);
    }

    /*
    =============================
    COURSES
    =============================
    */

    public function getCourses($departmentId)
    {
        return $this->respond(
            $this->courseModel->getCoursesByDepartment($departmentId)
        );
    }

    public function createCourse()
    {
        $data = $this->request->getJSON(true);

        $this->db->transStart();

        $this->courseModel->createCourse(
            $data['department_id'],
            $data['course_title']
        );

        $this->db->transComplete();

        return $this->respond(["status"=>"success"]);
    }

    /*
    =============================
    ANNOUNCEMENTS
    =============================
    */

    public function getAnnouncements()
    {
        return $this->respond(
            $this->announcementModel->getAnnouncements()
        );
    }

    public function createAnnouncement()
    {
        $data = $this->request->getJSON(true);

        $this->db->transStart();

        $this->announcementModel->createAnnouncement(
            $data['department_id'],
            $data['title'],
            $data['description'],
            $data['image']
        );

        $this->db->transComplete();

        return $this->respond(["status"=>"success"]);
    }

    /*
    =============================
    ORGANIZATIONS
    =============================
    */

    public function getOrgs()
    {
        return $this->respond(
            $this->orgModel->getOrgs()
        );
    }

    public function createOrg()
    {
        $data = $this->request->getJSON(true);

        $this->db->transStart();

        $this->orgModel->createOrg(
            $data['org_title'],
            $data['file_path'],
            $data['description']
        );

        $this->db->transComplete();

        return $this->respond(["status"=>"success"]);
    }

    /*
    =============================
    KEYWORDS
    =============================
    */

    public function getKeywords()
    {
        return $this->respond(
            $this->keywordModel->getKeywords()
        );
    }

    public function createKeyword()
    {
        $data = $this->request->getJSON(true);

        $this->db->transStart();

        $this->keywordModel->createKeyword(
            $data['keyword_tag']
        );

        $this->db->transComplete();

        return $this->respond(["status"=>"success"]);
    }

    /*
    =============================
    DASHBOARD
    =============================
    */

    public function getUserStats()
    {
        return $this->respond(
            $this->dashboardModel->getUserStats()
        );
    }

    public function approveLibraryUpload($requestId)
    {
        $this->db->transStart();

        $this->dashboardModel->approveLibraryUpload($requestId);

        $this->db->transComplete();

        return $this->respond([
            "status" => "approved"
        ]);
    }

    public function rejectLibraryUpload($requestId)
    {
        $this->db->transStart();

        $this->dashboardModel->rejectLibraryUpload($requestId);

        $this->db->transComplete();

        return $this->respond([
            "status" => "rejected"
        ]);
    }

    public function getActivityLogs()
    {
        return $this->respond(
            $this->dashboardModel->getActivityLogs()
        );
    }
}