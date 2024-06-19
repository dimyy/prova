<?php
session_start();
include '../config.php';

// Verificar se há uma sessão válida de professor/administrador
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] != 'professor' && $_SESSION['role'] != 'admin')) {
    header("Location: ../login.php");
    exit();
}

// Recuperar o ID da turma da URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "ID da turma não especificado.";
    exit();
}

$turma_id = $_GET['id'];

// Consulta para obter informações da turma
$sql_turma = "SELECT classes.name AS turma, courses.name AS curso, users.name AS professor
              FROM classes
              INNER JOIN users ON classes.professor_id = users.id
              INNER JOIN enrollments ON enrollments.class_id = classes.id
              INNER JOIN users AS students ON enrollments.student_id = students.id
              INNER JOIN courses ON classes.id = courses.id
              WHERE classes.id = $turma_id";
$result_turma = $conn->query($sql_turma);

if (!$result_turma || $result_turma->num_rows == 0) {
    echo "Turma não encontrada.";
    exit();
}

$turma = $result_turma->fetch_assoc();

// Consulta para obter lista de alunos matriculados na turma
$sql_alunos = "SELECT students.name AS aluno
               FROM enrollments
               INNER JOIN users AS students ON enrollments.student_id = students.id
               WHERE enrollments.class_id = $turma_id";
$result_alunos = $conn->query($sql_alunos);

$alunos = [];
if ($result_alunos->num_rows > 0) {
    while ($row = $result_alunos->fetch_assoc()) {
        $alunos[] = $row['aluno'];
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Visualizar Turma</title>
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
</head>
<body>
    <div class="container">
        <h2>Visualizar Turma</h2>
        <p><strong>Curso:</strong> <?php echo $turma['curso']; ?></p>
        <p><strong>Turma:</strong> <?php echo $turma['turma']; ?></p>
        <p><strong>Professor:</strong> <?php echo $turma['professor']; ?></p>

        <h3>Alunos Matriculados</h3>
        <ul>
            <?php foreach ($alunos as $aluno) : ?>
                <li><?php echo $aluno; ?></li>
            <?php endforeach; ?>
        </ul>

        <a href="index.php">Voltar</a>
    </div>
</body>
</html>
