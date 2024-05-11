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
}