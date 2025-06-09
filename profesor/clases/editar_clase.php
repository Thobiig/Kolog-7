<?php
session_start();
require '../../includes/db.php';

if ($_SESSION['rol'] !== 'profesor') {
    header("Location: ../../dashboard.php");
    exit;
}

if (!isset($_GET['id']) || !isset($_GET['curso_id'])) {
    echo "Clase o curso no especificado.";
    exit;
}

$clase_id = $_GET['id'];
$curso_id = $_GET['curso_id'];

$stmt = $conn->prepare("SELECT * FROM clases WHERE id = ?");
$stmt->bind_param("i", $clase_id);
$stmt->execute();
$resultado = $stmt->get_result();
$clase = $resultado->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $contenido = $_POST['contenido'];

    $stmt = $conn->prepare("UPDATE clases SET titulo = ?, contenido = ? WHERE id = ?");
    $stmt->bind_param("ssi", $titulo, $contenido, $clase_id);
    $stmt->execute();

    header("Location: ver_clases.php?curso_id=" . $curso_id);
    exit;
}
?>

<div>
    <h2>Editar clase</h2>

<form method="POST">
    <label>Título:</label><br>
    <input type="text" name="titulo" value="<?= htmlspecialchars($clase['titulo']) ?>" required><br><br>

    <label>Contenido:</label><br>
    <textarea name="contenido" rows="6" cols="50" required><?= htmlspecialchars($clase['contenido']) ?></textarea><br><br>

    <button type="submit">Guardar cambios</button>
    <a href="../mis_cursos.php"><button>Cancelar</button></a>
</form>
</div>

<style>
  /* Contenedor centrado con flexbox */
  div {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 40px 20px;
    min-height: 100vh;
    background: #f5f7fa;
    box-sizing: border-box;
  }

  h2 {
    margin-bottom: 30px;
    color: #333;
    text-align: center;
    width: 100%;
    max-width: 600px;
  }

  form {
    width: 100%;
    max-width: 600px;
    background: #f9f9f9;
    padding: 25px 30px;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    box-sizing: border-box;
  }

  label {
    font-weight: 600;
    display: block;
    margin-bottom: 6px;
    color: #444;
  }

  input[type="text"],
  textarea {
    width: 100%;
    padding: 10px;
    font-size: 15px;
    border: 1px solid #ccc;
    border-radius: 5px;
    resize: vertical;
    margin-bottom: 20px;
    box-sizing: border-box;
    font-family: inherit;
    color: #333;
    transition: border-color 0.3s ease;
  }

  input[type="text"]:focus,
  textarea:focus {
    border-color: #3498db;
    outline: none;
    box-shadow: 0 0 6px #a3c9f9;
  }

  button[type="submit"],
  form a > button {
    background-color: #3498db;
    color: white;
    border: none;
    padding: 10px 22px;
    border-radius: 5px;
    cursor: pointer;
    font-weight: 700;
    font-size: 15px;
    margin-right: 10px;
    transition: background-color 0.3s ease;
  }

  button[type="submit"]:hover,
  form a > button:hover {
    background-color: #217dbb;
  }

  form a > button {
    background-color: #888;
  }

  form a > button:hover {
    background-color: #555;
  }

  /* Para que el enlace con botón no se junte con submit */
  form a {
    text-decoration: none;
  }
</style>


