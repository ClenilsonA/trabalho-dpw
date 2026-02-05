<?php 
require_once 'db_config.php'; 
include 'header.php'; // Camada 1: Topo Fixo

// Buscar todas as categorias para criar os "quadrados" (cards)
$sql_categories = "SELECT id, name FROM categorias ORDER BY name ASC";
$result_categories = $conn->query($sql_categories);
?>

<div class="flex w-full"> 
    
    <?php include 'sidebar.php'; ?> 

    <main class="flex-1 min-w-0 px-4 py-4 md:py-8 bg-main-bg text-custom-light min-h-screen relative z-0">
        
        <header class="mb-12">
            <h1 class="text-4xl font-black text-custom-green italic tracking-tighter uppercase">
                Categories
            </h1>
            <p class="text-gray-400 mt-2 font-medium">Select a genre to explore books.</p>
            <div class="w-20 h-1 bg-custom-green mt-4"></div>
        </header>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
            
            <?php 
            if ($result_categories && $result_categories->num_rows > 0):
                while($cat = $result_categories->fetch_assoc()):
                    // URL que leva para a lista de livros dessa categoria específica
                    $list_url = "category-list.php?id=" . $cat['id'];
            ?>
                <a href="<?php echo $list_url; ?>" class="group relative aspect-square bg-gray-800 rounded-2xl flex items-center justify-center overflow-hidden border border-gray-700 hover:border-custom-green transition-all duration-300 shadow-xl">
                    
                    <div class="absolute inset-0 bg-gradient-to-br from-custom-green/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    
                    <div class="relative z-10 text-center p-4">
                        <h3 class="text-lg md:text-xl font-bold uppercase tracking-widest group-hover:scale-110 transition-transform duration-300">
                            <?php echo htmlspecialchars($cat['name']); ?>
                        </h3>
                        <div class="mt-2 w-8 h-1 bg-custom-green mx-auto transform scale-x-0 group-hover:scale-x-100 transition-transform"></div>
                    </div>

                    <div class="absolute -bottom-2 -right-2 text-6xl text-white/5 font-black italic group-hover:text-custom-green/10 transition-colors">
                        <?php echo substr($cat['name'], 0, 1); ?>
                    </div>
                </a>
            <?php 
                endwhile; 
            else: 
            ?>
                <p class="col-span-full text-center text-gray-500 italic">No categories found.</p>
            <?php endif; ?>

        </div>

    </main>
</div>

<?php 
$conn->close();
include 'footer.php'; 
?>