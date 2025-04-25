<?php

namespace App\Controllers\Admin;

use Helpers\UploadClound;
use Core\Session;
use Core\Encrypt;
use App\Controllers\Controller;

class ProductController extends Controller
{
    public function getAllProducts()
    {
        // Lấy trang hiện tại từ URL, mặc định là 1
        $currentPage = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;

        // Số sản phẩm mỗi trang
        $perPage = 10;

        // Tính toán offset
        $offset = ($currentPage - 1) * $perPage;

        // Lấy từ khóa tìm kiếm (nếu có)
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';

        // Truy vấn để lấy tổng số sản phẩm (có áp dụng tìm kiếm)
        $countQuery = "
            SELECT COUNT(*) AS total 
            FROM products AS p
            LEFT JOIN catalogs AS c ON p.catalog_id = c.id
            WHERE p.product_name LIKE :search OR c.catalog_name LIKE :search
        ";
        $stmt = $this->db->prepare($countQuery);
        $searchParam = '%' . $search . '%';
        $stmt->bindParam(':search', $searchParam, \PDO::PARAM_STR);
        $stmt->execute();
        $totalProducts = $stmt->fetch(\PDO::FETCH_ASSOC)['total'];

        // Tính tổng số trang
        $totalPages = ceil($totalProducts / $perPage);

        // Truy vấn lấy sản phẩm có áp dụng tìm kiếm và phân trang (bỏ discount)
        $query = "
            SELECT 
                p.*, 
                c.catalog_name AS catalog_name
            FROM 
                products AS p
            LEFT JOIN 
                catalogs AS c ON p.catalog_id = c.id
            WHERE p.product_name LIKE :search OR c.catalog_name LIKE :search
            ORDER BY p.product_name ASC
            LIMIT :perPage OFFSET :offset
        ";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':search', $searchParam, \PDO::PARAM_STR);
        $stmt->bindParam(':perPage', $perPage, \PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
        $stmt->execute();

        $products = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // Truyền sản phẩm, trang hiện tại, tổng số trang và từ khóa tìm kiếm vào view
        include_once VIEW_PATH . 'admin/products/index.php';
    }

    private function getAllCatalogs()
    {
        $query = "SELECT * FROM catalogs";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        $catalogs = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $catalogs;
    }

    private function getAllSuppliers()
    {
        $query = "SELECT * FROM suppliers";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        $suppliers = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $suppliers;
    }

    private function getAllBrands()
    {
        $query = "SELECT * FROM brands";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        $brands = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $brands;
    }

    private function getAllColors()
    {
        $query = "SELECT * FROM colors";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        $colors = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $colors;
    }

    private function validateProductData($product_name, $catalog_id, $price, $discount_price, $stock, $product_image, $supplier_id, $publication_year, $currentImage = null)
    {
        $errors = [];

        // Kiểm tra tên sản phẩm
        if (empty($product_name)) {
            $errors['product_name'] = 'Tên sản phẩm không được để trống.';
        }

        // Kiểm tra danh mục
        if (empty($catalog_id)) {
            $errors['catalog_id'] = 'Vui lòng chọn danh mục.';
        }

        // Kiểm tra giá
        if (!is_numeric($price) || $price <= 0) {
            $errors['price'] = 'Giá sản phẩm phải là số lớn hơn 0.';
        }

        // Kiểm tra giảm giá
        if (!is_numeric($discount_price) || $discount_price < 0) {
            $errors['discount_price'] = 'Giảm giá phải lớn hơn 0.';
        }

        // Kiểm tra số lượng
        if (!is_numeric($stock) || $stock < 0) {
            $errors['stock'] = 'Số lượng sản phẩm phải là số không âm.';
        }

        //Kiểm tra nhà cung cấp
        if (empty($supplier_id)) {
            $errors['supplier_id'] = 'Vui lòng chọn nhà cung cấp.';
        }

        //Kiểm tra năm
        if (empty($publication_year)) {
            $errors['publication_year'] = 'Vui lòng nhập năm xuất bản hoặc năm sản xuất.';
        }

        // Kiểm tra hình ảnh
        if ($product_image && $product_image['error'] === UPLOAD_ERR_NO_FILE) {
            // Nếu không tải ảnh lên mới, thì không báo lỗi
            if (empty($currentImage)) {
                $errors['product_image'] = 'Vui lòng tải lên hình ảnh.';
            }
        } elseif ($product_image && $product_image['error'] === UPLOAD_ERR_OK) {
            // Kiểm tra phần mở rộng của tệp
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            $fileExtension = strtolower(pathinfo($product_image['name'], PATHINFO_EXTENSION));
            if (!in_array($fileExtension, $allowedExtensions)) {
                $errors['product_image'] = 'Phần mở rộng tệp không hợp lệ. Chỉ hỗ trợ JPG, PNG, GIF.';
            }

            // Kiểm tra tên ảnh trong cơ sở dữ liệu nếu có ảnh mới
            $imageName = basename($product_image['name']);
            if ($this->checkImageExists($imageName, $currentImage)) {
                $errors['product_image'] = 'Tên ảnh đã tồn tại. Vui lòng chọn tên khác.';
            }
        }
        return $errors;
    }
    private function checkImageExists($imageName, $currentImage)
    {
        // Nếu ảnh cũ không đổi, không cần kiểm tra
        if ($imageName === $currentImage) {
            return false;
        }

        // Kiểm tra trong cơ sở dữ liệu nếu tên ảnh đã tồn tại
        $query = "SELECT COUNT(*) FROM products WHERE product_image = :imageName";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':imageName', $imageName, \PDO::PARAM_STR);
        $stmt->execute();

        // Lấy kết quả
        $count = $stmt->fetchColumn();

        // Kiểm tra nếu có ít nhất một sản phẩm có tên ảnh này
        return $count > 0;
    }

