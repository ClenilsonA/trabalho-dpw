<?php
require_once 'db_config.php'; 

// Inclui o HTML inicial, Navbar e abre o Grid
include 'header.php'; 
?>
    
<?php 
// Inclui a Sidebar
include 'sidebar.php'; 
?>

    <main class="px-4 py-4 md:py-6 bg-main-bg text-custom-light">
        
        <?php
        $search_term = "";
        $where_clause = "";
        $title_text = "Search Results";

        // 1. Verificar se o termo de pesquisa (q) foi passado no URL
        if (isset($_GET['q']) && !empty($_GET['q'])) {
            // Usamos a função trim para remover espaços em branco desnecessários
            $search_term = trim($_GET['q']);
            
            // 2. Prepara o termo para ser usado na query SQL (Adiciona % para pesquisa LIKE)
            // IMPORTANTE: Usa real_escape_string para segurança contra SQL Injection
            $safe_term = $conn->real_escape_string($search_term);
            $like_pattern = '%' . $safe_term . '%';

            $title_text = "Results for: \"{$search_term}\"";

            // 3. Cria a cláusula WHERE para procurar no TÍTULO OU no AUTOR
            $where_clause = "WHERE titulo LIKE '{$like_pattern}' OR autor LIKE '{$like_pattern}'";
        }

        // 4. Query Principal
        // Esta query irá buscar todos os livros que correspondam à cláusula WHERE (ou todos, se não houver termo de pesquisa)
        $sql = "SELECT id, titulo, autor, capa_url, categoria FROM livros {$where_clause} ORDER BY titulo ASC";
        $result = $conn->query($sql);
        ?>

        <h1 class="text-3xl font-bold mb-6 border-b border-gray-700 pb-2"><?php echo $title_text; ?></h1>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-6">
            
            <?php
            if ($result && $result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $detail_url = "book-details.php?id=" . $row['id'];
            ?>
                    <a href="<?php echo $detail_url; ?>" class="text-center flex-shrink-0 hover:opacity-80 transition block">
                        <img 
                            src="<?php echo htmlspecialchars($row['capa_url']); ?>" 
                            alt="<?php echo htmlspecialchars($row['titulo']); ?>" 
                            class="w-full h-48 object-cover rounded mb-2" 
                        />
                        <p class="text-base font-medium"><?php echo htmlspecialchars($row['titulo']); ?></p>
                        <p class="text-sm text-gray-400"><?php echo htmlspecialchars($row['autor']); ?></p>
                    </a>
                    <?php
                }
                $result->free();
            } else {
                echo '<p class="text-gray-400">Desculpe, não foram encontrados resultados para a sua pesquisa.</p>';
            }
            
            $conn->close();
            ?>
            
        </div>
        
    </main>
    
<?php 
include 'footer.php'; 
?>