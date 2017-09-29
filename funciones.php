<?php
	  //Convierte un string en numeros para calcular mejor la posicion (A = 1, B = 2, ...)
	  //Nota: solo admite caracteres ingleses.
	  function getCodeOfString($string){
		  $num = 0;
		  foreach(str_split($string) as $char){
			if($num > 0)
				$num *= 26;
			
			$num += ((int) ord($char)) - 64;
		  }
		return $num;
	  }
	  
	  //Convierte el codigo devuelta a string
	  function getStringOfCode($num){
		  $string = "";
		  while($num > 0){
			  $mod = ($num % 26);
			  if($mod == 0)
				  $mod = 26;
			  $char = chr($mod + 64);
			  $string = $char.$string;
			  $num-= $mod;
			  $num/=26;
		  }
		  return $string;
	  }

	//Obtener un array con la posicion pasada. ([0] = num, [1] = caracter)
      function getPosition($string){
        return explode("-", $string);
      }
	  //Obtener un array con el codigo de la posicion pasada. ([0] = num, [1] = caracter)
	  function getPositionCode($string){
		$positions = getPosition($string);
		$positions[0] = $positions[0];
		$positions[1] = getCodeOfString($positions[1]);
        return $positions;
      }
	  //Comprobar que la coordenada no se salga del tablero
      function comprobarQueNoSeSalga($string, $cantColumnaTablero, $cantFilaTablero){
        $posicion = getPositionCode($string);

        $numAscii = $posicion[0];
        $numMinAscii = 1;
        $numMaxAscii = $numMinAscii + $cantFilaTablero - 1;
        $charAscii = $posicion[1];
        $charMinAscii = getCodeOfString("A");
        $charMaxAscii = $charMinAscii + $cantColumnaTablero - 1;
		
        return ($numAscii >= $numMinAscii && $numAscii <= $numMaxAscii && $charAscii >= $charMinAscii && $charAscii <= $charMaxAscii);

      }
	  
	  //Devuelve false si el formato de las coordenadas son incorrectas,
	  //en caso contrario devuelve el formato correcto y ordenado (num-char).
	  //posibles formatos: 1b, b1, 1-b, b-1
	  function validarFormatoCoordenades($string){
		  $cadenas = str_split(strtoupper($string));
		  $finNumeros = false;
		  $finChar = false;
		  $num = "";
		  $char = "";
		  
		  foreach ($cadenas as $caracter){
			  if(is_numeric($caracter)){
				  if(!empty($char))
					  $finChar = true;
				  if(!$finNumeros)
					  $num .= $caracter;
				  else
					  return false;
			  }else{
				  if(!empty($num))
					  $finNumeros = true;
				  if($caracter != "-"){
					  if(!$finChar)
						  $char .= $caracter;
					  else
						  return false;
				  }
			  }
		  }
		  return $num."-".$char;
	  }
	  
	  //comprueba si el movimiento del rey es correcto
	  function validarMovimientoRey($nuevaPosicion){
		  $posicionActual = getPositionCode($_SESSION['rey_n']);
		  $nuevaPosicion = getPositionCode($nuevaPosicion);
		  $num1 = $posicionActual[0] - $nuevaPosicion[0];
		  $num2 = $posicionActual[1] - $nuevaPosicion[1];
		  if($num1 > -2 && $num1 < 2 && $num2 > -2 && $num2 < 2)
			  return true;
		  return false;
	  }
?>