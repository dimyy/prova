<?php
session_start();
include '../config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'professor') {
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
    <title>Painel do Professor</title>
</head>
<body>
    <div class="container">
        <h2>Painel do Professor</h2>
        <p>Bem-vindo, Professor!</p>
        <a href="cadastrar_turma.php">Cadastrar Turma</a><br>
        <a href="atividades.php">Mostrar Atividades</a><br>
        <a href="turmas_excluir.php">Excluir Turma</a><br>
        <a href="adicionar_notas.php">Adicionar Notas</a><br>
        <a href="../logout.php">Sair</a>
    </div>
</body>
</html>
