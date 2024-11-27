<?php
session_start();


if (!isset($_SESSION['email'])) {
    header("Location: ../paginas_cadastros/login.php");
    exit();
}


include('../conexao/teste_conexao.php'); 


$email = $_SESSION['email'];

$query = "SELECT nome, email, cpf FROM pessoa WHERE email = ?";
$stmt = $mysqli->prepare($query);

if ($stmt === false) {
    die("Erro na preparação da consulta: " . $mysqli->error);
}

$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $nome = $user['nome'];
    $cpf = $user['cpf'];
} else {
    header("Location: ../paginas_iniciais/start.php");
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $novo_nome = $_POST['nome'];
    $novo_email = $_POST['email'];
    $novo_cpf = $_POST['cpf'];
    $nova_senha = $_POST['senha'];

    
    $update_query = "UPDATE pessoa SET nome = ?, email = ?, cpf = ?, senha = ? WHERE email = ?";
    $update_stmt = $mysqli->prepare($update_query);
    
    
    $update_stmt->bind_param("sssss", $novo_nome, $novo_email, $novo_cpf, $nova_senha, $email);
    $update_stmt->execute();

    
    $_SESSION['email'] = $novo_email;

    
    header("Location: perfil.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Frog Tech - Alterar Informações</title>
    <link rel="stylesheet" href="../css/Alterar_INFO.css">
</head>
<body>

<header>
    <div class="logo">
        <img src="../img/logo2.png" alt="Frog Tech Logo">
    </div>
    <div class="menu">
        <div class="menu-icon" id="menuIcon">
            <div class="bar"></div>
            <div class="bar"></div>
            <div class="bar"></div>
        </div>
    </div>
</header>


<div class="overlay" id="overlay"></div>

<div class="sidebar" id="sidebarMenu">
    <ul>
    <li><a href="../Loja/carrinho.php">Carrinho de Compras</a></li>
    <li><a href="../paginas_cadastros/perfil.php">Voltar para Perfil</a></li>
    <li><a href="../paginas_iniciais/paginahome.php">Pagina-Home</a></li>
    <li><a href="../Loja/loja.php">Loja</a></li>
    <li><a href="../paginas_cadastros/logout.php" class="logout">Sair</a></li>
    </ul>
</div>

<div class="container">
    
    <div class="form-container">
        <h2>Altere suas informações pessoais</h2>
        <form method="POST" action="">
            <label for="nome">Nome:</label>
            <input type="text" name="nome" value="<?php  ?>" required>
            <br>
            <label for="email">Novo Email:</label>
            <input type="email" name="email" value="<?php  ?>" required>
            <br>
            <label for="cpf">Novo CPF:</label>
            <input type="text" name="cpf" value="<?php  ?>" required>
            <br>
            <label for="senha">Nova Senha:</label>
            <input type="text" name="senha" required> 
            <br>
            <button type="submit">Salvar Alterações</button>
        </form>
    </div>
</div>

<footer class="footer">
    <p>© 2024 Frog Tech - Todos os direitos reservados</p>
</footer>

<script src="../js/Script.js"></script>

</body>
</html>
