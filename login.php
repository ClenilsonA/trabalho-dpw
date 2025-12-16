<?php
session_start();
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
        $error = "Please fill in all fields."; // Mensagem em Inglês
    } else {
        // 1. Procurar o utilizador pelo e-mail
        $sql = "SELECT id, nome, senha FROM utilizadores WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            
            // 2. Verificar a password hash (Função crítica de segurança!)
            if (password_verify($senha, $user['senha'])) {
                // Login bem-sucedido. Inicia a sessão.
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['nome'];
                
                // Redireciona para a home page após o login
                header("Location: index.php");
                exit;
            } else {
                $error = "Incorrect email or password."; // Mensagem em Inglês
            }
        } else {
            $error = "Incorrect email or password."; // Mensagem em Inglês
        }
        $stmt->close();
    }
}
$conn->close();

include 'header.php'; 
include 'sidebar.php'; // Incluir a sidebar
?>
    <main class="px-4 py-4 md:py-6 bg-main-bg text-custom-light flex flex-col items-center justify-center">
        <div class="w-full max-w-md p-8 bg-sidebar-bg rounded-lg shadow-xl my-auto">
            <h2 class="text-3xl font-bold text-center mb-6 text-custom-green">Log In</h2>
            
            <?php if ($error): ?>
                <div class="bg-red-500 p-3 rounded mb-4 text-white"><?php echo $error; ?></div>
            <?php endif; ?>

            <form action="login.php" method="POST">
                <div class="mb-4">
                    <label for="email" class="block mb-2 font-medium">Email</label>
                    <input type="email" id="email" name="email" required class="w-full p-3 rounded bg-gray-700 text-custom-light border border-gray-600 focus:border-custom-green" value="<?php echo $_POST['email'] ?? ''; ?>">
                </div>
                <div class="mb-6">
                    <label for="senha" class="block mb-2 font-medium">Password</label>
                    <input type="password" id="senha" name="senha" required class="w-full p-3 rounded bg-gray-700 text-custom-light border border-gray-600 focus:border-custom-green">
                </div>
                <button type="submit" class="w-full bg-custom-green text-black font-bold p-3 rounded-lg hover:bg-opacity-80 transition">Log In</button>
            </form>
            
            <p class="mt-4 text-center text-gray-400">Don't have an account? <a href="register.php" class="text-custom-green hover:underline">Register</a></p>
        </div>
    </main>
<?php include 'footer.php'; ?>