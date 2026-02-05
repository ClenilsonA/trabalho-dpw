<?php
// book-details.php
if (session_status() === PHP_SESSION_NONE) {
    session_start(); 
}
require_once 'db_config.php';

if (!isset($_GET['id']) || !filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
    header("Location: index.php");
    exit;
}

$book_id = $_GET['id'];
$book_details = null;

// --- 1. Buscar Detalhes do Livro ---
$sql_book = "SELECT l.id, l.title, l.author, l.synopsis, l.cover_url, c.name AS category_name 
             FROM livros l
             JOIN categorias c ON l.category_id = c.id
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
    header("Location: index.php");
    exit;
}

// --- 2. Verificar o Estado da Lista ---
$in_my_list = false;
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $list_check_sql = "SELECT id FROM my_list WHERE user_id = ? AND book_id = ?"; 
    $stmt_list = $conn->prepare($list_check_sql);
    $stmt_list->bind_param("ii", $user_id, $book_id);
    $stmt_list->execute();
    $stmt_list->store_result();
    
    if ($stmt_list->num_rows > 0) {
        $in_my_list = true;
    }
    $stmt_list->close();
}

include 'header.php'; 
?>

<div class="flex w-full">
    
    <?php include 'sidebar.php'; ?>

    <main class="flex-1 min-w-0 px-4 py-6 md:py-10 bg-main-bg text-custom-light min-h-screen relative z-0">
        
        <?php if (isset($_SESSION['message'])): ?>
            <?php 
                $msg_type = $_SESSION['message']['type'];
                $msg_text = htmlspecialchars($_SESSION['message']['text']);
                $bg_class = ($msg_type === 'success' || $msg_type === 'info') ? 'bg-custom-green text-black' : 'bg-red-500 text-white';
            ?>
            <div class="max-w-5xl mx-auto p-4 rounded-xl mb-8 font-bold shadow-lg <?php echo $bg_class; ?>">
                <?php echo $msg_text; ?>
            </div>
            <?php unset($_SESSION['message']); ?>
        <?php endif; ?>
        
        <div class="max-w-6xl mx-auto flex flex-col md:flex-row gap-10 md:gap-16">
            
            <div class="md:w-1/3 lg:w-1/4 flex flex-col items-center">
                <div class="w-full shadow-[0_20px_50px_rgba(0,0,0,0.5)] rounded-2xl overflow-hidden border border-gray-800 transition-transform hover:scale-[1.02] duration-500">
                    <img 
                        src="<?php echo htmlspecialchars($book_details['cover_url']); ?>" 
                        alt="<?php echo htmlspecialchars($book_details['title']); ?>" 
                        class="w-full h-auto object-cover"
                    />
                </div>

                <div class="w-full mt-8 space-y-4">
                    <a href="read-book.php?id=<?php echo $book_id; ?>" 
                       class="flex items-center justify-center gap-2 w-full px-6 py-4 bg-white text-black font-black rounded-xl hover:bg-custom-green transition-all shadow-xl uppercase tracking-tighter">
                       <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                       Read Now
                    </a>
                    
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <form action="add-to-list.php" method="POST" class="w-full">
                            <input type="hidden" name="book_id" value="<?php echo $book_id; ?>">
                            
                            <?php if ($in_my_list): ?>
                                <input type="hidden" name="action" value="remove">
                                <button type="submit" class="flex items-center justify-center gap-2 w-full px-6 py-4 bg-gray-800 text-custom-green font-bold rounded-xl border border-custom-green/30 hover:bg-gray-700 transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    In Your List
                                </button>
                            <?php else: ?>
                                <input type="hidden" name="action" value="add">
                                <button type="submit" class="flex items-center justify-center gap-2 w-full px-6 py-4 bg-custom-green/10 text-custom-green font-bold rounded-xl border border-custom-green/50 hover:bg-custom-green hover:text-black transition-all">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    Add to My List
                                </button>
                            <?php endif; ?>
                        </form>
                    <?php else: ?>
                        <a href="login.php" class="block text-center w-full px-6 py-4 bg-gray-800 text-gray-400 font-bold rounded-xl border border-gray-700 hover:text-white transition">
                            Log in to Add to List
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <div class="md:w-2/3 lg:w-3/4">
                <nav class="mb-6">
                    <a href="categories.php" class="text-xs font-bold text-gray-500 uppercase tracking-[0.2em] hover:text-custom-green transition">
                        &larr; Back to library
                    </a>
                </nav>

                <h1 class="text-5xl md:text-7xl font-black text-white mb-4 tracking-tighter leading-none">
                    <?php echo htmlspecialchars($book_details['title']); ?>
                </h1>
                
                <div class="flex flex-wrap items-center gap-4 mb-10">
                    <h2 class="text-2xl text-custom-green font-bold italic">
                        <?php echo htmlspecialchars($book_details['author']); ?>
                    </h2>
                    <span class="text-gray-700">|</span>
                    <span class="bg-gray-800 text-custom-light px-4 py-1.5 rounded-full text-xs font-black uppercase tracking-widest border border-gray-700">
                        <?php echo htmlspecialchars($book_details['category_name']); ?>
                    </span>
                </div>

                <div class="bg-sidebar-bg/30 p-8 rounded-2xl border border-gray-800/50 backdrop-blur-sm">
                    <h3 class="text-sm font-black text-gray-500 uppercase tracking-[0.3em] mb-6 flex items-center gap-3">
                        <span class="w-8 h-[1px] bg-custom-green"></span>
                        Synopsis
                    </h3>
                    <p class="text-gray-300 text-xl leading-relaxed whitespace-pre-wrap font-medium">
                        <?php echo htmlspecialchars($book_details['synopsis']); ?>
                    </p>
                </div>
                
                <div class="mt-10 flex gap-10 border-t border-gray-800 pt-10">
                   <div>
                       <p class="text-[10px] text-gray-500 uppercase font-black tracking-widest mb-1">Format</p>
                       <p class="text-sm font-bold">Digital E-Book</p>
                   </div>
                   <div>
                       <p class="text-[10px] text-gray-500 uppercase font-black tracking-widest mb-1">Language</p>
                       <p class="text-sm font-bold">English (Original)</p>
                   </div>
                </div>
            </div>

        </div>
    </main>
</div>

<?php include 'footer.php'; ?>