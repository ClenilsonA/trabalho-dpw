<?php
// Inicia a sessão para gestão de utilizadores
session_start();
require_once 'db_config.php'; 

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recolhe e limpa os dados
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];

    // Validação de dados (Mensagens de erro em Inglês para o utilizador)
    if (empty($nome) || empty($email) || empty($senha)) {
        $error = "Please fill in all fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } elseif (strlen($senha) < 6) {
        $error = "The password must be at least 6 characters long.";
    } else {
        // Criptografar a senha (ESSENCIAL para segurança!)
        $senha_hashed = password_hash($senha, PASSWORD_DEFAULT);

        // 1. Verificar se o e-mail já existe
        $check_sql = "SELECT id FROM utilizadores WHERE email = ?";
        $stmt_check = $conn->prepare($check_sql);
        $stmt_check->bind_param("s", $email);
        $stmt_check->execute();
        $stmt_check->store_result();

        if ($stmt_check->num_rows > 0) {
            $error = "This email is already registered."; // Mensagem em Inglês
        } else {
            // 2. Inserir o novo utilizador
            $insert_sql = "INSERT INTO utilizadores (nome, email, senha) VALUES (?, ?, ?)";
            $stmt_insert = $conn->prepare($insert_sql);
            $stmt_insert->bind_param("sss", $nome, $email, $senha_hashed);
            
            if ($stmt_insert->execute()) {
                $success = "Registration successful! You can now log in."; // Mensagem em Inglês
            } else {
                // Erro de BD (Pode ser ajustado se necessário)
                $error = "Registration error: " . $conn->error;
            }
        }
        $stmt_check->close();
        if (isset($stmt_insert)) $stmt_insert->close();
    }
}
$conn->close();

include 'header.php'; 
include 'sidebar.php'; // Incluir a sidebar
?>
    <main class="px-4 py-4 md:py-6 bg-main-bg text-custom-light flex flex-col items-center justify-center">
        <div class="w-full max-w-md p-8 bg-sidebar-bg rounded-lg shadow-xl my-auto">
            <h2 class="text-3xl font-bold text-center mb-6 text-custom-green">Register New Account</h2>
            
            <?php if ($error): ?>
                <div class="bg-red-500 p-3 rounded mb-4 text-white"><?php echo $error; ?></div>
            <?php endif; ?>
            <?php if ($success): ?>
                <div class="bg-custom-green p-3 rounded mb-4 text-black font-semibold"><?php echo $success; ?></div>
            <?php endif; ?>

            <form action="register.php" method="POST">
                <div class="mb-4">
                    <label for="nome" class="block mb-2 font-medium">Name</label>
                    <input type="text" id="nome" name="nome" required class="w-full p-3 rounded bg-gray-700 text-custom-light border border-gray-600 focus:border-custom-green" value="<?php echo $_POST['nome'] ?? ''; ?>">
                </div>
                <div class="mb-4">
                    <label for="email" class="block mb-2 font-medium">Email</label>
                    <input type="email" id="email" name="email" required class="w-full p-3 rounded bg-gray-700 text-custom-light border border-gray-600 focus:border-custom-green" value="<?php echo $_POST['email'] ?? ''; ?>">
                </div>
                <div class="mb-6">
                    <label for="senha" class="block mb-2 font-medium">Password</label>
                    <input type="password" id="senha" name="senha" required class="w-full p-3 rounded bg-gray-700 text-custom-light border border-gray-600 focus:border-custom-green">
                </div>
                <button type="submit" class="w-full bg-custom-green text-black font-bold p-3 rounded-lg hover:bg-opacity-80 transition">Register</button>
            </form>
            
            <p class="mt-4 text-center text-gray-400">Already have an account? <a href="login.php" class="text-custom-green hover:underline">Log In</a></p>
        </div>
    </main>
<?php include 'footer.php'; ?>