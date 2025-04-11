<?php include_once VIEW_PATH_USER_LAYOUT . 'header.php'; ?>
<div class="container-fuild mx-auto">
  <div class="w-full mt-3 mb-3">
    <div class="flex w-full">
      <?php include_once VIEW_PATH_USER_LAYOUT . 'sidebar-customer.php' ?>
      <div class="flex-1 ms-3">
        <div class="customer-address-content w-full bg-white rounded-md shadow-md pb-4 px-4">
          <div class="p-4">
            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token ?>">
            <?php require_once VIEW_PATH . 'user/accounts/customer-address-new.php' ?>
            <div class="mt-2">
              <div class="flex items-center">
                <input type="checkbox" value="1" name="default_address">
                <div class="ms-2 text-sm text-gray-400">Đặt làm địa chỉ mặt định</div>
              </div>
              <div class="flex justify-end mt-3 text-center">
                <button type="button" id="btn-save-address" class="px-14 py-2 text-white bg-red-700 rounded-lg font-semibold">Lưu địa chỉ</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include_once VIEW_PATH_USER_LAYOUT . 'footer.php'; ?>