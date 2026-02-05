<?php
require_once 'db_config.php'; 

include 'header.php'; 
include 'sidebar.php'; 
?>

<main class="px-4 py-4 md:py-6 bg-main-bg text-custom-light min-h-screen">
    
    <?php
    $search_term = "";
    $where_clause = "";
    $title_text = "Search Results";

    // 1. Verificar se o termo de pesquisa (q) foi passado
    if (isset($_GET['q']) && !empty($_GET['q'])) {
        $search_term = trim($_GET['q']);
        $safe_term = $conn->real_escape_string($search_term);
        $like_pattern = '%' . $safe_term . '%';

        $title_text = "Results for: \"{$search_term}\"";

        // CORREÇÃO: Usar 'title' e 'author' em vez de titulo/autor
        $where_clause = "WHERE title LIKE '{$like_pattern}' OR author LIKE '{$like_pattern}'";
    }

    // 2. Query Principal corrigida para os novos nomes de colunas
    $sql = "SELECT id, title, author, cover_url FROM livros {$where_clause} ORDER BY title ASC";
    $result = $conn->query($sql);
    ?>

    <header class="mb-10">
        <h1 class="text-3xl font-extrabold text-custom-green italic border-b border-gray-800 pb-4">
            <?php echo htmlspecialchars($title_text); ?>
        </h1>
    </header>

    <div class="flex flex-wrap gap-8 justify-center md:justify-start">
        
        <?php
        if ($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $detail_url = "book-details.php?id=" . $row['id'];
        ?>
                <a href="<?php echo $detail_url; ?>" class="group w-44 text-center transition-all">
                    <div class="relative overflow-hidden rounded-xl shadow-2xl mb-3 border border-gray-800 group-hover:border-custom-green transition-all">
                        <img 
                            src="<?php echo htmlspecialchars($row['cover_url']); ?>" 
                            alt="<?php echo htmlspecialchars($row['title']); ?>" 
                            class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-500" 
                        />
                    </div>
                    <h3 class="text-lg font-bold truncate px-1 group-hover:text-custom-green transition-colors">
                        <?php echo htmlspecialchars($row['title']); ?>
                    </h3>
                    <p class="text-xs text-gray-500 truncate uppercase tracking-widest mt-1">
                        <?php echo htmlspecialchars($row['author']); ?>
                    </p>
                </a>
        <?php
            }
            $result->free();
        } else {
            echo '
            <div class="col-span-full py-20 text-center">
                <p class="text-gray-500 text-xl italic">No books found for that search.</p>
                <a href="index.php" class="text-custom-green underline mt-4 inline-block">Back to home</a>
            </div>';
        }
        
        $conn->close();
        ?>
        
    </div>
</main>
    
<?php 
include 'footer.php'; 
?>