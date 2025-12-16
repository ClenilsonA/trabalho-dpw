<?php
// Inicia a sessão para obter o ID do utilizador
session_start();
require_once 'db_config.php';

// Redirecionar se o utilizador não estiver logado
if (!isset($_SESSION['user_id'])) {

    header("Location: login.php"); 
    exit;
}

$user_id = $_SESSION['user_id'];

// Verificar se os dados necessários foram recebidos
if (!isset($_POST['book_id']) || !isset($_POST['action'])) {
    // Redireciona 
    header("Location: index.php"); 
    exit;
}

$book_id = $_POST['book_id'];
$action = $_POST['action']; // Ação pode ser 'add' ou 'remove'

// Validação de segurança: garantir que o ID do livro é um inteiro
if (!filter_var($book_id, FILTER_VALIDATE_INT)) {
    // Redireciona se for inválido
    header("Location: index.php"); 
    exit;
}

$conn->begin_transaction(); // Inicia uma transação para garantir a integridade dos dados

try {
    if ($action === 'add') {
        // --- ADICIONAR À LISTA ---
        // A Chave Única Composta (`uc_user_book`) irá impedir entradas duplicadas.
        $sql = "INSERT INTO minha_lista (id_utilizador, id_livro) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $user_id, $book_id);
        
        if ($stmt->execute()) {
            // Sucesso: Livro adicionado. Mensagem do sistema em Inglês.
            $_SESSION['message'] = ['type' => 'success', 'text' => 'Book added to your list successfully.'];
        } else {
            // Verifica o erro de entrada duplicada (código 1062 no MySQL/MariaDB)
            if ($conn->errno == 1062) {
                 // A entrada já existe. Mensagem do sistema em Inglês.
                 $_SESSION['message'] = ['type' => 'info', 'text' => 'This book is already in your list.'];
            } else {
                 // Outro erro de base de dados.
                 throw new Exception("Database error: " . $conn->error);
            }
        }
        $stmt->close();
        
    } elseif ($action === 'remove') {
        // --- REMOVER DA LISTA ---
        // SQL para apagar o par utilizador-livro da tabela.
        $sql = "DELETE FROM minha_lista WHERE id_utilizador = ? AND id_livro = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $user_id, $book_id);
        $stmt->execute();
        $stmt->close();

        // Sucesso na remoção. Mensagem do sistema em Inglês.
        $_SESSION['message'] = ['type' => 'success', 'text' => 'Book removed from your list.'];
    }

    $conn->commit(); // Confirma as alterações na base de dados
    
} catch (Exception $e) {
    $conn->rollback(); // Reverte a transação em caso de erro
    // Erro inesperado. Mensagem do sistema em Inglês.
    $_SESSION['message'] = ['type' => 'error', 'text' => 'An unexpected error occurred.'];
}

$conn->close();

// Redirecionar de volta para a página de detalhes do livro
header("Location: book-details.php?id=" . $book_id);
exit;
?>