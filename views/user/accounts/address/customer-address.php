<?php include_once VIEW_PATH_USER_LAYOUT . 'header.php'; ?>

<div class="container-fuild mx-auto">
  <div class="w-full mt-3 mb-3">
    <div class="flex flex-col lg:mb-0 lg:flex-row w-full">
      <div class="lg:w-1/4">
        <?php include_once VIEW_PATH_USER_LAYOUT . 'sidebar-customer.php' ?>
      </div>
      <div class="flex-1 p-1 lg:ms-3">
        <div class="customer-address-content w-full bg-white rounded-md shadow-sm lg:shadow-md pb-4 px-4">
          <?php if ($customer_address != null) { ?>
            <div class="px-4 py-3">
              <div class="flex justify-between items-center">
                <p class="text-[14px] lg:text-lg font-bold text-slate-500">Sổ địa chỉ</p>
                <div class="text-sm text-sky-500 flex items-center cursor-pointer font-semibold">
                  <i class="fa-solid fa-plus"></i>
                  <p class="ms-2 text-[12px] lg:text-sm"><a href="<?php echo BASE_URL ?>/customer/address/add">Thêm địa chỉ mới</a></p>
                </div>
              </div>
            </div>
            <?php foreach ($customer_address as $address) { ?>
              <div class="mt-2 py-3 px-4 border-b border-slate-200">
                <div class="flex justify-between items-center">
                  <div class="flex items-start flex-col text-m font-semibold text-black tracking-wide lg:flex-row lg:items-center">
                    <div class="flex items-center">
                      <p><?php echo $address['username'] ?></p>
                      <div class="border-r-2 border-gray-200 mx-3" style="height: 18px;"></div>
                      <p><?php echo $address['phone'] != null ? $address['phone'] : 'Chưa có số điện thoại' ?></p>
                    </div>
                    <div class="<?php echo $address['default_address'] == 1 ? 'block' : 'hidden' ?> mt-2 lg:mt-0 lg:ms-4 bg-blue-100 p-1 rounded-sm">
                      <p class="font-normal text-blue-400 text-m">Địa chỉ giao hàng mặc định</p>
                    </div>
                  </div>
                  <div class="text-m text-sky-500 font-semibold flex items-center">
                    <a href="<?php echo BASE_URL ?>/customer/address/edit/<?php echo $address['id'] ?>">Sửa</a>
                    <?php if ($address['default_address'] == 0) { ?>
                      <div class="border-r-2 border-gray-200 mx-3" style="height: 18px;"></div>
                      <i class="fa-solid fa-trash-can cursor-pointer icon-delete-address hover:text-red-700" data-id="<?php echo $address['id'] ?>"></i>
                    <?php } ?>
                  </div>
                </div>
                <div class="text-[12px] lg:text-sm mt-1">
                  <p class="text-slate-500 py-0.5"><?php echo $address['address'] ?></p>
                  <p class="text-slate-500 py-0.5"><?php echo $address['ward'] . ', ' . $address['district'] . ', ' . $address['province'] ?></p>
                </div>
              </div>
            <?php } ?>
          <?php } else { ?>
            <div class="p-4">
              <?php require_once VIEW_PATH . 'user/accounts/address/customer-address-new.php' ?>
              <div class="mt-2">
                <div class="flex items-center">
                  <input type="checkbox" value="1" name="default_address">
                  <div class="ms-2 text-sm text-gray-400">Đặt làm địa chỉ mặt định</div>
                </div>
                <div class="flex justify-end mt-3 text-center">
                  <button type="button" id="btn-save-address" class="px-11 py-2 text-[12px] lg:text-[15px] text-white bg-red-700 rounded-lg font-semibold lg:px-14">Lưu địa chỉ</button>
                </div>
              </div>
            </div>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include_once VIEW_PATH_USER_LAYOUT . 'footer.php'; ?>