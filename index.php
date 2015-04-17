<?php

require_once('database.php');

/**
  * Es mejor práctica usar el constructor try / catch cada vez
  * que interactuamos con nuestra base de datos.
 */
try {
  // PDO tiene un método para hacer consultas
  // Retorna un objeto de tipo PDOStatement
  $results = $pdo->query('SELECT * FROM film');
} catch (Exception $e) {
  echo $e->getMessage();
  die();
}

// Este objeto tiene un método fetchAll para traer todas las films
// Puede recibir varios argumentos, en este caso me traé un arreglo
$films = $results->fetchAll(PDO::FETCH_ASSOC);
//var_dump($films);
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
        </tr>
      </thead>
      <tbody>
      <?php foreach ($films as $film) : ?>
        <tr>
          <td><?php echo $film['film_id']; ?></td>
          <td><a href="films.php?id=<?php echo $film['film_id']; ?>"><?php echo $film['title']; ?></a></td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
