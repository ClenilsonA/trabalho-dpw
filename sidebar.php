<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<aside class="hidden md:block w-64 flex-shrink-0 bg-sidebar-bg text-custom-light border-r border-gray-800 sticky top-[66px] h-[calc(100vh-66px)] overflow-y-auto z-40">
    <div class="flex flex-col p-6 h-full">
        <ul class="flex flex-col space-y-2 w-full">
            <li>
                <a href="index.php" class="block p-2 text-custom-light font-bold hover:text-custom-green transition w-full">Home</a>
            </li>
            <?php if (isset($_SESSION['user_id'])): ?>
                <li>
                    <a href="my-list.php" class="block p-2 text-custom-light rounded hover:bg-gray-800 transition">My List</a>
                </li>
            <?php endif; ?>
            <li>
                <a href="popular.php" class="block p-2 text-custom-light rounded hover:bg-gray-800 transition">Popular</a>
            </li>
            <li>
                <a href="categories.php" class="block p-2 text-custom-light rounded hover:bg-gray-800 transition">Categories</a>
            </li>
            <li class="pt-2">
                <a href="premium.php" class="block px-4 py-2 bg-yellow-500 text-black font-bold rounded-lg hover:bg-yellow-600 transition shadow-lg text-center uppercase text-xs tracking-wider">Premium</a>
            </li>
            
            <?php if (isset($_SESSION['user_email']) && $_SESSION['user_email'] === 'admin@bookify.com'): ?>
                <li class="mt-8 pt-6 border-t border-gray-800 w-full">
                    <p class="text-[10px] text-gray-500 font-black uppercase tracking-[0.2em] mb-3 px-2">Management</p>
                    <a href="admin.php" class="block p-3 text-custom-green font-black border border-custom-green/30 rounded-xl bg-custom-green/5 hover:bg-custom-green hover:text-black transition-all duration-300 text-center">⚙️ ADMIN</a>
                </li>
            <?php endif; ?>
        </ul>

        <div class="mt-auto pt-6">
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="logout.php" class="block p-2 text-red-400 font-bold text-sm rounded hover:bg-red-500/10 transition">Logout</a>
            <?php else: ?>
                <a href="login.php" class="block p-2 text-custom-green font-bold text-sm rounded hover:bg-custom-green/10 transition">Login</a>
            <?php endif; ?>
        </div>
    </div>
</aside>