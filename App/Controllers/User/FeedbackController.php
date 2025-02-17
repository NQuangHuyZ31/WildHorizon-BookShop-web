<?php

namespace App\Controllers\User;

use App\Controllers\Controller;

class FeedbackController extends Controller
{
  public function feedback()
  {

    $nosearch = true;

    require VIEW_PATH . 'user/services/feedback.php';
  }

  public function handleFeedback()
  {

    echo $_POST['feedback'] . ',' . $_FILES['feedback-img']['name'];
  }
}
