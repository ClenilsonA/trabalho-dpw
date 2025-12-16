<?php
// Inicia a sessão e conecta à BD
session_start();
require_once 'db_config.php';

// Redireciona se o utilizador não estiver logado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$my_books = [];

// --- Buscar Livros da Lista do Utilizador ---
// Junta a tabela 'minha_lista' com a tabela 'livros'
$sql = "SELECT l.id, l.titulo, l.autor, l.imagem_url 
        FROM minha_lista ml
        JOIN livros l ON ml.id_livro = l.id
        WHERE ml.id_utilizador = ?
        ORDER BY l.titulo ASC"; // Ordena pelo título para melhor visualização

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $my_books[] = $row;
}

$stmt->close();
$conn->close();

include 'header.php';
include 'sidebar.php';
?>
    <main class="px-4 py-4 md:py-6 bg-main-bg text-custom-light">
        <h1 class="text-4xl font-bold text-custom-green mb-6">
            My Reading List (<?php echo count($my_books); ?> Books)
        </h1>
        
        <?php if (empty($my_books)): ?>
            <div class="p-8 bg-sidebar-bg rounded-lg text-center">
                <p class="text-xl font-semibold mb-3">Your list is empty!</p>
                <p class="text-gray-400">Go to any book's details page and click "Add to My List" to start building your collection.</p>
                <a href="index.php" class="inline-block mt-4 px-6 py-2 bg-custom-green text-black font-semibold rounded-lg hover:bg-opacity-80 transition">
                    Browse Books
                </a>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-6">
                
                <?php foreach ($my_books as $book): ?>
                    <a href="book-details.php?id=<?php echo htmlspecialchars($book['id']); ?>" class="block transform transition hover:scale-[1.03] hover:shadow-2xl">
                        <div class="bg-sidebar-bg rounded-lg overflow-hidden h-full flex flex-col">
                            <img 
                                src="<?php echo htmlspecialchars($book['imagem_url']); ?>" 
                                alt="<?php echo htmlspecialchars($book['titulo']); ?> cover" 
                                class="w-full h-auto object-cover" 
                                style="aspect-ratio: 2/3;" 
                            />
                            <div class="p-3 flex-grow flex flex-col justify-end">
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