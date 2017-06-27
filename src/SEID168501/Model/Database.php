<?php
/**
 * Created by PhpStorm.
 * User: Web App Develop-PHP
 * Date: 5/29/2017
 * Time: 1:40 PM
 */

namespace App\Model;

use PDO, PDOException;
class Database
{
    public $DBH;

    public function __construct()
    {
        try{
            $this->DBH =new PDO("mysql:host=localhost;dbname=user-management", "root", "");
            //echo "Database Connection Successful!";

        }catch(PDOException $error){

            echo $error->getMessage();
        }
    }
}