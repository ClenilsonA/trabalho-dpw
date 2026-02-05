<?php
// my-list.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'db_config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$my_books = [];

// Query atualizada para a tabela 'my_list'
$sql = "SELECT l.id, l.title, l.author, l.cover_url 
        FROM my_list ml
        JOIN livros l ON ml.book_id = l.id
        WHERE ml.user_id = ?
        ORDER BY l.title ASC";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Database error: " . $conn->error);
}

$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $my_books[] = $row;
}

$stmt->close();
$conn->close();

include 'header.php';
?>

<div class="flex w-full">
    
    <?php include 'sidebar.php'; ?>

    <main class="flex-1 min-w-0 px-4 py-6 md:py-10 bg-main-bg text-custom-light min-h-screen relative z-0">
        
        <header class="mb-10">
            <h1 class="text-4xl md:text-5xl font-black text-custom-green italic tracking-tighter uppercase">
                My Library <span class="text-gray-500 not-italic text-2xl ml-2 font-light">(<?php echo count($my_books); ?>)</span>
            </h1>
            <p class="text-gray-400 mt-2 font-medium">Your personal collection of saved stories.</p>
            <div class="h-1.5 w-24 bg-custom-green mt-4 rounded-full shadow-[0_0_10px_#09C358]"></div>
        </header>
        
        <?php if (empty($my_books)): ?>
            <div class="p-16 bg-sidebar-bg/50 rounded-3xl text-center border-2 border-dashed border-gray-800 flex flex-col items-center justify-center">
                <div class="w-20 h-20 bg-gray-800 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-10 h-10 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
                <p class="text-2xl font-bold mb-2">Your list is still a blank page</p>
                <p class="text-gray-400 mb-8 max-w-xs mx-auto">Discover amazing stories and save them here to read whenever you want.</p>
                <a href="index.php" class="px-10 py-4 bg-custom-green text-black font-black rounded-xl hover:scale-105 transition-all shadow-lg uppercase tracking-widest text-sm">
                    Browse Books
                </a>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-x-6 gap-y-10">
                <?php foreach ($my_books as $book): ?>
                    <a href="book-details.php?id=<?php echo $book['id']; ?>" class="group flex flex-col">
                        <div class="relative aspect-[2/3] overflow-hidden rounded-2xl shadow-2xl mb-4 border border-gray-800 group-hover:border-custom-green transition-all duration-300 group-hover:-translate-y-2">
                            <img 
                                src="<?php echo htmlspecialchars($book['cover_url']); ?>" 
                                alt="<?php echo htmlspecialchars($book['title']); ?>" 
                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" 
                            />
                            <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-end justify-center p-4">
                                <span class="bg-white text-black text-[10px] font-black px-4 py-2 rounded-full uppercase tracking-widest">READ NOW</span>
                            </div>
                        </div>
                        <h3 class="text-base font-bold truncate text-custom-light group-hover:text-custom-green transition-colors px-1">
                            <?php echo htmlspecialchars($book['title']); ?>
                        </h3>
                        <p class="text-xs text-gray-500 truncate italic px-1 mt-1"><?php echo htmlspecialchars($book['author']); ?></p>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </main>
</div>

<?php include 'footer.php'; ?>