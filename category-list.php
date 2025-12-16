<?php 
// 1. INCLUIR A CONFIGURAÇÃO DO BANCO DE DADOS
// IMPORTANTE: Certifique-se que o db_config.php está na mesma pasta.
require_once 'db_config.php'; 

// Query para obter categorias únicas e não repetidas (usada na secção Genres)
$sql_categories = "SELECT DISTINCT categoria FROM livros ORDER BY categoria ASC";
$result_categories = $conn->query($sql_categories);

// Inclui o HTML inicial, Navbar e abre o Grid
include 'header.php'; 
?>
    
<?php 
// Inclui a Sidebar
include 'sidebar.php'; 
?>

    <main class="px-4 py-4 md:py-6 bg-main-bg text-custom-light overflow-hidden">
        
        <section class="mb-8">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-semibold">Genres</h2> 
                
                <div class="flex flex-shrink-0"> 
                    <button class="scroll-arrow mr-2" onclick="scrollCarousel('genres-list', 'left')">&#10094;</button>
                    <button class="scroll-arrow" onclick="scrollCarousel('genres-list', 'right')">&#10095;</button>
                </div>
            </div>
            
            <div class="relative">
                <div id="genres-list" class="flex overflow-x-scroll scroll-hide-native pb-2 space-x-4">
                    
                    <a href="categories.php" class="text-center flex-shrink-0 w-24 hover:opacity-80 transition">
                        <img src="assets/images/yellow-book-4995 1.png" alt="All" class="w-20 h-20 mx-auto mb-2" />
                        <p class="text-sm">All</p>
                    </a>

                    <?php
                    // Mapeamento de imagens para algumas categorias (opcional, para visual)
                    $category_images = [
                        'Fantasy' => 'assets/images/yellow-book-4995 3.png',
                        'Classic' => 'assets/images/yellow-book-4995 30.png',
                        'Political Science' => 'assets/images/yellow-book-4995 4.png',
                        'Science Fiction' => 'assets/images/yellow-book-4995 5.png',
                    ];
                    
                    if ($result_categories && $result_categories->num_rows > 0) {
                        while($row = $result_categories->fetch_assoc()) {
                            $category_name = htmlspecialchars($row['categoria']);
                            // Tenta obter a imagem mapeada, senão usa uma padrão
                            $category_img = $category_images[$category_name] ?? 'assets/images/yellow-book-4995 1.png';
                            
                            // O link usa urlencode para garantir que caracteres especiais funcionem no URL
                            $category_link = "categories.php?genre=" . urlencode($category_name);
                    ?>
                            <a href="<?php echo $category_link; ?>" class="text-center flex-shrink-0 w-24 hover:opacity-80 transition">
                                <img src="<?php echo $category_img; ?>" alt="<?php echo $category_name; ?>" class="w-20 h-20 mx-auto mb-2" />
                                <p class="text-sm"><?php echo $category_name; ?></p>
                            </a>
                    <?php
                        }
                        $result_categories->free();
                    }
                    ?>
                </div>
            </div>
        </section>
        
        <section class="mb-8">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-semibold">Popular</h2> 
                
                <div class="flex flex-shrink-0">
                    <button class="scroll-arrow mr-2" onclick="scrollCarousel('popular-list', 'left')">&#10094;</button>
                    <button class="scroll-arrow" onclick="scrollCarousel('popular-list', 'right')">&#10095;</button>
                </div>
            </div>

            <div class="relative">
                <div id="popular-list" class="flex overflow-x-scroll scroll-hide-native pb-2 space-x-4">
                    
                    <?php
                    // Query para selecionar livros marcados como populares
                    $sql_popular = "SELECT id, titulo, capa_url FROM livros WHERE is_popular = 1 LIMIT 7";
                    $result_popular = $conn->query($sql_popular);

                    if ($result_popular && $result_popular->num_rows > 0) {
                        while($row = $result_popular->fetch_assoc()) {
                            $detail_url = "book-details.php?id=" . $row['id']; 
                    ?>
                            <a href="<?php echo $detail_url; ?>" class="text-center flex-shrink-0 w-32 hover:opacity-80 transition">
                                <img 
                                    src="<?php echo $row['capa_url']; ?>" 
                                    alt="<?php echo htmlspecialchars($row['titulo']); ?>" 
                                    class="w-full h-48 object-cover rounded mb-2" 
                                />
                                <p class="text-base"><?php echo htmlspecialchars($row['titulo']); ?></p>
                            </a>
                            <?php
                        } // Fim do loop
                        $result_popular->free();
                    } else {
                        echo "<p class='text-gray-400'>Não foram encontrados livros populares na base de dados.</p>";
                    }
                    ?>

                </div>
            </div>
        </section>

        <section class="bg-custom-green text-custom-light p-6 rounded-lg my-8 flex flex-col md:flex-row items-center justify-between">
            <div class="order-2 md:order-1">
                <h1 class="text-4xl font-bold">2024 year 50 most</h1>
                <h1 class="text-4xl font-bold">popular bestseller</h1>
                <p class="mt-1 mb-4">Explore the literary highlights of 2023 with our '50 Most Popular Bestsellers'badge—a curated collection of the year's must-reads.</p>

                <button class="px-4 py-2 bg-custom-light text-black font-semibold rounded hover:bg-gray-200">View Now</button>
            </div> 
            <div class="mt-4 md:mt-0 order-1 md:order-2">
                <img src="assets/images/alice-removebg-preview 1.png" alt="Featured Book" class="rounded max-h-72" /> 
            </div>
        </section>

        <section>
            <h2 class="text-2xl font-semibold mb-4">Latest</h2>
            <div class="flex overflow-x-scroll scroll-hide-native pb-2 space-x-4">
                
                <?php
                // Query para selecionar os últimos livros adicionados (ordenados por ID descendente)
                $sql_latest = "SELECT id, titulo, capa_url FROM livros ORDER BY id DESC LIMIT 7";
                $result_latest = $conn->query($sql_latest);

                if ($result_latest && $result_latest->num_rows > 0) {
                    while($row = $result_latest->fetch_assoc()) {
                         $detail_url = "book-details.php?id=" . $row['id'];
                ?>
                        <a href="<?php echo $detail_url; ?>" class="text-center flex-shrink-0 w-32 hover:opacity-80 transition">
                            <img 
                                src="<?php echo $row['capa_url']; ?>" 
                                alt="<?php echo htmlspecialchars($row['titulo']); ?>" 
                                class="w-full h-48 object-cover rounded mb-2" 
                            />
                            <p class="text-base"><?php echo htmlspecialchars($row['titulo']); ?></p>
                        </a>
                        <?php
                    } // Fim do loop
                    $result_latest->free();
                } else {
                    echo "<p class='text-gray-400'>Não foram encontrados registos de últimos livros.</p>";
                }
                
                // FECHAR A CONEXÃO COM O BANCO DE DADOS (BOA PRÁTICA)
                $conn->close();
                ?>
                
            </div>
        </section>
        
    </main>
    <?php 
// Inclui o JavaScript e o fecho das tags HTML
include 'footer.php'; 
?>