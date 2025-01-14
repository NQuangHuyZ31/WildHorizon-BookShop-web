<?php
namespace App\Controllers\User;

use App\Controllers\Controller;

class HomeController extends Controller {
    public function index() {
        $homePage = true;
        include_once VIEW_PATH . 'user/index.php';
    }

    public function feedback(){

        $nosearch = true;

        include_once VIEW_PATH.'user/feedback.php';
    }

    public function handleFeedback(){

        echo $_POST['feedback'].','.$_FILES['feedback-img']['name'];
    }
}
