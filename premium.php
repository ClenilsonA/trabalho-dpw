<?php
// premium.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'db_config.php';
include 'header.php';
?>

<div class="flex w-full">
    
    <?php include 'sidebar.php'; ?>

    <main class="flex-1 min-w-0 bg-main-bg text-custom-light min-h-screen relative z-0 flex items-center justify-center p-6">
        
        <div class="max-w-2xl w-full text-center">
            
            <div class="inline-flex items-center justify-center w-24 h-24 mb-8 rounded-full bg-gradient-to-tr from-yellow-600 to-yellow-300 shadow-[0_0_50px_rgba(234,179,8,0.3)] animate-pulse">
                <svg class="w-12 h-12 text-black" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M5 16L3 5L8.5 10L12 4L15.5 10L21 5L19 16H5M19 19C19 19.6 18.6 20 18 20H6C5.4 20 5 19.6 5 19V18H19V19Z" />
                </svg>
            </div>

            <h1 class="text-5xl md:text-6xl font-black text-white mb-4 tracking-tighter italic uppercase">
                Premium <span class="text-yellow-500">Access</span>
            </h1>
            
            <div class="h-1 w-32 bg-yellow-500 mx-auto mb-8 rounded-full"></div>

            <h2 class="text-2xl font-bold text-gray-200 mb-6">Coming Soon to Bookify</h2>
            
            <p class="text-gray-400 text-lg leading-relaxed mb-10 max-w-lg mx-auto">
                We are currently crafting an exclusive experience for our most passionate readers. 
                Unlimited access, offline reading, and early releases are just around the corner.
            </p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-10 opacity-50">
                <div class="p-4 bg-sidebar-bg rounded-xl border border-gray-800">
                    <p class="text-xs font-black uppercase text-yellow-500 tracking-widest mb-2">Unlimited</p>
                    <p class="text-sm font-medium">Read every book without limits.</p>
                </div>
                <div class="p-4 bg-sidebar-bg rounded-xl border border-gray-800">
                    <p class="text-xs font-black uppercase text-yellow-500 tracking-widest mb-2">Offline</p>
                    <p class="text-sm font-medium">Download to your device.</p>
                </div>
                <div class="p-4 bg-sidebar-bg rounded-xl border border-gray-800">
                    <p class="text-xs font-black uppercase text-yellow-500 tracking-widest mb-2">No Ads</p>
                    <p class="text-sm font-medium">Clean and focused reading.</p>
                </div>
            </div>

            <a href="index.php" class="inline-block px-10 py-4 bg-white text-black font-black rounded-xl hover:bg-yellow-500 transition-all duration-300 uppercase tracking-widest text-sm shadow-xl">
                Go back to free library
            </a>

        </div>

    </main>
</div>

<?php include 'footer.php'; ?>