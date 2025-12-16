<?php
require_once 'db_config.php'; 

// Query para obter categorias únicas e não repetidas
$sql_categories = "SELECT DISTINCT categoria FROM livros ORDER BY categoria ASC";
$result_categories = $conn->query($sql_categories);

include 'header.php'; 
?>
    
<?php 
include 'sidebar.php'; 
?>

    <main class="px-4 py-4 md:py-6 bg-main-bg text-custom-light">
        
        <h1 class="text-3xl font-bold mb-8 border-b border-gray-700 pb-2">Explore All Categories</h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            
            <?php
            if ($result_categories && $result_categories->num_rows > 0) {
                while($row = $result_categories->fetch_assoc()) {
                    $category_name = htmlspecialchars($row['categoria']);
                    
                    // O link aponta para a nova página de filtro: category-list.php
                    $category_link = "category-list.php?genre=" . urlencode($category_name);
            ?>
                    <a href="<?php echo $category_link; ?>" class="bg-sidebar-bg p-6 rounded-lg shadow-md hover:bg-gray-700 transition duration-200 block">
                        <h2 class="text-xl font-semibold mb-2"><?php echo $category_name; ?></h2>
                        <p class="text-gray-400">View all books in the <?php echo $category_name; ?> genre.</p>
                        <span class="text-custom-green mt-2 block font-medium">Click to see books &rarr;</span>
                    </a>
            <?php
                }
                $result_categories->free();
            } else {
                echo '<p class="text-gray-400">Não foram encontradas categorias na base de dados.</p>';
            }
            $conn->close();
            ?>
            
        </div>
        
    </main>
    
<?php 
include 'footer.php'; 
?>