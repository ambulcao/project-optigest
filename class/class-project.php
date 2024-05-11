<?php

class Project {
    public $id;
    public $id_employee;
    public $description;
    public $value;
    public $status;
    public $delivery_date;
    
    public function __construct($id, $id_employee, $description, $value, $status, $delivery_date) {
        $this->id = $id;
        $this->id_employee = $id_employee;
        $this->description = $description;
        $this->value = $value;
        $this->status = $status;
        $this->delivery_date = $delivery_date;
    }
}