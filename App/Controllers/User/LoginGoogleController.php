<?php

namespace App\Controllers\User;

require_once 'vendor/autoload.php';

use App\Controllers\Controller;
use App\Models\User;
use Google\Client;
use Google\Service\Oauth2;
use Helpers\Redirect;

class LoginGoogleController extends Controller
{

  protected $client;
  protected $user;

  public function __construct()
  {
    parent::__construct();
    $this->user = new User();
    $this->client = new Client();
    $this->client->setClientId(GG_CLIENT_ID);
    $this->client->setClientSecret(GG_CLIENT_SERECT);
    $this->client->setRedirectUri(GG_REDIRECT_URI);
    $this->client->addScope('email');
    $this->client->addScope('profile');
  }
  public function redirectToGoogle()
  {
    $authUrl = $this->client->createAuthUrl();
    header('location: ' . $authUrl . '');
  }

  public function handleGoogleCallback()
  {
    if (!isset($_GET['code'])) {
      Redirect::redirectWithError(400, 'Có lỗi xảy ra. Vui lòng thử  lại', '/dang-nhap');
    }

    // 
    $token = $this->client->fetchAccessTokenWithAuthCode($_GET['code']);
    $this->client->setAccessToken($token['access_token']);

    // Lấy thông tin người dùng
    $google_oauth = new Oauth2($this->client);
    $google_account_info = $google_oauth->userinfo->get();
    $email =  $google_account_info->getEmail();

    // kiểm tra người dùng
    $exitUser = $this->user->checkEmail($email, 'active');

    if ($exitUser) {
      if ($exitUser['gg_id'] == $google_account_info->getId() || $exitUser['gg_id'] == null) {
        if ($this->user->updateColumn('gg_id', $google_account_info->getId(), $exitUser['id'])) {
          $this->auth->loginWithoutPassword($email);
        }
      }
    } else {
      // insert user mới
      $dataUser = [
        'username' => $google_account_info->getName(),
        'email' => $email,
        'password' => password_hash(PW_DEFAULT, PASSWORD_DEFAULT),
        'fb_id' => null,
        'gg_id' => $google_account_info->getId(),
        'status' => 'active'
      ];

      $user = $this->user->insert($dataUser);
      if ($user) {
        $this->auth->login($email, PW_DEFAULT);
      }
    }
    // Trả về trang chủ
    Redirect::redirectWithSuccess(200, 'Đăng nhập thành công', '/');
  }
}
