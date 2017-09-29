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

      $cantColumnaTablero = 8;
      $cantFilaTablero = 8;


      if($_SERVER['REQUEST_METHOD'] == 'POST') {
         //Processar les dades
         $coordenades = $_POST['coordenades'];
         if(comprobarQueNoSeSalga($coordenades, $cantFilaTablero, $cantColumnaTablero))
          $_SESSION['rey_n'] = $coordenades;
          else
          echo "<h3>coordenades incorrectas.</h3>";
      } else {
         //Pintar el formulari
        $_SESSION['rey_n'] = "5-B";
      }
      echo "<table>";
      for($columna = $cantColumnaTablero+1; $columna >= 0; $columna --){
        echo "<tr>";
        for($fila = 0; $fila < $cantFilaTablero+2; $fila ++){
          $columna_actual = chr(64+$fila);
          //esquinas
          if($columna == 0 && $fila == 0 || $columna == $cantColumnaTablero+1 && $fila == $cantFilaTablero+1  || $columna == 0 && $fila == $cantFilaTablero+1  || $columna == $cantColumnaTablero+1 && $fila == 0)
            echo "<td></td>";
          //arriba y abajo
          else if($columna == 0 || $columna == $cantColumnaTablero+1){
            echo "<td>$columna_actual</td>";
          }
          //derecha y izquierda
          else if($fila == 0 || $fila == $cantFilaTablero+1)
            echo "<td>$columna</td>";
          //contenido ajedrez
          else{
            if(($columna + $fila) % 2 == 1)
              echo "<td style='background-color: white; color: black; border: 1px solid black;'>";
            else
              echo "<td style='background-color: black; color:white; border: 1px solid black;'>";
            
            $posicion = getPosition($_SESSION['rey_n']);
            if($posicion[1] == $columna_actual && $posicion[0] == $columna)
              echo 'rey';

            echo "</td>";
          }
        }
        echo "</tr>";
      }
      echo "</table>";

      function getPosition($string){
        return explode("-", $string);
      }
      function comprobarQueNoSeSalga($string, $cantFilaTablero, $cantColumnaTablero){
        str_split($string);

        $posicion = getPosition($string);

        $numAscii = ord($posicion[0]);
        $numMinAscii = ord("1");
        $numMaxAscii = $numMinAscii + $cantFilaTablero - 1;
        $charAscii = ord($posicion[1]);
        $charMinAscii = ord("A");
        $charMaxAscii = $charMinAscii + $cantColumnaTablero - 1;
        if($numAscii >= $numMinAscii && $numAscii <= $numMinAscii && $charAscii >= $charMinAscii && $charAscii <= $charMaxAscii)
          return true;
        else
          return false;

      }
    ?>
    <form method="post" action="">
      <input type="text" name="coordenades">
      <input type="submit" name="enviar">
    </form>
  </body>
</html>
