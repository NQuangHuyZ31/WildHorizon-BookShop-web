<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Models\BannerAdvertising;
use App\Requests\CreateBannerValidate;
use App\Requests\EditBannerValidate;
use Core\CSRF;
use Core\Session;
use Helpers\Redirect;
use Helpers\UploadClound;

class BannerAdvertistingController extends Controller
{

  protected $banner_ads;

  public function __construct()
  {
    parent::__construct();
    $this->banner_ads = new BannerAdvertising();
  }

  public function index()
  {
    $perPage = 3;
    $currentPage = isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0 ? (int)$_GET['page'] : 1;
    $offset = ($currentPage - 1) * $perPage;

    // Lấy danh sách banner theo trang
    $banners = $this->banner_ads->getLimit($perPage, $offset);

    // Tính tổng số trang
    $totalBanners = count($this->banner_ads->getAll());
    $page = ceil($totalBanners / $perPage);

    require_once VIEW_PATH . 'admin/banners/index.php';
  }

  public function showCreateBannerPage()
  {

    require_once VIEW_PATH . 'admin/banners/create.php';
  }

  public function createBanner()
  {
    if ($_SERVER['REQUEST_METHOD'] !== "POST") {
      header('location: ' . BASE_URL . '/admin/banner/create');
      exit;
    }

    if (!CSRF::verifyToken($_POST['csrf_token'])) {
      header('location: ' . BASE_URL . '/admin/banner/create');
      exit;
    }

    CSRF::destroyToken();

    $file = $_FILES['banner_image'];

    $errors = CreateBannerValidate::validate($_POST, $file);

    if (!empty($errors)) {
      Session::set('error-data', $errors);
      header('location:' . BASE_URL . '/admin/banner/create');
      exit;
    }

    // Xử lí upload ảnh banner
    $filePath = time() . '_' . hash('sha1', pathinfo($file['name'], PATHINFO_FILENAME));

    $url_path = UploadClound::upload($file['tmp_name'], 'banner_images', $filePath);

    $data = [
      'name' => $_POST['banner_name'],
      'image' => $url_path,
      'status' => $_POST['status'],
      'position' => $_POST['banner_position'],
      'created_at' => date('Y-m-d H:i:s')
    ];

    if ($this->banner_ads->insert($data)) {
      Session::delete('error-data');
      header('location: ' . BASE_URL . '/admin/banner');
      exit;
    }
  }
  // 
  public function showEditBannerPage($id)
  {

    $banner = $this->banner_ads->findByID($id);

    require_once VIEW_PATH . 'admin/banners/edit.php';
  }

  public function updateBanner()
  {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
      header('location: ' . BASE_URL . '/admin/banner/edit/' . $_POST['banner_id'] . '');
      exit;
    }

    if (!CSRF::verifyToken($_POST['csrf_token'])) {
      header('location: ' . BASE_URL . '/admin/banner/edit/' . $_POST['banner_id'] . '');
      exit;
    }

    CSRF::destroyToken();

    $file = $_FILES['banner_image'];

    if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
      $errors = EditBannerValidate::validate($_POST);
    } else {
      $errors = CreateBannerValidate::validate($_POST, $file);
    }

    if (!empty($errors)) {
      Session::set('error-data', $errors);
      header('location: ' . BASE_URL . '/admin/banner/edit/' . $_POST['banner_id'] . '');
      exit;
    }

    // Xóa ảnh cũ trên clound
    $banner = $this->banner_ads->findByID($_POST['banner_id']);

    if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
      $data = [
        'name' => $_POST['banner_name'],
        'image' => $banner['image'],
        'status' => $_POST['status'],
        'position' => $_POST['banner_position'],
        'updated_at' => date('Y-m-d H:i:s')
      ];
    } else {
      $public_id = UploadClound::extractPublicId($banner['image']);
      if (UploadClound::delete('whr_images/banner_images/' . $public_id . '')) {
        // Xử lí upload ảnh banner
        $filePath = time() . '_' . hash('sha1', pathinfo($file['name'], PATHINFO_FILENAME));

        $url_path = UploadClound::upload($file['tmp_name'], 'banner_images', $filePath);

        $data = [
          'name' => $_POST['banner_name'],
          'image' => $url_path,
          'status' => $_POST['status'],
          'position' => $_POST['banner_position'],
          'updated_at' => date('Y-m-d H:i:s')
        ];
      } else {
        Session::set('message', ['error' => 'Có  lỗi trong quá trính xóa ảnh']);
        header('location:' . BASE_URL . '/admin/banner');
      }
    }
    $this->banner_ads->update($data, $banner['id']);
    Session::set('message', ['success' => 'Cập nhật thành công.']);
    header('location:' . BASE_URL . '/admin/banner');
    exit;
  }

  public function changeStatusBanner()
  {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
      Session::set('message', ['error' => 'Có lỗi xảy ra. Vui lòng thử lại']);
      header('location:' . BASE_URL . '/admin/banner');
      exit;
    }

    if (!CSRF::verifyToken($_POST['csrf_token'])) {
      Session::set('message', ['error' => 'Có lỗi xảy ra. Vui lòng thử lại']);
      header('location:' . BASE_URL . '/admin/banner');
      exit;
    }

    CSRF::destroyToken();

    $banner = $this->banner_ads->findByID($_POST['banner_id']);
    if ($banner['status'] == 'active') {
      $this->banner_ads->updateColumn('status', 'no_active', $banner['id']);
    } else {
      $this->banner_ads->updateColumn('status', 'active', $banner['id']);
    }

    Session::set('message', ['success' => 'Cập nhật thành công']);
    header('location:' . BASE_URL . '/admin/banner');
    exit;
  }

  public function deleteBanner()
  {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
      Session::set('message', ['error' => 'Có lỗi xảy ra. Vui lòng thử lại.']);
      header('location: ' . BASE_URL . '/admin/banner');
      exit;
    }

    if (!CSRF::verifyToken($_POST['csrf_token'])) {
      Session::set('message', ['error' => 'Có lỗi xảy ra. Vui lòng thử lại.']);
      header('location: ' . BASE_URL . '/admin/banner');
      exit;
    }

    CSRF::destroyToken();

    $banner = $this->banner_ads->findByID($_POST['banner_id']);

    if (empty($banner)) {
      Session::set('message', ['error' => 'Có lỗi xảy ra. Vui lòng thử lại.']);
      header('location: ' . BASE_URL . '/admin/banner');
      exit;
    }

    $this->banner_ads->updateColumn('is_deleted', 1, $banner['id']);
    Session::set('message', ['success' => 'Xóa thành công']);
    header('location: ' . BASE_URL . '/admin/banner');
    exit;
  }
}
