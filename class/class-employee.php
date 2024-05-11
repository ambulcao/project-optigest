<?php

class Employee {
    public $id;
    public $name;
    public $age;
    public $job;
    public $salary;
    public $admission_date;
    
    public function __construct($id, $name, $age, $job, $salary, $admission_date) {
        $this->id = $id;
        $this->name = $name;
        $this->age = $age;
        $this->job = $job;
        $this->salary = $salary;
        $this->admission_date = $admission_date;
    }
    
    // Getters
    public function getId() {
        return $this->id;
    }
    
    public function getName() {
        return $this->name;
    }
    
    public function getAge() {
        return $this->age;
    }
    
    public function getJob() {
        return $this->job;
    }
    
    public function getSalary() {
        return $this->salary;
    }
    
    public function getAdmissionDate() {
        return $this->admission_date;
    }
    
    // Setters
    public function setId($id) {
        $this->id = $id;
    }
    
    public function setName($name) {
        $this->name = $name;
    }
    
    public function setAge($age) {
        $this->age = $age;
    }
    
    public function setJob($job) {
        $this->job = $job;
    }
    
    public function setSalary($salary) {
        $this->salary = $salary;
    }
    
    public function setAdmissionDate($admission_date) {
        $this->admission_date = $admission_date;
    }
}
