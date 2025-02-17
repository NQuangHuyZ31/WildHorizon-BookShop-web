<?php

use Core\Session;

?>

<?php include VIEW_PATH . 'admin/layout/layout.php'; ?>
<title>Admin Login</title>

<div class="bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 flex items-center justify-center min-h-screen">

    <!-- Container for the login form -->
    <div class="bg-white p-8 rounded-xl shadow-xl w-96 max-w-md">
        <h2 class="text-3xl font-semibold text-center text-gray-800 mb-6">Admin Login</h2>
        
        <!-- Form for login -->
        <form id="loginForm" method="POST" action="<?= BASE_URL_NAME ?>/admin/login" class="space-y-6">
            
            <!-- Email input -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-600">Email</label>
                <input type="email" id="email" name="email" required class="mt-2 px-4 py-3 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent shadow-sm placeholder-gray-400" placeholder="Enter your email">
            </div>

            <!-- Password input -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-600">Password</label>
                <input type="password" id="password" name="password" required class="mt-2 px-4 py-3 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent shadow-sm placeholder-gray-400" placeholder="Enter your password">
            </div>

            <!-- Submit button -->
            <button type="submit" class="w-full bg-indigo-600 text-white py-3 rounded-lg mt-4 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50 transition duration-300">Login</button>
        </form>

        <!-- Forgot password link -->
        <div class="mt-4 text-center">
            <a href="#" class="text-sm text-indigo-600 hover:text-indigo-800">Forgot your password?</a>
        </div>

    </div>

    <script src="<?= BASE_URL_NAME ?>/Public/js/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        var messge = <?php echo json_encode(Session::get('message')); ?>;
        console.log(messge);
        if(messge.error){
            toastr.error(messge.error);
        }
    </script>

    <?php Session::delete('message'); ?>
</div>

