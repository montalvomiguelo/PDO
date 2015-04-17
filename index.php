<?php
/**
* PDO php, data, object es una manera que ofrece php para
* interactuar con bases de datos de una manera sencilla.
*
* Necesitamos el controlador adecuado para nuestra base de datos en
* este caso mysql
 */

// Mostrar errores (remove befor flight)
ini_set('display_errors', true);
error_reporting(E_ALL);

/**
  * Manejo de Errores, es muy importante manejar errores en nuestra aplicación
  * para hacer eso hacemos un try catch block
  * try / catch es el constructor de php que utilizamos para el manejo de errores.
 */
try { // Si la creación de mi PDO Object es exitosa entonces esto:
  // Instancia del objeto PDO.
  $pdo = new PDO(
    'mysql:host=localhost;dbname=sakila',
    'root',
    'root'
  );
  var_dump($pdo);

  /**
   * PDO object tiene tambíen varios métodos y propiedades, en este
   * usaremos una de ellas para establecer que siempre nos motrará
   * errores e información de lo que pase en nuestra aplicación
   * con el manejo de este objecto.
   */

  $pdo->setAttribute('PDO::ATTR_ERRMODE', 'PDO::ERRMODE_EXCEPTION');

} catch(Exception $e) { // Si hubo algun error entonces esto:
  /**
    * La clase Exception tiene varios métodos y propiedades que nos dan
    * más información de lo que pasó... por que sucedio el error
   */
  //var_dump($e);
  echo $e->getMessage();
  die();
}

