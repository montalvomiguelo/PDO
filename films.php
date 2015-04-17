<?php

/**
  * Filter Input, Escape Output, nunca debemos de confiar en lo que el
  * usuario introduce a nuestras búsqueds. Pueden hacer SQL Injection
  * en la url y obtener información sensible y hacernos daño.
 */

if (isset($_GET['id'])) {
  // Asegurar que estamos obteniendo un valor numérico
  $id = intval( $_GET['id'] );
}

require_once('database.php');

/**
  * Es mejor práctica usar el constructor try / catch cada vez
  * que interactuamos con nuestra base de datos.
 */
try {
  /**
   * Preparamos nuestra consulta con el método prepare de PDO, solo la
   * prepara para despues ser ejecutada por excecute()
   * Vamos a utilizar un placeholder para poder despues procesar el $id
   * de la consulta
   */
  $results = $pdo->prepare("SELECT * FROM film WHERE film_id = ?");

  /**
   * Como estamos utilizando un placeholder, tenemos que obtener su
   * valor con el metodo bindParam, el primer argumento es el número
   * de placeholder y no es notación de arreglo, en segundo lugar
   * recibe el valor que va ser sustituido.
   */
  $results->bindParam(1, $id);

  /**
   * Por último ejecutamos la consulta. Esta si es una consulta segura
   * para prevenir SQL injection
   */
  $results->execute();
} catch (Exception $e) {
  echo $e->getMessage();
  die();
}

// Este objeto tiene un método fetch para traer un solo resultado
// Puede recibir varios argumentos, en este caso me traé un arreglo
$film = $results->fetch(PDO::FETCH_ASSOC);
// var_dump($film);
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
    <?php if ($film) : ?>
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
    <?php else: ?>
    <p class="text-danger">Nothing found with the provided id</p>
    <?php endif; ?>
  </div>
</body>
</html>
