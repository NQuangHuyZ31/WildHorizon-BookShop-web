<?php
include_once VIEW_PATH_USER_LAYOUT.'header.php';
?>
<div class="container-fuild mx-auto">
  <div class="px-2 py-3 whr-feedback">
    <div class="flex items-center">
      <div class="flex items-center mr-5">
        <img src="./Public/images/icon.jpg" alt="logo" style="width: 35px;height: 35px;">
        <p class="ms-3 text-blue-900">Wildhorizon BookShop</p>
      </div>
      <span class="whr-feedback-header-title-dash font-bold"></span>
      <p class="ms-1 text-gray-600 font-bold">Feedback</p>
    </div>
    <div class="mt-5">
      <form action="<?php echo BASE_URL.'/feedback' ?>" method="post" enctype="multipart/form-data">
        <div class="mb-5">
          <p class="after:content-['*'] after:ml-0.5 after:text-red-500 text-md mb-2">Your suggestion matters. What can we improve on?</p>
          <div class="w-full rounded-md border border-gray-400 whr-feedback-textarea">
            <div class="px-3 py-3">
              <div class="w-full h-full">
                <textarea maxlength="1000" placeholder="Your suggestion matters." rows="6" class="whr-feedback-textarea-content w-full border-none outline-none text-sm bg-transparent resize-none" name="feedback" id="feedback-content" style="height: 119px;"></textarea>
              </div>
              <span class="flex justify-end text-sm text-gray-300" id="feedback-count">0/1000</span>
            </div>
          </div>
          <div class="mt-4">
            <p class="text-md text-gray-500 mb-2">Upload images to help us understand more.</p>
            <div class="flex">
              <div class="border-2 border-dashed border-gray-200 hover:border-blue-200" style="width: 346px; height: 138px;">
                <label for="feedback-input" class="feedback-upload w-full h-full p-3 cursor-pointer flex flex-col items-center justify-center">
                  <input type="file" name="feedback-img" id="feedback-input" accept="image/jpg, image/jpeg, image/png, image/gif" class="hidden">
                  <i class="fa-solid fa-upload text-gray-500 mb-3" style="font-size: 30px;"></i>
                  <p class="text-sm text-gray-500 mb-3">Click to upload multiple images here</p>
                  <p class="text-sm text-gray-300">Supported types: JPG, PNG, and GIF.</p>
                </label>
              </div>
            </div>
            <div class="mt-5">
              <button type="submit" id="btn-feedback" class="bg-orange-400 text-white p-2 rounded-sm pointer-events-none opacity-25 font-bold" style="width: 204px;">Submit</button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<?php
include_once VIEW_PATH_USER_LAYOUT .'footer.php';
?>