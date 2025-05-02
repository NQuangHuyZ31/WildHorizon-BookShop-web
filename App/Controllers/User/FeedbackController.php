<?php

namespace App\Controllers\User;

use App\Controllers\Controller;
use App\Models\Feedback;
use App\Models\FeedbackAnswer;
use Core\Response;
use Core\Session;
use Helpers\Redirect;
use Helpers\UploadClound;

class FeedbackController extends Controller
{

  protected $page = 'Góp ý';
  protected $feedback;
  protected $feedback_answer;

  public function __construct()
  {
    parent::__construct();
    $this->feedback = new Feedback();
    $this->feedback_answer = new FeedbackAnswer();
  }

  public function feedback()
  {
    $pageName = $this->page;

    $nosearch = true;

    require VIEW_PATH . 'user/services/feedback.php';
  }

  public function handleFeedback()
  {
    $this->checkMethod($_POST['csrf_token']);

    $file = isset($_FILES['feedback-img']) && $_FILES['feedback-img']['error'] === 0 ? $_FILES['feedback-img'] : null;

    $url_path = '';

    if (!empty($file)) {

      // Kiểm tra file
      if (!in_array(pathinfo($file['name'], PATHINFO_EXTENSION), ['png', 'jpg', 'jpeg'])) {
        Redirect::redirectWithError('404', 'File upload không đúng định dạng', '/feedback');
      }

      // Kiểm tra dung lượng file
      if ($file['size'] > (1024 * 1024)) {
        Redirect::redirectWithError('404', 'File upload phải nhỏ hơn 1MB', '/feedback');
      }

      $filePath = time() . '_' . hash('sha1', pathinfo($file['name'], PATHINFO_FILENAME));

      $url_path = UploadClound::upload($file['tmp_name'], 'feedback_images', $filePath);
    }

    $dataFeedback = [
      'user_id' => Session::get('user')['id'],
      'type' => $_POST['feedback-type'],
      'content' => $_POST['feedback-content'],
      'image' => $url_path,
      'status' => 'Chờ phản hồi',
      'created_at' => date('Y-m-d H:i:s')
    ];

    $this->feedback->insert($dataFeedback);
    Redirect::redirectWithSuccess(200, 'Cảm ơn bạn đã đóng góp ý kiến của mình.', '/feedback');
  }

  public function feedbackAnswer()
  {
    $feedbackID = $_GET['feedback'];
    $feedback_answer = $this->feedback_answer->find($feedbackID);

    Response::json([
      'answer' => $feedback_answer['answer']
    ], 200);
  }
}
