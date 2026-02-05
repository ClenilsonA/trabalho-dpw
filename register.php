<?php
// register.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'db_config.php'; 

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];

    if (empty($nome) || empty($email) || empty($senha)) {
        $error = "Please fill in all fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } elseif (strlen($senha) < 6) {
        $error = "The password must be at least 6 characters long.";
    } else {
        $senha_hashed = password_hash($senha, PASSWORD_DEFAULT);

        $check_sql = "SELECT id FROM utilizadores WHERE email = ?";
        $stmt_check = $conn->prepare($check_sql);
        $stmt_check->bind_param("s", $email);
        $stmt_check->execute();
        $stmt_check->store_result();

        if ($stmt_check->num_rows > 0) {
            $error = "This email is already registered.";
        } else {
            $insert_sql = "INSERT INTO utilizadores (nome, email, senha) VALUES (?, ?, ?)";
            $stmt_insert = $conn->prepare($insert_sql);
            $stmt_insert->bind_param("sss", $nome, $email, $senha_hashed);
            
            if ($stmt_insert->execute()) {
                $success = "Registration successful! You can now log in.";
            } else {
                $error = "Registration error: " . $conn->error;
            }
        }
        $stmt_check->close();
        if (isset($stmt_insert)) $stmt_insert->close();
    }
}
$conn->close();

include 'header.php'; 
?>

<div class="flex w-full">

    <?php include 'sidebar.php'; ?>

    <main class="flex-1 min-w-0 bg-main-bg text-custom-light min-h-[calc(100vh-74px)] flex items-center justify-center p-4">
        
        <div class="w-full max-w-md p-8 bg-sidebar-bg rounded-2xl shadow-2xl border border-gray-800 relative overflow-hidden">
            
            <div class="absolute -bottom-10 -right-10 w-32 h-32 bg-custom-green/5 rounded-full blur-3xl"></div>
            
            <div class="relative z-10">
                <header class="text-center mb-8">
                    <h2 class="text-4xl font-black text-custom-green italic tracking-tighter uppercase">Join Us</h2>
                    <p class="text-gray-500 text-sm mt-2 font-medium">Create your library account today</p>
                </header>
                
                <?php if ($error): ?>
                    <div class="bg-red-500/10 border border-red-500 text-red-500 p-4 rounded-xl mb-6 text-sm font-bold flex items-center gap-2">
                        <span>⚠️</span> <?php echo $error; ?>
                    </div>
                <?php endif; ?>

                <?php if ($success): ?>
                    <div class="bg-custom-green/10 border border-custom-green text-custom-green p-4 rounded-xl mb-6 text-sm font-bold flex items-center gap-2">
                        <span>✅</span> <?php echo $success; ?>
                    </div>
                <?php endif; ?>

                <form action="register.php" method="POST" class="space-y-4">
                    <div>
                        <label for="nome" class="block mb-2 text-xs font-black uppercase tracking-widest text-gray-400">Full Name</label>
                        <input 
                            type="text" 
                            id="nome" 
                            name="nome" 
                            required 
                            placeholder="John Doe"
                            class="w-full p-4 rounded-xl bg-gray-800 text-custom-light border border-gray-700 focus:outline-none focus:border-custom-green focus:ring-1 focus:ring-custom-green transition-all"
                            value="<?php echo isset($_POST['nome']) ? htmlspecialchars($_POST['nome']) : ''; ?>"
                        >
                    </div>

                    <div>
                        <label for="email" class="block mb-2 text-xs font-black uppercase tracking-widest text-gray-400">Email Address</label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            required 
                            placeholder="example@email.com"
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
                            placeholder="At least 6 characters"
                            class="w-full p-4 rounded-xl bg-gray-800 text-custom-light border border-gray-700 focus:outline-none focus:border-custom-green focus:ring-1 focus:ring-custom-green transition-all"
                        >
                    </div>

                    <button type="submit" class="w-full mt-2 bg-custom-green text-black font-black p-4 rounded-xl hover:bg-green-400 hover:scale-[1.02] active:scale-95 transition-all shadow-[0_10px_20px_rgba(9,195,88,0.2)] uppercase tracking-widest text-sm">
                        Create Account
                    </button>
                </form>
                
                <footer class="mt-8 pt-6 border-t border-gray-800 text-center">
                    <p class="text-gray-500 text-sm font-medium">
                        Already have an account? 
                        <a href="login.php" class="text-custom-green font-bold hover:underline ml-1">Log In</a>
                    </p>
                </footer>
            </div>
        </div>
    </main>
</div>

<?php include 'footer.php'; ?>