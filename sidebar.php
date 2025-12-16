<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<aside class="w-auto flex-shrink-0 bg-sidebar-bg text-custom-light px-6 py-2">
    <div class="flex flex-col items-center sm:items-start pt-2">
        
        <ul class="flex flex-col space-y-2 mb-auto items-center sm:items-start">
            
            <li><a href="index.php" class="block p-2 text-custom-light font-bold bg-gray-700 rounded">Home</a></li>
            
            <?php if (isset($_SESSION['user_id'])): ?>
                <li><a href="my-list.php" class="block p-2 text-custom-light rounded hover:bg-gray-800 transition duration-150">My List</a></li>
            <?php endif; ?>
            
            <li><a href="popular.php" class="block p-2 text-custom-light rounded hover:bg-gray-800 transition duration-150">Popular</a></li>
            
            <li><a href="categories.php" class="block p-2 text-custom-light rounded hover:bg-gray-800 transition duration-150">Categories</a></li>
            
            <li><a href="#" class="mt-3 inline-block px-4 py-2 bg-yellow-500 text-black font-semibold rounded hover:bg-yellow-600">Premium</a></li>
            
            <?php if (isset($_SESSION['user_id'])): ?>
                <li class="mt-4"><a href="logout.php" class="block p-2 text-red-400 rounded hover:bg-gray-800 transition duration-150">Logout</a></li>
            <?php else: ?>
                <li class="mt-4"><a href="login.php" class="block p-2 text-custom-light rounded hover:bg-gray-800 transition duration-150">Login</a></li>
            <?php endif; ?>
            
        </ul>
    </div>
</aside>