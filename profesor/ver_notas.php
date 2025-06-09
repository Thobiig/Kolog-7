<?php
session_start();
require '../includes/db.php';

if (!isset($_SESSION["usuario_id"]) || $_SESSION["rol"] !== 'profesor') {
    header("Location: ../login.php");
    exit;
}

if (!isset($_GET['curso_id'])) {
    echo "Curso no especificado.";
    exit;
}

$curso_id = intval($_GET['curso_id']);

// Obtener exámenes del curso
$stmt = $conn->prepare("
    SELECT r.id, u.nombre AS estudiante, e.titulo AS examen, r.nota
    FROM resultados r
    INNER JOIN usuarios u ON r.usuario_id = u.id
    INNER JOIN examenes e ON r.examen_id = e.id
    WHERE e.curso_id = ?
    ORDER BY u.nombre
");
$stmt->bind_param("i", $curso_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<h2>Notas de los estudiantes</h2>

<?php if ($result->num_rows === 0): ?>
    <p>No hay notas registradas todavía.</p>
<?php else: ?>
    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>Estudiante</th>
            <th>Examen</th>
            <th>Nota</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['estudiante']) ?></td>
                <td><?= htmlspecialchars($row['examen']) ?></td>
                <td><?= htmlspecialchars($row['nota']) ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
<?php endif; ?>

<a href="mis_cursos.php"><button type="">Regresar</button></a>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap');

* {
    font-family: 'Nunito', sans-serif;
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

body {
    background-color: #f5f7fa;
    padding: 40px 20px;
    display: flex;
    flex-direction: column;
    align-items: center;
    min-height: 100vh;
}

h2 {
    margin-bottom: 25px;
    color: #333;
    text-align: center;
    width: 100%;
    max-width: 700px;
}

p {
    color: #666;
    font-size: 16px;
    margin-bottom: 30px;
}

table {
    width: 100%;
    max-width: 700px;
    border-collapse: collapse;
    background: white;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    border-radius: 6px;
    overflow: hidden;
    margin-bottom: 30px;
}

th, td {
    padding: 12px 15px;
    text-align: left;
    border-bottom: 1px solid #ddd;
    color: #444;
    font-size: 15px;
}

th {
    background-color: #3498db;
    color: white;
    font-weight: 700;
}

tr:hover {
    background-color: #f1faff;
}

a button {
    background-color: #3498db;
    color: white;
    border: none;
    padding: 10px 22px;
    border-radius: 5px;
    cursor: pointer;
    font-weight: 700;
    font-size: 15px;
    transition: background-color 0.3s ease;
}

a button:hover {
    background-color: #217dbb;
}

</style>