    public function createProduct()
    {
        $errors = [];
        $catalogs = $this->getAllCatalogs();
        $suppliers = $this->getAllSuppliers();
        $brands = $this->getAllBrands();

        // Kiểm tra nếu là phương thức POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lấy dữ liệu từ form
            $product_name = $_POST['product_name'] ?? '';
            $description = $_POST['description'] ?? null;
            $catalog_id = $_POST['catalog_id'] ?? null;
            $price = $_POST['price'] ?? '';
            $discount_price = $_POST['discount_price'] ?? '';
            $stock = $_POST['stock'] ?? '';
            $product_image = $_FILES['product_image'] ?? null; // File upload

            $brand_id = !empty($_POST['brand_id']) ? $_POST['brand_id'] : null;
            $supplier_id = !empty($_POST['supplier_id']) ? $_POST['supplier_id'] : null;

            $color = $_POST['color'] ?? null;
            $author = $_POST['author'] ?? null;
            $publication_year = $_POST['publication_year'] ?? null;
            $publisher = $_POST['publisher'] ?? null;
            $origin = $_POST['origin'] ?? null;
            $language = $_POST['language'] ?? null;

            // Kiểm tra lỗi trên các trường
            $errors = $this->validateProductData($product_name, $catalog_id, $price, $discount_price, $stock, $product_image, $supplier_id, $publication_year);

            // Nếu không có lỗi, lưu sản phẩm
            if (empty($errors)) {
                $this->saveProduct($product_name, $description, $catalog_id, $price, $discount_price, $stock, $product_image, $supplier_id, $brand_id, $color, $publication_year, $author, $publisher, $origin, $language);
                return; // Dừng lại sau khi lưu xong và chuyển hướng
            }
        }

