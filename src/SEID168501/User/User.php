<?php

namespace App\User;

use App\Model\Database as DB;
use App\Message\Message;
use App\Utility\Utility;
use PDO;

class User extends DB{

    public $id;
    public $firstName;
    public $lastName;
    public $email="";
    public $password="";
    public $phone="";
    public $address="";
    public $email_token="";

    public function __construct()
    {
        parent::__construct();
    }

    public function setData($data=array()){

        if(array_key_exists('id',$data)){
            $this->id=$data['id'];
        }
        if(array_key_exists('first_name',$data)){
            $this->firstName=$data['first_name'];
        }
        if(array_key_exists('last_name',$data)){
            $this->lastName=$data['last_name'];
        }
        if(array_key_exists('email',$data)){
            $this->email=$data['email'];
        }
        if(array_key_exists('password',$data)){
            $this->password=md5($data['password']);
        }
        if(array_key_exists('phone',$data)){
            $this->phone=$data['phone'];
        }
        if(array_key_exists('address',$data)){
            $this->address=$data['address'];
        }
        if(array_key_exists('email_token',$data)){
            $this->email_token=$data['email_token'];
        }
        return $this;
    }


    public function store(){

        $query = "INSERT INTO `user-management`.`users` (`first_name`, `last_name`, `email`, `password`, `phone`, `address`,`email_verified``) VALUES (?, ?, ?, ?, ?, ?, ?);";

        $dataArray = array($this->firstName, $this->lastName, $this->email, $this->password, $this->phone, $this->address, $this->email_token);

        $STH = $this->DBH->prepare($query);
        $result = $STH->execute($dataArray);

        if ($result) {
            Message::message("
                <div class=\"alert alert-success\">
                            <strong>Success!</strong> Data has been stored successfully, Please check your email and active your account.
                </div>");
            return Utility::redirect($_SERVER['HTTP_REFERER']);
        } else {
            Message::message("
                <div class=\"alert alert-danger\">
                            <strong>Failed!</strong> Data has not been stored successfully.
                </div>");
            return Utility::redirect($_SERVER['HTTP_REFERER']);
        }
    } // end of store()


    public function change_password(){
        $query="UPDATE `user-management`.`users` SET `password`=?  WHERE `users`.`email` =:email";

        $dataArray = array($this->password);

        $STH =$this->DBH->prepare($query);
        $result = $STH->execute($dataArray);

        if($result){
            Message::message("
             <div class=\"alert alert-info\">
             <strong>Success!</strong> Password has been updated  successfully.
              </div>");
        }
        else {
            echo "Error";
        }

    }

    public function view(){
        $query=" SELECT * FROM users WHERE email = '$this->email' ";
        // Utility::dd($query);
        $STH =$this->DBH->query($query);
        $STH->setFetchMode(PDO::FETCH_OBJ);
        return $STH->fetch();

    }// end of view()


    public function validTokenUpdate(){
        $query="UPDATE `user-management`.`users` SET  `email_verified`='".'Yes'."' WHERE `users`.`email` ='$this->email'";
        $result=$this->DBH->prepare($query);
        $result->execute();

        if($result){
            Message::message("
             <div class=\"alert alert-success\">
             <strong>Success!</strong> Email verification has been successful. Please login now!
              </div>");
        }
        else {
            echo "Error";
        }
        return Utility::redirect('../../../views/SEID168501/User/Profile/signup.php');
    }

    public function update(){

        $query="UPDATE `user-management`.`users` SET `first_name`= ?, `last_name` = ? , `email` = ?, `phone` = ?,
 `address` = ?  WHERE `users`.`email` = :email";

        $dataArray = array($this->firstName, $this->lastName, $this->email, $this->phone, $this->address, $this->email_token);

        $result=$this->DBH->prepare($query);

        $result->execute($dataArray);

        if($result){
            Message::message("
             <div class=\"alert alert-info\">
             <strong>Success!</strong> Data has been updated  successfully.
              </div>");
        }
        else {
            echo "Error";
        }
        return Utility::redirect($_SERVER['HTTP_REFERER']);
    }



}