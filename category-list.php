<?php
// category-list.php
require_once 'db_config.php';
include 'header.php';

// Pegamos o ID da categoria via URL
$cat_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$genre_name = 'All Books';

// Procurar o nome da categoria para o título
if ($cat_id > 0) {
    $stmt_cat = $conn->prepare("SELECT name FROM categorias WHERE id = ?");
    $stmt_cat->bind_param("i", $cat_id);
    $stmt_cat->execute();
    $res_cat = $stmt_cat->get_result();
    if ($row_cat = $res_cat->fetch_assoc()) {
        $genre_name = $row_cat['name'];
    }
    $stmt_cat->close();
}
?>

<div class="flex w-full">

    <?php include 'sidebar.php'; ?>

    <main class="flex-1 min-w-0 px-4 py-4 md:py-8 bg-main-bg text-custom-light min-h-screen relative z-0">
        
        <div class="mb-10">
            <a href="categories.php" class="text-xs uppercase tracking-widest text-gray-500 hover:text-custom-green transition flex items-center gap-2">
                <span>&larr;</span> Back to Categories
            </a>
            <h1 class="text-4xl font-black text-custom-green mt-4 italic uppercase tracking-tighter">
                <?php echo htmlspecialchars($genre_name); ?>
            </h1>
            <div class="w-16 h-1 bg-custom-green mt-2"></div>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-6">
            <?php
            if ($cat_id > 0) {
                // Busca livros pela categoria ID
                $sql = "SELECT id, title, cover_url, author FROM livros WHERE category_id = ? ORDER BY title ASC";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $cat_id);
                $stmt->execute();
                $result = $stmt->get_result();
            } else {
                // Se não houver ID, mostra tudo
                $sql = "SELECT id, title, cover_url, author FROM livros ORDER BY title ASC";
                $result = $conn->query($sql);
            }

            if (isset($result) && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $detail_url = "book-details.php?id=" . $row['id'];
            ?>
                    <a href="<?php echo $detail_url; ?>" class="group block bg-sidebar-bg/50 p-3 rounded-xl border border-gray-800 hover:border-custom-green hover:bg-sidebar-bg transition-all duration-300">
                        <div class="relative overflow-hidden rounded-lg mb-3 aspect-[2/3] bg-gray-800 shadow-lg">
                            <img 
                                src="<?php echo htmlspecialchars($row['cover_url']); ?>" 
                                alt="<?php echo htmlspecialchars($row['title']); ?>" 
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                            />
                        </div>
                        <h3 class="text-sm font-bold truncate group-hover:text-custom-green transition-colors">
                            <?php echo htmlspecialchars($row['title']); ?>
                        </h3>
                        <p class="text-[11px] text-gray-500 mt-1 truncate italic">
                            <?php echo htmlspecialchars($row['author']); ?>
                        </p>
                    </a>
            <?php
                }
            } else {
                echo '<div class="col-span-full py-20 text-center border-2 border-dashed border-gray-800 rounded-3xl text-gray-500 italic">No books found in this genre.</div>';
            }

            if (isset($stmt)) $stmt->close();
            $conn->close();
            ?>
        </div>
    </main>
</div>

<?php include 'footer.php'; ?>