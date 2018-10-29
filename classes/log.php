<?php

class log {

private $id;
private $company;
private $user_fname;
private $user_lname;
private $information;
private $date;
private $type;

//constructors

public function __construct(){


}

public function __clone(){

}

public function __destruct(){

}

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function getCompany()
    {
        return $this->company;
    }

    public function setCompany($company)
    {
        $this->company = $company;

        return $this;
    }

    public function getUserFname()
    {
        return $this->user_fname;
    }

    public function setUserFname($user_fname)
    {
        $this->user_fname = $user_fname;

        return $this;
    }

    public function getUserLname()
    {
        return $this->user_lname;
    }

    public function setUserLname($user_lname)
    {
        $this->user_lname = $user_lname;

        return $this;
    }

    public function getInformation()
    {
        return $this->information;
    }

    public function setInformation($information)
    {
        $this->information = $information;

        return $this;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    public function save(){
      $status = false;

        $db = new mysqli('localhost' , 'root' , '' , 'lanemapper');
        mysqli_set_charset($db, "utf8");
          if (mysqli_connect_errno()){
            echo 'Error In Database Connection';
            exit;
          }
        $db->select_db('log');
        $this->date = date("Y-m-d H:i:s");
        $query = "INSERT INTO log (`id`, `date`, `company`, `first_name`, `last_name`, `information`, `type`)
                  values
                  (NULL, '$this->date', '$this->company', '$this->user_fname', '$this->user_lname', '$this->information', '$this->type')";
        if(mysqli_query($db,$query)){
          $this->id = mysqli_insert_id($db);
          $status = true;
        }else{
          printf("Errormessage: %s\n", mysqli_error($db));
        }
        $db->close();

      return $status;
    }


}




?>