        // Nếu có lỗi hoặc phương thức GET, hiển thị form tạo sản phẩm
        include_once VIEW_PATH . 'admin/products/create.php';
    }

    private function saveProduct($product_name, $description, $catalog_id, $price, $discount_price, $stock, $product_image, $supplier_id, $brand_id, $color, $publication_year, $author, $publisher, $origin, $language)
    {
        $imageUrl = null;

        // Xử lý upload ảnh nếu có
        if ($product_image && $product_image['error'] === UPLOAD_ERR_OK) {
            $file = $product_image;
            $filePath = time() . '_' . hash('sha1', pathinfo($file['name'], PATHINFO_FILENAME));
            $imageUrl = UploadClound::upload($file['tmp_name'], 'product_images', $filePath);
        }

        // Chuẩn bị câu lệnh SQL
        $query = "
            INSERT INTO products (product_name, description, catalog_id, price, discount_price, stock, product_image)
            VALUES (:product_name, :description, :catalog_id, :price, :discount_price, :stock, :product_image)
        ";

        $stmt = $this->db->prepare($query);

        // Liên kết các tham số
        $stmt->bindParam(':product_name', $product_name, \PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, \PDO::PARAM_STR);
        $stmt->bindParam(':catalog_id', $catalog_id, \PDO::PARAM_INT);
        $stmt->bindParam(':price', $price, \PDO::PARAM_STR);
        $stmt->bindParam(':discount_price', $discount_price, \PDO::PARAM_INT);
        $stmt->bindParam(':stock', $stock, \PDO::PARAM_INT);
        $stmt->bindParam(':product_image', $imageUrl, \PDO::PARAM_STR);

        // Thực thi SQL
        if ($stmt->execute()) {
            $product_id = $this->db->lastInsertId();

            $detailQuery = "
                INSERT INTO product_details (product_id, supplier_id, brand_id, color, publication_year, author, publisher, origin, language)
                VALUES (:product_id, :supplier_id, :brand_id, :color, :publication_year, :author, :publisher, :origin, :language)
            ";

            $detailStmt = $this->db->prepare($detailQuery);

            $detailStmt->bindParam(':product_id', $product_id, \PDO::PARAM_INT);
            $detailStmt->bindValue(':supplier_id', $supplier_id, \PDO::PARAM_INT);
            $detailStmt->bindValue(':brand_id', !empty($brand_id) ? $brand_id : null, $brand_id !== null ? \PDO::PARAM_INT : \PDO::PARAM_NULL);
            $detailStmt->bindValue(':color', !empty($color) ? $color : null, $color !== null ? \PDO::PARAM_STR : \PDO::PARAM_NULL);
            $detailStmt->bindParam(':publication_year', $publication_year, \PDO::PARAM_STR);
            $detailStmt->bindParam(':author', $author, \PDO::PARAM_STR);
            $detailStmt->bindParam(':publisher', $publisher, \PDO::PARAM_STR);
            $detailStmt->bindParam(':origin', $origin, \PDO::PARAM_STR);
            $detailStmt->bindParam(':language', $language, \PDO::PARAM_STR);

            if ($detailStmt->execute()) {
                Session::set('message', ['success' => 'Thêm sản phẩm thành công!']);
                header('Location: ' . BASE_URL . '/admin/products');
                exit();
            } else {
                echo "Lỗi khi thêm chi tiết sản phẩm.";
            }
        } else {
            echo "Lỗi khi thêm sản phẩm.";
        }
    }


    public function deleteProduct()
    {
        $encryptedId = $_POST['id'] ?? null;

        if (!$encryptedId) {
            die("ID không hợp lệ.");
        }

        $id = Encrypt::decryptId($encryptedId, KEY);

        // Lấy thông tin ảnh từ CSDL
        $query = "SELECT product_image FROM products WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();

        $product = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($product && !empty($product['product_image'])) {
            $imageUrl = $product['product_image'];

            // Nếu ảnh là từ Cloudinary, xóa nó
            if (strpos($imageUrl, 'res.cloudinary.com') !== false) {
                $publicId = UploadClound::getPublicIdFromUrl($imageUrl);
                if ($publicId) {
                    UploadClound::delete($publicId);
                }
            }
        }

        // Xóa các bản ghi liên quan
        $deleteDetailsQuery = "DELETE FROM product_details WHERE product_id = :id";
        $stmtDetails = $this->db->prepare($deleteDetailsQuery);
        $stmtDetails->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmtDetails->execute();

        $deleteAttributesQuery = "DELETE FROM product_attributes WHERE product_id = :id";
        $stmtAttributes = $this->db->prepare($deleteAttributesQuery);
        $stmtAttributes->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmtAttributes->execute();

        // Xóa bản ghi sản phẩm
        $deleteQuery = "DELETE FROM products WHERE id = :id";
        $deleteStmt = $this->db->prepare($deleteQuery);
        $deleteStmt->bindParam(':id', $id, \PDO::PARAM_INT);

        if ($deleteStmt->execute()) {
            Session::set('message', [
                'success' => 'Xóa sản phẩm thành công!'
            ]);
            header('Location: ' . BASE_URL . '/admin/products');
            exit();
        } else {
            echo "Đã xảy ra lỗi khi xóa sản phẩm.";
        }
    }



    public function getProductById($id)
    {
        $query = "
            SELECT 
                p.*, 
                pd.supplier_id, 
                pd.brand_id, 
                pd.color, 
                pd.publication_year, 
                pd.author, 
                pd.publisher, 
                pd.origin, 
                pd.language
            FROM products p
            LEFT JOIN product_details pd ON p.id = pd.product_id
            WHERE p.id = :id
        ";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC); // Trả về dữ liệu sản phẩm kèm thông tin chi tiết
    }



    private function validateUpdateProductData($product_name, $catalog_id, $price, $discount_price, $stock, $product_image, $supplier_id, $publication_year, $currentImage = null)
    {
        $errors = [];

        // Kiểm tra tên sản phẩm
        if (empty($product_name)) {
            $errors['product_name'] = 'Tên sản phẩm không được để trống.';
        }

        // Kiểm tra danh mục
        if (empty($catalog_id)) {
            $errors['catalog_id'] = 'Vui lòng chọn danh mục.';
        }

        // Kiểm tra giá
        if (!is_numeric($price) || $price <= 0) {
            $errors['price'] = 'Giá sản phẩm phải là số lớn hơn 0.';
        }

        // Kiểm tra giảm giá
        if (!is_numeric($discount_price) || $discount_price < 0) {
            $errors['discount_price'] = 'Giảm giá phải lớn hơn 0.';
        }

        // Kiểm tra số lượng
        if (!is_numeric($stock) || $stock < 0) {
            $errors['stock'] = 'Số lượng sản phẩm phải là số không âm.';
        }

        //Kiểm tra nhà cung cấp
        if (empty($supplier_id)) {
            $errors['supplier_id'] = 'Vui lòng chọn nhà cung cấp.';
        }

        //Kiểm tra năm
        if (empty($publication_year)) {
            $errors['publication_year'] = 'Vui lòng nhập năm xuất bản hoặc năm sản xuất.';
        }

        // Kiểm tra hình ảnh
        if ($product_image && $product_image['error'] === UPLOAD_ERR_OK) {
            // Kiểm tra phần mở rộng của tệp
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            $fileExtension = strtolower(pathinfo($product_image['name'], PATHINFO_EXTENSION));
            if (!in_array($fileExtension, $allowedExtensions)) {
                $errors['product_image'] = 'Phần mở rộng tệp không hợp lệ. Chỉ hỗ trợ JPG, PNG, GIF.';
            }

            // Kiểm tra tên ảnh trong cơ sở dữ liệu nếu có ảnh mới
            $imageName = basename($product_image['name']);
            if ($this->checkImageExists($imageName, $currentImage)) {
                $errors['product_image'] = 'Tên ảnh đã tồn tại. Vui lòng chọn tên khác.';
            }
        }

        return $errors;
    }
    public function editProduct()
    {
        $errors = [];
        $catalogs = $this->getAllCatalogs();
        $suppliers = $this->getAllSuppliers();
        $brands = $this->getAllBrands();
        $encryptedId = $_GET['id'] ?? null;

        // Nếu không có ID, dừng xử lý
        if (!$encryptedId) {
            die("ID không hợp lệ.");
        }

        // Giải mã ID
        $id = Encrypt::decryptId($encryptedId, KEY);

        // Kiểm tra xem ID có hợp lệ không
        if (!$id) {
            die("ID không hợp lệ.");
        }

        // Lấy thông tin sản phẩm hiện tại
        $product = $this->getProductById($id);

        // Nếu là phương thức POST, xử lý dữ liệu form
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lấy dữ liệu từ form
            $product_name = $_POST['product_name'] ?? '';
            $description = $_POST['description'] ?? null;
            $catalog_id = $_POST['catalog_id'] ?? null;
            $price = $_POST['price'] ?? '';
            $discount_price = $_POST['discount_price'] ?? '';
            $stock = $_POST['stock'] ?? '';
            $product_image = $_FILES['product_image'] ?? null; // File upload

            $brand_id = !empty($_POST['brand_id']) ? $_POST['brand_id'] : null;
            $supplier_id = !empty($_POST['supplier_id']) ? $_POST['supplier_id'] : null;

            $color = $_POST['color'] ?? null;
            $author = $_POST['author'] ?? null;
            $publication_year = $_POST['publication_year'] ?? null;
            $publisher = $_POST['publisher'] ?? null;
            $origin = $_POST['origin'] ?? null;
            $language = $_POST['language'] ?? null;

            // Kiểm tra dữ liệu nhập vào
            $errors = $this->validateUpdateProductData($product_name, $catalog_id, $price, $discount_price, $stock, $product_image, $supplier_id, $publication_year);

            // Nếu không có lỗi, xử lý cập nhật sản phẩm
            if (empty($errors)) {
                $this->updateProduct($id, $product_name, $description, $catalog_id, $price, $discount_price, $stock, $product_image, $supplier_id, $brand_id, $color, $publication_year, $author, $publisher, $origin, $language);
                header('Location: ' . BASE_URL . '/admin/products');
                exit();
            }
        }

        // Nếu có lỗi hoặc là phương thức GET, hiển thị thông tin sản phẩm trong form
        $product = $this->getProductById($id);
        include_once VIEW_PATH . 'admin/products/edit.php';
    }

    public function updateProduct($id, $product_name, $description, $catalog_id, $price, $discount_price, $stock, $product_image, $supplier_id, $brand_id, $color, $publication_year, $author, $publisher, $origin, $language)
    {
        // Lấy thông tin sản phẩm hiện tại
        $product = $this->getProductById($id);
        if (!$product) {
            die('Không tìm thấy sản phẩm với ID: ' . $id);
        }

        $currentImagePath = $product['product_image'] ?? null;

        // Xử lý upload ảnh mới (nếu có)
        if ($product_image && $product_image['error'] === UPLOAD_ERR_OK) {
            // Nếu là ảnh Cloudinary thì xóa
            if (strpos($currentImagePath, 'res.cloudinary.com') !== false) {
                $publicId = UploadClound::getPublicIdFromUrl($currentImagePath);
                UploadClound::delete($publicId);
            }

            // Upload ảnh mới
            $filePath = time() . '_' . hash('sha1', pathinfo($product_image['name'], PATHINFO_FILENAME));
            $secureUrl = UploadClound::upload($product_image['tmp_name'], 'product_images', $filePath);
            $imagePath = $secureUrl;
        } else {
            $imagePath = $currentImagePath;
        }


        try {
            // Bắt đầu transaction để đảm bảo cả hai bảng cập nhật thành công
            $this->db->beginTransaction();

            // Cập nhật bảng `products`
            $query = "
                UPDATE products 
                SET product_name = :product_name, description = :description, catalog_id = :catalog_id, 
                    price = :price, discount_price = :discount_price, stock = :stock, product_image = :product_image 
                WHERE id = :id
            ";

            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':product_name', $product_name, \PDO::PARAM_STR);
            $stmt->bindParam(':description', $description, \PDO::PARAM_STR);
            $stmt->bindParam(':catalog_id', $catalog_id, \PDO::PARAM_INT);
            $stmt->bindParam(':price', $price, \PDO::PARAM_STR);
            $stmt->bindParam(':discount_price', $discount_price, \PDO::PARAM_INT);
            $stmt->bindParam(':stock', $stock, \PDO::PARAM_INT);
            $stmt->bindParam(':product_image', $imagePath, \PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
            $stmt->execute();

            // Cập nhật bảng `product_details`
            $detailQuery = "
                UPDATE product_details 
                SET supplier_id = :supplier_id, brand_id = :brand_id, color = :color, 
                    publication_year = :publication_year, author = :author, publisher = :publisher, 
                    origin = :origin, language = :language
                WHERE product_id = :id
            ";

            $detailStmt = $this->db->prepare($detailQuery);
            $detailStmt->bindParam(':id', $id, \PDO::PARAM_INT);
            $detailStmt->bindValue(':supplier_id', $supplier_id, \PDO::PARAM_INT);
            $detailStmt->bindValue(':brand_id', !empty($brand_id) ? $brand_id : null, $brand_id !== null ? \PDO::PARAM_INT : \PDO::PARAM_NULL);
            $detailStmt->bindValue(':color', !empty($color) ? $color : null, $color !== null ? \PDO::PARAM_STR : \PDO::PARAM_NULL);
            $detailStmt->bindParam(':publication_year', $publication_year, \PDO::PARAM_STR);
            $detailStmt->bindParam(':author', $author, \PDO::PARAM_STR);
            $detailStmt->bindParam(':publisher', $publisher, \PDO::PARAM_STR);
            $detailStmt->bindParam(':origin', $origin, \PDO::PARAM_STR);
            $detailStmt->bindParam(':language', $language, \PDO::PARAM_STR);
            $detailStmt->execute();

            // Commit transaction
            $this->db->commit();

            Session::set('message', ['success' => 'Cập nhật sản phẩm thành công!']);
            header('Location: ' . BASE_URL . '/admin/products');
            exit();
        } catch (\Exception $e) {
            $this->db->rollBack();
            die('Lỗi khi cập nhật sản phẩm: ' . $e->getMessage());
        }
    }
}
