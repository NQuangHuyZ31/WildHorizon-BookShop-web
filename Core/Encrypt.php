<?php
namespace Core;
class Encrypt
{
    // Thuật toán mã hóa được sử dụng (AES-128-CBC)
    private static $cipher = "aes-128-cbc";

    // Tùy chọn cho mã hóa/decrypt (0 là không bổ sung padding đặc biệt)
    private static $options = 0;

    // Biến lưu chiều dài của IV (Initialization Vector)
    private static $ivLength;

    // Phương thức riêng tư tạo ra khóa (key) và vector khởi tạo (IV) dựa trên secretKey
    private static function getKeyAndIv($secretKey)
    {
        // Lấy chiều dài IV từ thuật toán mã hóa được chọn
        self::$ivLength = openssl_cipher_iv_length(self::$cipher);
        
        // Tạo IV bằng cách hash secretKey với SHA256, sau đó cắt chuỗi để phù hợp với chiều dài IV
        $iv = substr(hash('sha256', $secretKey), 0, self::$ivLength);

        // Trả về mảng chứa khóa bí mật và IV
        return [$secretKey, $iv];
    }

    // Phương thức công khai mã hóa ID (encrypt)
    public static function encryptId($id, $secretKey)
    {
        // Lấy key và IV từ phương thức getKeyAndIv
        list($key, $iv) = self::getKeyAndIv($secretKey);

        // Mã hóa ID bằng openssl_encrypt với AES-128-CBC
        $encrypted = openssl_encrypt($id, self::$cipher, $key, self::$options, $iv);

        // Nếu mã hóa thất bại, ném ra ngoại lệ
        if ($encrypted === false) {
            throw new \Exception("Error during encryption");
        }

        // Mã hóa chuỗi đã mã hóa sang Base64 để dễ dàng xử lý
        $base64Encoded = base64_encode($encrypted);

        // Thay thế các ký tự không an toàn cho URL:
        // '+' chuyển thành '-', '/' chuyển thành '_', '=' bị xóa
        $urlSafeEncrypted = str_replace(['+', '/', '='], ['-', '_', ''], $base64Encoded);

        // Trả về chuỗi mã hóa đã an toàn với URL
        return $urlSafeEncrypted;
    }

    // Phương thức công khai giải mã ID (decrypt)
    public static function decryptId($encryptedId, $secretKey)
    {
        // Lấy key và IV từ phương thức getKeyAndIv
        list($key, $iv) = self::getKeyAndIv($secretKey);

        // Khôi phục chuỗi Base64 từ chuỗi an toàn URL:
        // '-' chuyển về '+', '_' chuyển về '/'
        $base64Encoded = str_replace(['-', '_'], ['+', '/'], $encryptedId);

        // Decode Base64 để lấy chuỗi mã hóa ban đầu
        $decodedEncrypted = base64_decode($base64Encoded);

        // Giải mã chuỗi đã mã hóa bằng openssl_decrypt
        $decrypted = openssl_decrypt($decodedEncrypted, self::$cipher, $key, self::$options, $iv);

        // Nếu giải mã thất bại, ném ra ngoại lệ
        if ($decrypted === false) {
            throw new \Exception("Error during decryption");
        }

        // Trả về ID ban đầu sau khi giải mã
        return $decrypted;
    }
}

?>
