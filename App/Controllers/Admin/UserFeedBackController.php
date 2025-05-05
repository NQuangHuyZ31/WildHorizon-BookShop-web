<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Models\Feedback;
use App\Models\FeedbackAnswer;
use App\Models\User;
use Core\CSRF;
use Core\Session;

class UserFeedBackController extends Controller
{
  protected $feedback;
  protected $user;
  protected $feedback_anwser;

  public function __construct()
  {
    parent::__construct();
    $this->feedback = new Feedback();
    $this->user = new User();
    $this->feedback_anwser = new FeedbackAnswer();
  }
  public function index()
  {

    $feedbacks = $this->feedback->getAll();
    require_once VIEW_PATH . 'admin/user_feedbacks/index.php';
  }

  public function showUserFeedbackDetail($id)
  {
    $feedback = $this->feedback->findByID($id);

    if ($feedback == null) {
      Session::set('message', ['error' => 'Không có thông tin']);
      header('location:' . BASE_URL . '/admin/user_feedback');
      exit;
    }

    $customer = $this->user->find($feedback['user_id']);

    $feedback_anwser = $this->feedback_anwser->find($feedback['id']);

    require_once VIEW_PATH . 'admin/user_feedbacks/user-feedback-detail.php';
  }

  public function saveAnswerFeedback()
  {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
      Session::set('message', ['error' => 'Có lỗi xảy ra.']);
      header('location:' . BASE_URL . '/admin/user_feedback/' . $_POST['feedback_id'] . '');
      exit;
    }

    if (!CSRF::verifyToken($_POST['csrf_token'])) {
      Session::set('message', ['error' => 'Có lỗi xảy ra.']);
      header('location:' . BASE_URL . '/admin/user_feedback/' . $_POST['feedback_id'] . '');
      exit;
    }

    CSRF::destroyToken();

    if (empty($_POST['fb_answer'])) {
      Session::set('error-data', ['fb_answer' => 'Thông tin không được trống']);
      header('location:' . BASE_URL . '/admin/user_feedback/' . $_POST['feedback_id'] . '');
      exit;
    }

    try {
      //code...
      $this->db->beginTransaction();
      $data = [
        'feedback_id' => $_POST['feedback_id'],
        'answer' => $_POST['fb_answer'],
        'created_at' => date('Y-m-d H:i:s')
      ];

      $this->feedback_anwser->insert($data);

      $this->feedback->updateColumn('status', 'Đã phản hồi', $data['feedback_id']);

      $this->db->commit();
      Session::set('message', ['success' => 'Đã phản hồi cho khách hàng.']);
      header('location:' . BASE_URL . '/admin/user_feedback');
      exit;
    } catch (\Throwable $th) {
      //throw $th;
      $this->db->rollBack();
      Session::set('message', ['error' => $th->getMessage()]);
      header('location:' . BASE_URL . '/admin/user_feedback/' . $_POST['feedback_id'] . '');
      exit;
    }
  }
}
