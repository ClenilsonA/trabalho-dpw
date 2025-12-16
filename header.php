<?php
// Inicia a sessão para gestão de utilizadores (Login/Logout)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// NOTA: A ligação à BD ('db_config.php') não é necessária aqui.
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Bookify</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'sidebar-bg': '#1E1E1E',
                        'main-bg': '#2C2C2C',
                        'custom-light': '#F5E9DA', 
                        'custom-green': '#09C358', 
                    }
                }
            }
        }
    </script>

    <style>
        /* TODOS OS ESTILOS CSS VÃO AQUI */
        body {
            background-color: #2C2C2C;
        }

        .scroll-hide-native {
            -ms-overflow-style: none;
            scrollbar-width: none;
            overflow-x: hidden !important;
        }
        
        .scroll-arrow {
            background-color: rgba(0, 0, 0, 0.6);
            color: #F5E9DA; 
            border: none;
            padding: 3px 6px;
            font-size: 1.1rem;
            cursor: pointer;
            transition: background-color 0.2s;
            border-radius: 5px; 
            line-height: 1;
            height: 30px;
        }
        
        .scroll-arrow:hover {
            background-color: rgba(0, 0, 0, 0.9);
        }
        
        @media (max-width: 576px) {
            .scroll-arrow {
                display: none;
            }
        }
    </style>
</head>
<body>

    <nav class="flex items-center justify-between bg-sidebar-bg px-4 py-2 text-custom-light">
        <div class="flex items-center">
            <a href="index.php" class="flex items-center text-custom-light no-underline">
                <img 
                    src="assets/images/bookifylogo.png"
                    alt="Bookify Logo" 
                    class="h-14 w-auto mr-2" 
                />
                <span class="text-2xl font-bold">Bookify</span>
            </a>
        </div>

        <form action="search.php" method="GET" class="hidden md:flex flex-grow justify-center px-8">
            <input 
                type="search" 
                name="q" 
                placeholder="Search books, authors, genres..."
                required
                class="w-full max-w-xl p-2 rounded-l-md bg-gray-700 text-custom-light placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-custom-green"
            />
            <button type="submit" class="p-2 bg-custom-green text-black rounded-r-md hover:bg-opacity-80 transition">
                🔍
            </button>
        </form>
        <div class="ml-auto md:ml-0">
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="my-list.php" class="flex items-center text-sm font-medium hover:text-custom-green transition">
                    <img src="assets/images/Ellipse 1.png" alt="User Avatar" class="rounded-full w-11 h-11 mr-2" />
                    Olá, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!
                </a>
            <?php else: ?>
                <a href="login.php" class="block rounded-full w-11 h-11 transition hover:opacity-80">
                    <img src="assets/images/Ellipse 1.png" alt="Log In" class="rounded-full w-11 h-11" />
                </a>
            <?php endif; ?>
        </div>
    </nav>

    <div class="w-full h-[2px] bg-custom-green"></div>
    
    <div class="grid grid-cols-[auto_1fr] min-h-screen">