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
  
  // Getters
  public function getId() {
      return $this->id;
  }
  
  public function getIdEmployee() {
      return $this->id_employee;
  }
  
  public function getDescription() {
      return $this->description;
  }
  
  public function getValue() {
      return $this->value;
  }
  
  public function getStatus() {
      return $this->status;
  }
  
  public function getDeliveryDate() {
      return $this->delivery_date;
  }
  
  // Setters
  public function setId($id) {
      $this->id = $id;
  }
  
  public function setIdEmployee($id_employee) {
      $this->id_employee = $id_employee;
  }
  
  public function setDescription($description) {
      $this->description = $description;
  }
  
  public function setValue($value) {
      $this->value = $value;
  }
  
  public function setStatus($status) {
      $this->status = $status;
  }
  
  public function setDeliveryDate($delivery_date) {
      $this->delivery_date = $delivery_date;
  }
}
