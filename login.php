<?php
// login.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'db_config.php';

// Se o utilizador já estiver logado, redireciona para a home page
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];

    if (empty($email) || empty($senha)) {
        $error = "Please fill in all fields.";
    } else {
        $sql = "SELECT id, nome, senha FROM utilizadores WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            if (password_verify($senha, $user['senha'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['nome'];
                header("Location: index.php");
                exit;
            } else {
                $error = "Incorrect email or password.";
            }
        } else {
            $error = "Incorrect email or password.";
        }
        $stmt->close();
    }
}
$conn->close();

include 'header.php'; 
?>

<div class="flex w-full">

    <?php include 'sidebar.php'; ?>

    <main class="flex-1 min-w-0 bg-main-bg text-custom-light min-h-[calc(100vh-74px)] flex items-center justify-center p-4">
        
        <div class="w-full max-w-md p-8 bg-sidebar-bg rounded-2xl shadow-2xl border border-gray-800 relative">
            
            <div class="absolute -top-10 -left-10 w-32 h-32 bg-custom-green/10 rounded-full blur-3xl"></div>
            
            <div class="relative z-10">
                <header class="text-center mb-8">
                    <h2 class="text-4xl font-black text-custom-green italic tracking-tighter uppercase">Log In</h2>
                    <p class="text-gray-500 text-sm mt-2 font-medium tracking-wide">Welcome back to Bookify</p>
                </header>
                
                <?php if ($error): ?>
                    <div class="bg-red-500/10 border border-red-500 text-red-500 p-4 rounded-xl mb-6 text-sm font-bold flex items-center gap-2">
                        <span>⚠️</span> <?php echo $error; ?>
                    </div>
                <?php endif; ?>

                <form action="login.php" method="POST" class="space-y-5">
                    <div>
                        <label for="email" class="block mb-2 text-xs font-black uppercase tracking-widest text-gray-400">Email Address</label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            required 
                            placeholder="your@email.com"
                            class="w-full p-4 rounded-xl bg-gray-800 text-custom-light border border-gray-700 focus:outline-none focus:border-custom-green focus:ring-1 focus:ring-custom-green transition-all"
                            value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                        >
                    </div>

                    <div>
                        <label for="senha" class="block mb-2 text-xs font-black uppercase tracking-widest text-gray-400">Password</label>
                        <input 
                            type="password" 
                            id="senha" 
                            name="senha" 
                            required 
                            placeholder="••••••••"
                            class="w-full p-4 rounded-xl bg-gray-800 text-custom-light border border-gray-700 focus:outline-none focus:border-custom-green focus:ring-1 focus:ring-custom-green transition-all"
                        >
                    </div>

                    <button type="submit" class="w-full bg-custom-green text-black font-black p-4 rounded-xl hover:bg-green-400 hover:scale-[1.02] active:scale-95 transition-all shadow-[0_10px_20px_rgba(9,195,88,0.2)] uppercase tracking-widest text-sm">
                        Enter Library
                    </button>
                </form>
                
                <footer class="mt-8 pt-6 border-t border-gray-800 text-center">
                    <p class="text-gray-500 text-sm font-medium">
                        Don't have an account? 
                        <a href="register.php" class="text-custom-green font-bold hover:underline ml-1">Register now</a>
                    </p>
                </footer>
            </div>
        </div>
    </main>
</div>

<?php include 'footer.php'; ?>