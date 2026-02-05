<?php
session_start();
require_once 'db_config.php';

// 1. PROCESSAR INSERÇÃO (Usando as tuas colunas exatas do print)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $t = $_POST['title'];
    $a = $_POST['author'];
    $c = $_POST['cover_url'];
    $f = $_POST['file_url'];
    $s = $_POST['synopsis'];
    $cat = $_POST['category_id'];

    $sql = "INSERT INTO livros (title, author, category_id, synopsis, cover_url, file_url) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssisss", $t, $a, $cat, $s, $c, $f);
    $stmt->execute();
    header("Location: admin.php?ok=1");
    exit;
}

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM livros WHERE id = $id");
    header("Location: admin.php");
    exit;
}

// 2. BUSCAR DADOS (Corrigido o erro do 'Unknown column nome')
$result = $conn->query("SELECT * FROM livros ORDER BY id DESC");
$categorias = $conn->query("SELECT * FROM categorias"); // Removi o ORDER BY nome para não dar erro

include 'header.php'; 
?>

<div class="w-full flex justify-center bg-main-bg min-h-screen">
    
    <div class="w-full max-w-3xl px-6 py-10">
        
        <header class="text-center mb-10">
            <h1 class="text-6xl font-black text-custom-green italic uppercase tracking-tighter italic">ADMIN PANEL</h1>
            <p class="text-gray-500 font-bold uppercase tracking-[0.3em] text-[10px] mt-2">Database Control Center</p>
        </header>

        <section class="bg-sidebar-bg p-10 rounded-[2.5rem] border border-gray-800 shadow-2xl mb-12">
            <form action="admin.php" method="POST" class="space-y-6">
                <input type="hidden" name="action" value="add">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-[10px] uppercase font-black text-custom-green ml-2">Book Title</label>
                        <input type="text" name="title" placeholder="e.g. Zero to One" class="w-full p-4 bg-main-bg border border-gray-700 rounded-2xl text-white outline-none focus:border-custom-green transition" required>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] uppercase font-black text-custom-green ml-2">Author</label>
                        <input type="text" name="author" placeholder="Peter Thiel" class="w-full p-4 bg-main-bg border border-gray-700 rounded-2xl text-white outline-none focus:border-custom-green transition" required>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-[10px] uppercase font-black text-custom-green ml-2">Cover Image URL</label>
                        <input type="text" name="cover_url" placeholder="https://..." class="w-full p-4 bg-main-bg border border-gray-700 rounded-2xl text-white outline-none focus:border-custom-green transition" required>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] uppercase font-black text-custom-green ml-2">PDF File URL</label>
                        <input type="text" name="file_url" placeholder="https://..." class="w-full p-4 bg-main-bg border border-gray-700 rounded-2xl text-white outline-none focus:border-custom-green transition">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] uppercase font-black text-custom-green ml-2">Genre / Category</label>
                    <select name="category_id" class="w-full p-4 bg-main-bg border border-gray-700 rounded-2xl text-white outline-none focus:border-custom-green appearance-none">
                        <option value="">Select a category...</option>
                        <?php while($c = $categorias->fetch_assoc()): ?>
                            <option value="<?= $c['id'] ?>"><?= $c['name'] ?? $c['nome'] ?? 'Category '.$c['id'] ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] uppercase font-black text-custom-green ml-2">Synopsis</label>
                    <textarea name="synopsis" rows="4" placeholder="Brief description of the book..." class="w-full p-4 bg-main-bg border border-gray-700 rounded-2xl text-white outline-none focus:border-custom-green transition"></textarea>
                </div>

                <button type="submit" class="w-full bg-custom-green text-black font-black py-5 rounded-2xl uppercase hover:brightness-110 transition shadow-lg tracking-widest text-lg">
                    SAVE BOOK
                </button>
            </form>
        </section>

        <section class="bg-sidebar-bg rounded-[2.5rem] border border-gray-800 shadow-2xl overflow-hidden">
            <div class="p-6 border-b border-gray-800 bg-black/20 px-8">
                <h2 class="text-xs font-black uppercase text-gray-500 tracking-widest">Database Content</h2>
            </div>
            <table class="w-full text-left">
                <tbody class="divide-y divide-gray-800">
                    <?php if($result && $result->num_rows > 0): ?>
                        <?php while($b = $result->fetch_assoc()): ?>
                            <tr class="hover:bg-white/[0.02] transition">
                                <td class="p-6 pl-10">
                                    <div class="font-bold text-white text-xl"><?= htmlspecialchars($b['title']) ?></div>
                                    <div class="text-[10px] text-gray-500 font-bold uppercase tracking-widest mt-1"><?= htmlspecialchars($b['author']) ?></div>
                                </td>
                                <td class="p-6 pr-10 text-right">
                                    <a href="admin.php?delete=<?= $b['id'] ?>" onclick="return confirm('Delete?')" class="text-red-500 font-black text-[10px] border border-red-500/20 px-5 py-2 rounded-full hover:bg-red-500 hover:text-white transition uppercase">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>

    </div>
</div>

<?php include 'footer.php'; ?>