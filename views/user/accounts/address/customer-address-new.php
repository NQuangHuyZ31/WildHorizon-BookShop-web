<div>
  <p class="text-lg font-bold text-slate-500">Thêm địa chỉ mới</p>
  <input type="hidden" name="csrf_token" value="<?php echo $csrf_token ?>">
  <div class="pb-4 border-b border-slate-200">
    <div class="w-full flex items-center py-3">
      <div class="profile-label text-gray-500 after:content-['*'] after:ml-0.5 after:text-red-500 py-1 text-[11px] xl:text-[13px]">Họ tên</div>
      <input type="text" name="username" id="username" value="<?php echo $customer['username'] ?>" class="w-2/3 px-3 py-2 bg-white border shadow-sm border-slate-300 placeholder-slate-400 focus:outline-none focus:border-sky-500 focus:ring-sky-500 block rounded-md text-[12px] focus:ring-1 xl:text-[14px]" placeholder="ví dụ: Nguyễn Văn A">
    </div>
    <div class="w-full flex items-center py-3">
      <div class="profile-label text-gray-500 after:content-['*'] after:ml-0.5 after:text-red-500 py-1 text-[11px] xl:text-[13px]">Số điện thoại</div>
      <input type="text" name="phone" id="phone" value="<?php echo $customer['phone'] ?>" class="w-2/3 px-3 py-2 bg-white border shadow-sm border-slate-300 placeholder-slate-400 focus:outline-none focus:border-sky-500 focus:ring-sky-500 block rounded-md text-[12px] focus:ring-1 xl:text-[14px]" placeholder="ví dụ: 0366465273">
    </div>
    <div class="w-full flex items-center py-3">
      <div class="profile-label text-gray-500 after:content-['*'] after:ml-0.5 after:text-red-500 py-1 text-[11px] xl:text-[13px]">Tỉnh/Thành phố</div>
      <select
        name="province"
        id="province"
        class="w-2/3 px-3 py-2 bg-white border shadow-sm border-slate-300 placeholder-slate-400 focus:outline-none focus:border-sky-500 focus:ring-sky-500 block rounded-md text-[12px] focus:ring-1 xl:text-[14px]">
        <option value="">Chọn tỉnh/thành phố</option>
      </select>
    </div>
    <div class="w-full flex items-center py-3">
      <div class="profile-label text-gray-500 after:content-['*'] after:ml-0.5 after:text-red-500 py-1 text-[11px] xl:text-[13px]">Quận/huyện</div>
      <select name="district" id="district" class="w-2/3 px-3 py-2 bg-white border shadow-sm border-slate-300 placeholder-slate-400 focus:outline-none focus:border-sky-500 focus:ring-sky-500 block rounded-md text-[12px] focus:ring-1 xl:text-[14px]">
        <option value="">Chọn quận/huyện</option>
      </select>
    </div>
    <div class="w-full flex items-center py-3">
      <div class="profile-label text-gray-500 after:content-['*'] after:ml-0.5 after:text-red-500 py-1 text-[11px] xl:text-[13px]">Phường/xã</div>
      <select name="ward" id="ward" class="w-2/3 px-3 py-2 bg-white border shadow-sm border-slate-300 placeholder-slate-400 focus:outline-none focus:border-sky-500 focus:ring-sky-500 block rounded-md text-[12px] focus:ring-1 xl:text-[14px]">
        <option value="">Chọn phường/xã</option>
      </select>
    </div>
    <div class="w-full flex items-center py-3">
      <div class="profile-label text-gray-500 after:content-['*'] after:ml-0.5 after:text-red-500 py-1 text-[11px] xl:text-[13px]">Địa chỉ</div>
      <input type="text" name="address" id="address" value="" class="w-2/3 px-3 py-2 bg-white border shadow-sm border-slate-300 placeholder-slate-400 focus:outline-none focus:border-sky-500 focus:ring-sky-500 block rounded-md text-[12px] focus:ring-1 xl:text-[14px]" placeholder="ví dụ: 123 nguyễn văn bảo">
    </div>
  </div>
</div>