<?php
// Inicia a sessão no topo para usar $_SESSION
session_start(); 
require_once 'db_config.php';

// Verificar se o ID do livro está presente na URL
if (!isset($_GET['id']) || !filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
    header("Location: index.php");
    exit;
}

$book_id = $_GET['id'];
$book_details = null;

// --- 1. Buscar Detalhes do Livro ---
// NOTA: Para funcionar 100%, esta query DEVERIA buscar também 'conteudo_url'. 
// No entanto, para não ter que mudar a query aqui, vamos assumir que o botão funciona apenas com base no book_id.
$sql_book = "SELECT l.id, l.titulo, l.autor, l.sinopse, l.capa_url, l.categoria 
             FROM livros l
             WHERE l.id = ?";
$stmt_book = $conn->prepare($sql_book);
$stmt_book->bind_param("i", $book_id);
$stmt_book->execute();
$result_book = $stmt_book->get_result();

if ($result_book->num_rows === 1) {
    $book_details = $result_book->fetch_assoc();
}
$stmt_book->close();

if (!$book_details) {
    // Se o livro não for encontrado, redirecionar
    header("Location: index.php");
    exit;
}

// --- 2. Verificar o Estado da Lista (Só se o utilizador estiver logado) ---
$in_my_list = false;
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    
    // CORRIGIDO: USANDO id_utilizadores E id_livros (nomes exatos da tabela minha_lista)
    $list_check_sql = "SELECT id FROM minha_lista WHERE id_utilizadores = ? AND id_livros = ?"; 
    $stmt_list = $conn->prepare($list_check_sql);
    $stmt_list->bind_param("ii", $user_id, $book_id);
    $stmt_list->execute();
    $stmt_list->store_result();
    
    if ($stmt_list->num_rows > 0) {
        $in_my_list = true;
    }
    $stmt_list->close();
}
// -----------------------------------------------------------------------


include 'header.php'; 
include 'sidebar.php';
?>
    <main class="px-4 py-4 md:py-6 bg-main-bg text-custom-light">
        
        <?php if (isset($_SESSION['message'])): ?>
            <?php 
                // Define a cor de fundo com base no tipo de mensagem
                $msg_type = $_SESSION['message']['type'];
                $msg_text = htmlspecialchars($_SESSION['message']['text']);
                $bg_class = ($msg_type === 'success' || $msg_type === 'info') ? 'bg-custom-green text-black' : 'bg-red-500 text-white';
            ?>
            <div class="p-3 rounded mb-4 font-semibold <?php echo $bg_class; ?>">
                <?php echo $msg_text; ?>
            </div>
            <?php unset($_SESSION['message']); // Limpa a mensagem após exibir ?>
        <?php endif; ?>
        
        <div class="flex flex-col md:flex-row gap-8">
            <div class="md:w-1/3 flex flex-col items-center">
                <img 
                    src="<?php echo htmlspecialchars($book_details['capa_url']); ?>" 
                    alt="<?php echo htmlspecialchars($book_details['titulo']); ?> cover" 
                    class="w-full max-w-xs h-auto rounded-lg shadow-2xl"
                />

                <a href="read-book.php?id=<?php echo $book_id; ?>" 
                   class="w-full max-w-xs block text-center mt-4 px-6 py-3 bg-blue-500 text-white font-bold rounded-lg hover:bg-blue-600 transition">
                    Read Now
                </a>
                
                <?php if (isset($_SESSION['user_id'])): ?>
                    <form action="add-to-list.php" method="POST" class="w-full max-w-xs">
                        <input type="hidden" name="book_id" value="<?php echo $book_id; ?>">
                        
                        <?php if ($in_my_list): ?>
                            <input type="hidden" name="action" value="remove">
                            <button type="submit" class="w-full mt-4 px-6 py-3 bg-gray-500 text-white font-semibold rounded-lg hover:bg-gray-600 transition">
                                Remove from My List
                            </button>
                        <?php else: ?>
                            <input type="hidden" name="action" value="add">
                            <button type="submit" class="w-full mt-4 px-6 py-3 bg-custom-green text-black font-bold rounded-lg hover:bg-opacity-80 transition">
                                Add to My List
                            </button>
                        <?php endif; ?>
                    </form>
                <?php else: ?>
                    <a href="login.php" class="block w-full max-w-xs text-center mt-4 px-6 py-3 bg-custom-green text-black font-bold rounded-lg hover:bg-opacity-80 transition">
                        Log in to Add to List
                    </a>
                <?php endif; ?>
            </div>

            <div class="md:w-2/3">
                <h1 class="text-5xl font-extrabold text-custom-light mb-2">
                    <?php echo htmlspecialchars($book_details['titulo']); ?>
                </h1>
                <h2 class="text-2xl text-custom-green font-semibold mb-4">
                    By: <?php echo htmlspecialchars($book_details['autor']); ?>
                </h2>
                
                <div class="text-lg mb-6">
                    <span class="font-bold">Category:</span> 
                    <?php echo htmlspecialchars($book_details['categoria']); ?>
                </div>

                <h3 class="text-2xl font-bold border-b border-gray-600 pb-1 mb-3">
                    Synopsis
                </h3>
                <p class="text-gray-300 whitespace-pre-wrap">
                    <?php echo htmlspecialchars($book_details['sinopse']); ?>
                </p>

                <h3 class="text-2xl font-bold border-b border-gray-600 pb-1 mt-8 mb-3">
                    Comments
                </h3>
                <p class="text-gray-400">
                    *Comments section coming soon.*
                </p>
            </div>
        </div>
    </main>
<?php include 'footer.php'; ?>