<?php

require_once('database.php');

/**
 * Variables de la paginación
 */

// Límite de resultados de búsqueda.
$limit = 10;

// Número de página de $_GET
if ( isset( $_GET['p'] ) ) {
  $p = $_GET['p'];
} else {
  $p = 1;
}

// Variable para el query
$start = ($p-1) * $limit;

/**
 * Get Data
 */

/**
  * Es mejor práctica usar el constructor try / catch cada vez
  * que interactuamos con nuestra base de datos.
 */
try {
  // PDO tiene un método para hacer consultas
  // Retorna un objeto de tipo PDOStatement
  $results = $pdo->prepare('SELECT * FROM film ORDER BY film_id LIMIT :start, :limit');

  // Vincula el nombre de un valor en la consulta con su variable.
  $results->bindValue(':start', $start, PDO::PARAM_INT);
  $results->bindValue(':limit', $limit, PDO::PARAM_INT);

  // Ejecutar la consulta
  $results->execute();

} catch (Exception $e) {

  echo $e->getMessage();
  die();

}

// Obtener la cantidad de filas
try {
  $rows_query = $pdo->prepare('SELECT COUNT(film_id) FROM film');
  $rows_query->execute();
} catch (Exception $e) {
  echo $e->getMessage();
  die();
}

/**
 * Este objeto tiene un método fetchAll para traer todas las films
 * PDO:FETCH::ASSOC hace que retorne un arreglo con llaves asociativas
 * PDO:FETCH_NUM hace que solamente tiene enteros para las llaves
 */
$films = $results->fetchAll(PDO::FETCH_ASSOC);
$rowsCount = $rows_query->fetchColumn();
//var_dump($rows);
//var_dump($films);

/**
 * Listado de páginas
 */
$pagesTotal = (ceil( $rowsCount / $limit ));

$pagesLimit = ceil($p / $limit) * $limit;
$pagesStart = $pagesLimit - $limit + 1;

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
    <nav>
      <ul class="pagination">

        <li class="<?php echo ($pagesLimit <= $limit ? 'disabled' : ''); ?>">
          <a href="<?php echo ( $pagesStart > $limit  ? '?p=' . ($pagesStart - 1) : '' ); ?>" aria-label="Previous">
            <span aria-hidden="true">&laquo;</span>
          </a>
        </li>

        <?php for ($i = $pagesStart; $i <= $pagesLimit; $i++) : ?>
        <li class="<?php echo ($p == $i ? 'active' : ''); ?>"><a href="?p=<?php echo $i; ?>"><?php echo $i; ?> <span class="sr-only">(current)</span></a></li>
        <?php endfor; ?>

        <li class="<?php echo ($pagesLimit >= $pagesTotal ? 'disabled' : ''); ?>">
          <a href="<?php echo ($pagesLimit < $pagesTotal ? '?p=' . ($pagesLimit + 1): ''); ?>" aria-label="Next">
            <span aria-hidden="true">&raquo;</span>
          </a>
        </li>

      </ul>
    </nav>
  </div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
  <script>
    $('.pagination .disabled a, .pagination .active a').on('click', function(e) {
      e.preventDefault();
    });
  </script>
</body>
</html>
