<?php

namespace App\Controllers\User;

use App\Controllers\Controller;
use App\Models\Feedback;
use Core\Session;
use Helpers\Redirect;
use Helpers\UploadClound;

class FeedbackController extends Controller
{
  protected $feedback;

  public function __construct()
  {
    parent::__construct();
    $this->feedback = new Feedback();
  }

  public function feedback()
  {

    $nosearch = true;

    require VIEW_PATH . 'user/services/feedback.php';
  }

  public function handleFeedback()
  {
    $this->checkMethod($_POST['csrf_token']);

    $file = isset($_FILES['feedback-img']) ? $_FILES['feedback-img'] : '';

    if ($file == '') {
      Redirect::redirectWithError(404, 'File chưa được upload', '/feedback');
    }

    // Kiểm tra lỗi
    if ($file['error'] != 0) {
      Redirect::redirectWithError(404, 'Có lỗi trong quá trình upload', '/feedback');
    }

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

    try {
      //code...
      if ($url_path) {
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
    } catch (\Throwable $th) {
      //throw $th;
      Redirect::redirectWithSuccess(500, 'Có lỗi xảy ra', '/feedback');
    }
  }
}
