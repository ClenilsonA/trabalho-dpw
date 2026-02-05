<?php 
require_once 'db_config.php'; 
include 'header.php'; // Camada 1: Topo Fixo

// 1. Buscar apenas as categorias que POSSUEM livros populares
$sql_categories = "SELECT DISTINCT c.id, c.name 
                   FROM categorias c
                   INNER JOIN livros l ON c.id = l.category_id 
                   WHERE l.is_popular = 1 
                   ORDER BY c.name ASC";
$result_categories = $conn->query($sql_categories);
?>

<div class="flex w-full"> 
    
    <?php include 'sidebar.php'; ?> 

    <main class="flex-1 min-w-0 px-4 py-4 md:py-8 bg-main-bg text-custom-light min-h-screen relative z-0">
        
        <header class="mb-12">
            <h1 class="text-4xl font-black text-custom-green italic tracking-tighter uppercase">
                Popular by Genre
            </h1>
            <div class="w-20 h-1 bg-custom-green mt-2"></div>
        </header>

        <?php 
        if ($result_categories && $result_categories->num_rows > 0):
            while($cat = $result_categories->fetch_assoc()):
                $cat_id = $cat['id'];
                
                // 2. Buscar os livros populares DESTA categoria específica
                $sql_books = "SELECT id, title, cover_url, author 
                              FROM livros 
                              WHERE category_id = $cat_id AND is_popular = 1 
                              ORDER BY title ASC";
                $result_books = $conn->query($sql_books);
                
                if ($result_books && $result_books->num_rows > 0):
        ?>
                <section class="mb-16">
                    <h2 class="text-xl font-bold text-custom-light mb-6 flex items-center">
                        <span class="w-2 h-6 bg-custom-green mr-3 rounded-full"></span>
                        <?php echo htmlspecialchars($cat['name']); ?>
                    </h2>

                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-6">
                        
                        <?php while($book = $result_books->fetch_assoc()): 
                            $detail_url = "book-details.php?id=" . $book['id'];
                        ?>
                            <a href="<?php echo $detail_url; ?>" class="group">
                                <div class="relative aspect-[2/3] overflow-hidden rounded-lg border border-gray-800 group-hover:border-custom-green transition-all shadow-lg">
                                    <img 
                                        src="<?php echo htmlspecialchars($book['cover_url']); ?>" 
                                        alt="Capa" 
                                        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" 
                                    />
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-end p-3">
                                        <span class="text-[10px] font-bold text-custom-green uppercase tracking-widest">Ver detalhes</span>
                                    </div>
                                </div>
                                <h3 class="mt-3 text-sm font-bold truncate group-hover:text-custom-green transition-colors">
                                    <?php echo htmlspecialchars($book['title']); ?>
                                </h3>
                                <p class="text-[11px] text-gray-500 italic truncate">
                                    <?php echo htmlspecialchars($book['author'] ?? 'Unknown Author'); ?>
                                </p>
                            </a>
                        <?php endwhile; ?>

                    </div>
                </section>
        <?php 
                endif; // Fim do check de livros
            endwhile; 
        else: 
        ?>
            <div class="py-20 text-center border-2 border-dashed border-gray-800 rounded-3xl">
                <p class="text-gray-500 italic">No popular categories found.</p>
            </div>
        <?php endif; ?>

    </main>
</div>

<?php 
$conn->close();
include 'footer.php'; 
?>