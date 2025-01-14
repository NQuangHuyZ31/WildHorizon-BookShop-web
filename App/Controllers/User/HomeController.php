<?php
namespace App\Controllers\User;

use App\Controllers\Controller;

class HomeController extends Controller {
    public function index() {
        $homePage = true;
        //$products = $this->db->query('Select *from tbl_product');
        include_once VIEW_PATH . 'user/index.php';
    }

    public function abc(){
        $username =$_GET['username'];
        $password = $_GET['password'];

        echo $password.','.$username;
        
        // include_once VIEW_PATH . 'user/index.php';
    }
}
