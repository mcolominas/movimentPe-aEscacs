<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
    <style>
    td{
      height: 50px;
      width: 50px;
    }
    table{
      text-align: center;
      border-collapse: collapse;
    }
    </style>
  </head>
  <body>

    <?php
      session_start();
      $cantFilaTablero = 8;
      $cantColumnaTablero = 8;
	  
	  include "funciones.php";
		
    if($_SERVER['REQUEST_METHOD'] == 'POST') { //Cuando se recibe las coordenades
      $coordenades = validarFormatoCoordenades($_POST['coordenades']);
      if($coordenades != false){
        if(comprobarQueNoSeSalga($coordenades, $cantColumnaTablero, $cantFilaTablero)){
          if(validarMovimientoRey($_SESSION['rey_n'], $coordenades)){
            $_SESSION['rey_n'] = $coordenades;
          }else{
            $_SESSION['mensajeError'] = "<h3>Movimiento no permitido.</h3>";
          }
        }else{
          $_SESSION['mensajeError'] = "<h3>Coordenades incorrectas.</h3>";
        }
      }else{
        $_SESSION['mensajeError'] = "<h3>Formato incorrecto.</h3>";
      }
      header("Location: index.php");
    }else{
      if(empty($_SESSION['rey_n']))
        $_SESSION['rey_n'] = "1-E";
      else
        if(!comprobarQueNoSeSalga($_SESSION['rey_n'], $cantColumnaTablero, $cantFilaTablero))
          $_SESSION['rey_n'] = "1-E";

      if(isset($_SESSION['mensajeError'])){
        echo $_SESSION['mensajeError'];
        unset($_SESSION['mensajeError']);
      }

      //creacion tabla y su contenido
      echo "<table>";
      for($fila = $cantFilaTablero+1; $fila >= 0; $fila --){
        echo "<tr>";
        for($columna = 0; $columna < $cantColumnaTablero+2; $columna ++){
          $columna_actual = getStringOfCode($columna);
          //esquinas
          if($fila == 0 && $columna == 0 || $fila == $cantFilaTablero+1 && $columna == $cantColumnaTablero+1  || $fila == 0 && $columna == $cantColumnaTablero+1  || $fila == $cantFilaTablero+1 && $columna == 0)
           echo "<td></td>";
          //arriba y abajo
          else if($fila == 0 || $fila == $cantFilaTablero+1)
            echo "<td>$columna_actual</td>";
          //derecha y izquierda
          else if($columna == 0 || $columna == $cantColumnaTablero+1)
            echo "<td>$fila</td>";
          //contenido ajedrez
          else{
            if(($fila + $columna) % 2 == 1)
              echo "<td style='background-color: white; color: black; border: 1px solid black;'>";
            else
              echo "<td style='background-color: black; color:white; border: 1px solid black;'>";

            $posicion = getPosition($_SESSION['rey_n']);
            if($posicion[1] == $columna_actual && $posicion[0] == $fila)
              echo 'rey';

            echo "</td>";
          }
        }
        echo "</tr>";
      }
      echo "</table>";
    }
    ?>
    <form method="post" action="">
      <input type="text" name="coordenades" autofocus>
      <input type="submit" name="enviar">
    </form>
  </body>
</html>
