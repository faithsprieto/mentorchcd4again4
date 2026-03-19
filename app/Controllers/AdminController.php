<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

use App\Models\DepartmentsModel;
use App\Models\CoursesModel;
use App\Models\AnnouncementsModel;
use App\Models\OrganisationsModel;
use App\Models\Library_Upload_RequestModel;
use App\Models\KeywordsModel;
use App\Models\Activity_LogsModel;
use App\Models\UserModel;

class AdminController extends ResourceController
{
    protected $DepartmentsModel;
    protected $CoursesModel;
    protected $AnnouncementsModel;
    protected $OrganisationsModel;
    protected $Library_Upload_RequestModel;
    protected $KeywordsModel;
    protected $Activity_LogsModel;
    protected $UserModel;
    protected $db;

    public function __construct()
    {
        $this->DepartmentsModel = new DepartmentsModel();
        $this->CoursesModel = new CoursesModel();
        $this->AnnouncementsModel = new AnnouncementsModel();
        $this->OrganisationsModel = new OrganisationsModel();
        $this->Library_Upload_RequestModel = new Library_Upload_RequestModel();
        $this->KeywordsModel = new KeywordsModel();
        $this->Activity_LogsModel = new Activity_LogsModel();
        $this->UserModel = new UserModel();

        $this->db = \Config\Database::connect();
    }

    /*
    =============================
    DEPARTMENTS
    =============================
    */

    public function getDepartments()
    {
        return $this->respond($this->DepartmentsModel->getDepartments());
    }

    public function createDepartments()
    {
        $data = $this->request->getPost();

        $this->db->transStart();

        $this->DepartmentsModel->createDepartments($data['department_title']);

        $this->db->transComplete();

        return $this->respond(["status"=>"success"]);
    }

    public function deleteDepartments($id)
    {
        $this->db->transStart();

        $this->DepartmentsModel->deleteDepartments($id);

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
            $this->CoursesModel->getCoursesByDepartment($departmentId)
        );
    }

    public function createCourses()
    {
        $data = $this->request->getPost();

        $this->db->transStart();

        $this->CoursesModel->createCourses(
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
            $this->AnnouncementsModel->getAnnouncements()
        );
    }

    public function createAnnouncements()
    {
        $data = $this->request->getPost();

        $this->db->transStart();

        $this->AnnouncementsModel->createAnnouncements(
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

    public function getOrganisations()
    {
        return $this->respond(
            $this->OrganisationsModel->getOrganisations()
        );
    }

    public function createOrganisations()
    {
        $data = $this->request->getPost();

        $this->db->transStart();

        $this->OrganisationsModel->createOrganisations(
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
            $this->KeywordsModel->getKeywords()
        );
    }

    public function createKeywords()
    {
        $data = $this->request->getPost();

        $this->db->transStart();

        $this->KeywordsModel->createKeywords(
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
            $this->UserModel->getUserStats()
        );
    }

    public function approveLibraryUpload($requestId)
    {
        $this->db->transStart();

        $this->Library_Upload_RequestModel->approveLibraryUpload($requestId);

        $this->db->transComplete();

        return $this->respond([
            "status" => "approved"
        ]);
    }

    public function rejectLibraryUpload($requestId)
    {
        $this->db->transStart();

        $this->Library_Upload_RequestModel->rejectLibraryUpload($requestId);

        $this->db->transComplete();

        return $this->respond([
            "status" => "rejected"
        ]);
    }

    public function getActivityLogs()
    {
        return $this->respond(
            $this->Activity_LogsModel->getActivityLogs()
        );
    }
}