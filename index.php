<?php 
// 1. INCLUIR A CONFIGURAÇÃO DA BASE DE DADOS
require_once 'db_config.php'; 

include 'header.php'; 

// Buscar categorias para o loop por género
$sql_genres = "SELECT id, name FROM categorias ORDER BY name ASC";
$result_genres = $conn->query($sql_genres);
?>

<div class="flex w-full">

    <?php include 'sidebar.php'; ?>

    <main class="flex-1 min-w-0 px-4 py-4 md:py-6 bg-main-bg text-custom-light overflow-x-hidden min-h-screen relative z-0">
        
        <section class="mb-14">
            <div class="flex justify-between items-end mb-6">
                <div>
                    <h2 class="text-3xl font-black text-custom-green italic tracking-tighter uppercase leading-none">Popular Picks</h2>
                    <div class="h-1 w-12 bg-custom-green mt-2 rounded-full"></div>
                </div>
                <a href="popular.php" class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-500 hover:text-custom-green transition-colors flex items-center gap-2 group">
                    See All 
                    <span class="group-hover:translate-x-1 transition-transform">→</span>
                </a>
            </div>

            <div class="relative">
                <div class="flex overflow-x-auto scroll-hide-native pb-4 space-x-6">
                    <?php
                    $sql_popular = "SELECT id, title, cover_url FROM livros WHERE is_popular = 1 ORDER BY RAND() LIMIT 10";
                    $result_popular = $conn->query($sql_popular);

                    if ($result_popular && $result_popular->num_rows > 0) {
                        while($row = $result_popular->fetch_assoc()) {
                    ?>
                            <a href="book-details.php?id=<?php echo $row['id']; ?>" class="text-center flex-shrink-0 w-44 hover:scale-105 transition-transform duration-300 group">
                                <div class="relative overflow-hidden rounded-xl shadow-2xl mb-3 border border-gray-800 group-hover:border-custom-green transition-colors">
                                    <img src="<?php echo htmlspecialchars($row['cover_url']); ?>" alt="..." class="w-full h-64 object-cover" />
                                </div>
                                <p class="text-sm font-bold truncate px-1 group-hover:text-custom-green transition-colors"><?php echo htmlspecialchars($row['title']); ?></p>
                            </a>
                    <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </section>

        <section class="bg-custom-green text-custom-light p-8 rounded-2xl my-12 flex flex-col md:flex-row items-center justify-between shadow-2xl relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16 blur-2xl"></div>
            <div class="order-2 md:order-1 relative z-10 text-center md:text-left">
                <h1 class="text-5xl font-black uppercase tracking-tighter leading-none">The Best of</h1>
                <h1 class="text-5xl font-black uppercase tracking-tighter text-black/80 mb-2">Literature</h1>
                <p class="mt-4 mb-6 max-w-sm text-lg font-medium leading-tight text-black/70">Explore our curated selection of top-rated books organized by your favorite genres.</p>
                <a href="popular.php" class="inline-block px-10 py-4 bg-black text-white font-black rounded-full hover:scale-105 transition-all shadow-lg uppercase text-sm tracking-widest">Discover Now</a>
            </div> 
            <div class="mt-4 md:mt-0 order-1 md:order-2 relative z-10">
                <img src="assets/images/alice-removebg-preview 1.png" alt="..." class="max-h-80 drop-shadow-2xl group-hover:rotate-3 transition-transform duration-500" /> 
            </div>
        </section>

        <?php 
        if ($result_genres && $result_genres->num_rows > 0): 
            while ($genre = $result_genres->fetch_assoc()):
                $genre_id = $genre['id'];
                $genre_name = $genre['name'];
                
                // URL IGUAL À DA TUA PÁGINA CATEGORIES
                $list_url = "category-list.php?id=" . $genre_id;

                $sql_books = "SELECT id, title, cover_url FROM livros WHERE category_id = $genre_id LIMIT 12";
                $result_books = $conn->query($sql_books);

                if ($result_books && $result_books->num_rows > 0):
        ?>
                <section class="mb-14">
                    <div class="flex justify-between items-end mb-6">
                        <a href="<?php echo $list_url; ?>" class="group">
                            <h2 class="text-2xl font-black text-white tracking-tighter uppercase leading-none group-hover:text-custom-green transition-colors">
                                <?php echo htmlspecialchars($genre_name); ?>
                            </h2>
                            <div class="h-1 w-8 bg-custom-green mt-2 rounded-full group-hover:w-full transition-all duration-300"></div>
                        </a>
                        
                        <a href="<?php echo $list_url; ?>" class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-500 hover:text-custom-green transition-colors flex items-center gap-2 group">
                            See All
                            <span class="group-hover:translate-x-1 transition-transform">→</span>
                        </a>
                    </div>

                    <div class="relative">
                        <div class="flex overflow-x-auto scroll-hide-native pb-4 space-x-6">
                            <?php while ($book = $result_books->fetch_assoc()): ?>
                                <a href="book-details.php?id=<?php echo $book['id']; ?>" class="text-center flex-shrink-0 w-44 hover:scale-105 transition-transform duration-300 group">
                                    <div class="relative overflow-hidden rounded-xl shadow-xl mb-3 border border-gray-800 group-hover:border-custom-green transition-colors">
                                        <img src="<?php echo htmlspecialchars($book['cover_url']); ?>" alt="..." class="w-full h-64 object-cover" />
                                    </div>
                                    <p class="text-sm font-bold truncate px-1 group-hover:text-custom-green transition-colors"><?php echo htmlspecialchars($book['title']); ?></p>
                                </a>
                            <?php endwhile; ?>
                        </div>
                    </div>
                </section>
        <?php 
                endif; 
            endwhile; 
        endif; 
        ?>

    </main> 
</div> 

<?php 
$conn->close();
include 'footer.php'; 
?>