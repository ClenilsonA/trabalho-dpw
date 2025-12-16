<?php
// read-book.php
session_start();
require_once 'db_config.php';

// Verifica o ID do Livro
if (!isset($_GET['id']) || !filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
    header("Location: index.php");
    exit;
}
$book_id = $_GET['id'];
$book_title = "Book Not Found"; // Título padrão
$content = "<p>Content not loaded. Please check the 'conteudo_url' in the database and ensure the file exists.</p>";

// --- 1. Buscar a URL do Conteúdo do Livro ---
// A query busca o título para o cabeçalho e a URL do ficheiro.
$sql = "SELECT titulo, conteudo_url FROM livros WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $book_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $book = $result->fetch_assoc();
    $book_title = htmlspecialchars($book['titulo']);
    $content_url = $book['conteudo_url'];

    // --- 2. Carregar o Conteúdo do Ficheiro ---
    // A função file_exists verifica se o caminho (Ex: livros/Harry-Potter.txt) é válido.
    if (!empty($content_url) && file_exists($content_url)) {
        
        // Usa file_get_contents para ler o texto.
        $raw_content = file_get_contents($content_url);
        
        // 3. Formatar o texto para HTML:
        // - htmlspecialchars: Previne ataques XSS e garante a exibição correta de caracteres especiais.
        // - nl2br: Converte quebras de linha (\n) do ficheiro .txt em tags <br> para que o texto seja formatado em parágrafos no navegador.
        $content = nl2br(htmlspecialchars($raw_content));
        
    } else {
        $content = "<p>File not found at the path: <strong>" . htmlspecialchars($content_url) . "</strong>. Please verify the file name and path.</p>";
    }
}
$stmt->close();
$conn->close();

include 'header.php';
// Não incluímos a sidebar para maximizar a área de leitura.
?>
    <main class="px-4 py-6 md:px-16 lg:px-24 bg-main-bg text-custom-light">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-4xl font-extrabold text-custom-green mb-4 border-b border-gray-700 pb-2">
                Reading: <?php echo $book_title; ?>
            </h1>
            
            <a href="book-details.php?id=<?php echo $book_id; ?>" class="text-sm text-gray-400 hover:text-custom-light mb-6 block">
                ← Back to Book Details
            </a>

            <div class="text-lg leading-relaxed text-gray-200 mt-6 max-h-[70vh] overflow-y-auto p-4 bg-sidebar-bg rounded-lg shadow-lg">
                <?php echo $content; ?>
            </div>

            <a href="book-details.php?id=<?php echo $book_id; ?>" class="inline-block mt-6 px-6 py-3 bg-custom-green text-black font-bold rounded-lg hover:bg-opacity-80 transition">
                Finished Reading
            </a>
        </div>
    </main>
<?php include 'footer.php'; ?>