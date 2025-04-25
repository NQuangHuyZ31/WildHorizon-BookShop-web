<?php

namespace App\Controllers\User;

use App\Controllers\Controller;
use App\Models\User;
use Core\Auth;
use Core\Session;
use Facebook\Facebook;
use Helpers\Redirect;

require_once 'vendor/autoload.php';
class LoginFacebookController extends Controller
{
  protected $user;

  public function __construct()
  {
    parent::__construct();
    $this->user = new User();
  }

  public function redirectToFacebook()
  {

    $fb = new Facebook([
      'app_id' => ID_APP_FB,
      'app_secret' => SERECT_KEY_APP,
      'DEFAULT_GRAPH_VERSION' => 'v19.0'
    ]);

    $helper = $fb->getRedirectLoginHelper();

    $permissions = ['email']; // Thiết lập quyền muốn truy cập

    $loginUrl = $helper->getLoginUrl('http://localhost/WildHorizon-BookShop/fb-callback', $permissions);

    header('location:' . $loginUrl . '');
    exit;
  }

  // Xử lí đăng nhập
  public function handleFacebookCallback()
  {

    $fb = new Facebook([
      'app_id' => ID_APP_FB,
      'app_secret' => SERECT_KEY_APP,
      'DEFAULT_GRAPH_VERSION' => 'v2.5'
    ]);

    $helper = $fb->getRedirectLoginHelper();

    try {
      //code...
      $accessToken = $helper->getAccessToken();
    } catch (\Throwable $th) {
      //throw $th;
      exit('Lỗi khi lấy token: ' . $th->getMessage());
    }

    if (!isset($accessToken)) {
      Redirect::redirectWithError(403, 'Lỗi đăng nhập facebook. Vui lòng thử lại', '/dang-nhap');
    }

    try {

      $response = $fb->get('/me?fields=id,name,email', $accessToken);
      $fbUser = $response->getGraphUser();
      // var_dump($fbUser);
    } catch (\Exception $e) {

      exit('Lỗi lấy thông tin Facebook: ' . $e->getMessage());
    }

    // Xử lí tạo user hoặc đăng nhập
    $email = $fbUser->getEmail();

    // Kiểm tra email
    if (!$email) {
      Redirect::redirectWithError(500, 'Facebook không cung cấp email. Không thể đăng nhập.', '/dang-nhap');
    }

    $existingUser  = $this->user->checkEmail($email, 'active');

    if ($existingUser) {
      if ($existingUser['fb_id'] == $fbUser->getId() || empty($existingUser['fb_id'])) {
        $this->user->updateColumn('fb_id', $fbUser['id'], $existingUser['id']);
        Session::set('user', [
          'id' => $existingUser['id'],
          'username' => $existingUser['username'],
          'email' => $existingUser['email'],
          'role' => $existingUser['role'],
        ]);
      }
    } else {
      $dataUser = [
        'username' => $fbUser->getName(),
        'email' => $email,
        'password' => password_hash(PW_DEFAULT, PASSWORD_DEFAULT),
        'fb_id' => $fbUser->getId(),
        'status' => 'active'
      ];

      $userID = $this->user->insert($dataUser);
      if ($userID) {
        $this->auth->login($email, PW_DEFAULT);
      }
    }

    Redirect::redirectWithSuccess(200, 'Đăng nhập thành công', '/');
    exit;
  }
}
