<?php
// add-to-list.php
session_start();
require_once 'db_config.php';

// 1. Verificar se o utilizador está logado
if (!isset($_SESSION['user_id'])) {
    $_SESSION['message'] = ['type' => 'error', 'text' => 'You must be logged in to manage your list.'];
    header("Location: login.php");
    exit;
}

// 2. Verificar se os dados foram enviados por POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['book_id'], $_POST['action'])) {
    $user_id = $_SESSION['user_id'];
    $book_id = intval($_POST['book_id']);
    $action = $_POST['action'];

    if ($action === 'add') {
        // INSERIR na nova tabela 'my_list' usando nomes em Inglês
        $sql = "INSERT IGNORE INTO my_list (user_id, book_id) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $user_id, $book_id);
        
        if ($stmt->execute()) {
            $_SESSION['message'] = ['type' => 'success', 'text' => 'Book added to your library!'];
        } else {
            $_SESSION['message'] = ['type' => 'error', 'text' => 'Error adding book: ' . $conn->error];
        }
        $stmt->close();

    } elseif ($action === 'remove') {
        // REMOVER da nova tabela 'my_list'
        $sql = "DELETE FROM my_list WHERE user_id = ? AND book_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $user_id, $book_id);
        
        if ($stmt->execute()) {
            $_SESSION['message'] = ['type' => 'info', 'text' => 'Book removed from your library.'];
        } else {
            $_SESSION['message'] = ['type' => 'error', 'text' => 'Error removing book.'];
        }
        $stmt->close();
    }

    $conn->close();
    // Redireciona de volta para a página onde o utilizador estava
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;

} else {
    // Se alguém tentar aceder ao ficheiro diretamente sem POST
    header("Location: index.php");
    exit;
}