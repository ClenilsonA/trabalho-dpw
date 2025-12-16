<?php
// Inicia a sessão e inclui a configuração da base de dados
session_start();
require_once 'db_config.php';

$livros_populares = [];

// --- 1. Query para buscar Livros Populares ---
// USANDO AS COLUNAS CORRETAS: capa_url e categoria
$sql = "SELECT id, titulo, autor, capa_url, categoria, sinopse 
        FROM livros 
        WHERE is_popular = 1
        ORDER BY titulo ASC";

$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $livros_populares[] = $row;
    }
}

$conn->close();

include 'header.php';
include 'sidebar.php';
?>

    <main class="px-4 py-4 md:py-6 bg-main-bg text-custom-light">
        <h1 class="text-3xl font-bold mb-8 border-b border-gray-700 pb-2">
            Popular Books
        </h1>
        
        <?php if (empty($livros_populares)): ?>
            <div class="p-8 bg-sidebar-bg rounded-lg text-center">
                <p class="text-xl font-semibold mb-3">No popular books found yet!</p>
                <p class="text-gray-400">Mark some books with 'is_popular = 1' in the database to see them here.</p>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-6">
                
                <?php foreach ($livros_populares as $book): ?>
                    <a href="book-details.php?id=<?php echo htmlspecialchars($book['id']); ?>" class="block transform transition hover:scale-[1.03] hover:shadow-2xl">
                        
                        <div class="rounded-lg overflow-hidden h-full flex flex-col border border-gray-700 hover:border-custom-green transition duration-300">
                            
                            <img 
                                src="<?php echo htmlspecialchars($book['capa_url']); ?>" 
                                alt="<?php echo htmlspecialchars($book['titulo']); ?> cover" 
                                class="w-full h-auto object-cover" 
                                style="aspect-ratio: 2/3;" 
                            />
                            
                            <div class="p-3 flex-grow flex flex-col justify-end bg-sidebar-bg bg-opacity-50">
                                <h3 class="text-md font-bold mb-1 line-clamp-2 text-custom-light">
                                    <?php echo htmlspecialchars($book['titulo']); ?>
                                </h3>
                                <p class="text-sm text-gray-400 line-clamp-1">
                                    <?php echo htmlspecialchars($book['autor']); ?>
                                </p>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>

            </div>
        <?php endif; ?>
    </main>
<?php include 'footer.php'; ?>