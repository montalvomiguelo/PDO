<?php

if (isset($_GET['id'])) {
  $id = $_GET['id'];
}

require_once('database.php');

/**
  * Es mejor práctica usar el constructor try / catch cada vez
  * que interactuamos con nuestra base de datos.
 */
try {
  // PDO tiene un método para hacer consultas
  // Retorna un objeto de tipo PDOStatement
  $results = $pdo->query("SELECT * FROM film WHERE film_id = $id");
} catch (Exception $e) {
  echo $e->getMessage();
  die();
}

// Este objeto tiene un método fetch para traer un solo resultado
// Puede recibir varios argumentos, en este caso me traé un arreglo
$film = $results->fetch(PDO::FETCH_ASSOC);
//var_dump($film);
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Films</title>
  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
</head>
<body>
  <div class="container">
    <table class="table table-striped">
      <thead>
        <tr>
          <th>#</th>
          <th>Title</th>
          <th>Description</th>
          <th>Release year</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><?php echo $film['film_id']; ?></td>
          <td><?php echo $film['title']; ?></td>
          <td><?php echo $film['description']; ?></td>
          <td><?php echo $film['release_year']; ?></td>
        </tr>
      </tbody>
    </table>
  </div>
</body>
</html>
