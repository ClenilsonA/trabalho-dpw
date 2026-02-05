<?php
// read-book.php
session_start();
require_once 'db_config.php';

if (!isset($_GET['id']) || !filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
    header("Location: index.php");
    exit;
}

$book_id = $_GET['id'];
$book_title = ""; $file_path = "";

$sql = "SELECT title, file_url FROM livros WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $book_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $book = $result->fetch_assoc();
    $book_title = htmlspecialchars($book['title']);
    $file_path = $book['file_url']; 
}
$stmt->close(); $conn->close();

include 'header.php'; 
// NÃO incluas a sidebar aqui para evitar que ela empurre o conteúdo
?>

<style>
    /* CSS para garantir que o layout ignore bloqueios laterais */
    .reader-container {
        display: block !important;
        width: 100% !important;
        max-width: 1200px !important; /* Largura do livro no ecrã */
        margin-left: auto !important;
        margin-right: auto !important;
        padding: 20px;
    }
    .pdf-frame {
        width: 100%;
        height: 85vh;
        border: 1px solid #333;
        box-shadow: 0 0 50px rgba(0,0,0,0.5);
    }
    /* Força o main a ocupar o ecrã todo sem ser esmagado */
    main {
        width: 100vw !important;
        display: block !important;
    }
</style>

<main class="bg-main-bg">
    <div class="reader-container">
        
        <div style="margin-bottom: 15px;">
            <a href="book-details.php?id=<?php echo $book_id; ?>" style="color: #888; text-decoration: none; font-size: 14px;">
                &larr; Back to Library
            </a>
            <h1 style="color: #00FF87; margin-top: 5px; font-size: 28px;">
                <?php echo $book_title; ?>
            </h1>
        </div>

        <div class="pdf-frame">
            <?php if (!empty($file_path) && file_exists($file_path)): ?>
                <embed 
                    src="<?php echo htmlspecialchars($file_path); ?>#view=FitH" 
                    type="application/pdf" 
                    width="100%" 
                    height="100%" 
                />
            <?php else: ?>
                <div style="padding: 50px; text-align: center; color: white;">
                    <p>PDF file not found at: <?php echo htmlspecialchars($file_path); ?></p>
                </div>
            <?php endif; ?>
        </div>

    </div>
</main>

<?php include 'footer.php'; ?>