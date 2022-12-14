<?php

namespace Odc\Mvc\controllers;
use Odc\Mvc\core\Controller;
use Odc\Mvc\core\DB;
use Odc\Mvc\core\Session;
use Odc\Mvc\models\StudentModel;
use Odc\Mvc\core\Validation;

class Student
{

    use Controller;
    public function __construct()
    {
        Session::authorize("login");
    }
    public function index()
    {
        $studentmodel = new StudentModel;
        $students = $studentmodel->getAllStudent();
        return $this->views("indexstudent", ['students' => $students]);
    }
    public function create()
    {
        $db = new DB;
        $branches = $db->select('branches', "*")->all();

        return $this->views("createstudent", ['branches' => $branches]);
    }
    public function store()
    {

        $studentmodel = new StudentModel;
        $studentmodel->createNewStudent($_POST);
        header("location: index");
    }
    public function delete($id)
    {
        $studentmodel = new StudentModel;
        $studentmodel->deleteStudent($id);
        header("location: ../index");
    }
    public function edit($id)
    {
        $db = new DB;
        $branches = $db->select('branches', "*")->all();

        $studentmodel = new StudentModel;
        $student = $studentmodel->getStudentById($id);
        return $this->views("editstudent", ['student' => $student, 'branches' => $branches]);
    }
    public function update()
    {
        if (empty($_POST['password'])) {
            unset($_POST['password']);
        }
        $validation = new Validation;
        $validation->input("email")->value()->email()->showError();
        if(!$validation->input("email")->value()->email()->returnerror())
        {
            echo "171";die;
        }else
        {
             $studentmodel = new StudentModel;
        $studentmodel->updateStudent($_POST);header("location: ../index.php");}
       
        

    }
    public function search()
    {
        print_r($_GET);

        $Search= $_GET['search'];
        if (strlen($Search) == 0) {
            return $this->views("searchstudent", ['students' => []]);
        }
        $query = new StudentModel;
        $q = $query->searchstudent($Search);
        // print_r($query);
        return $this->views("searchstudent", ['students' => $q]);
        
    }
}