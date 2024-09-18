<!-- This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, 
either version 3 of the License, or (at your option) any later version.
This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
See the GNU General Public License for more details.
You should have received a copy of the GNU General Public License along with this program. If not, see <https://www.gnu.org/licenses/>.  -->

<!DOCTYPE html>
<html lang="es">
<head>
	<title>Los planitos</title>
  <link rel="icon" type="image/x-icon" href="favicon.ico">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="description" content='Archivo de "los planitos" publicados en la revista Lúpin'>
  <meta name="keywords" content="Planos, Planitos, Aeromodelismo, Revista Lúpin, Maquetas, Barriletes, Electrónica, Computación, Archivo, Scoutismo, Radio Control, 
  U Control, Globos, Ciclismo, Fotografía, Astronomía">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/custom.css">
  <link rel="stylesheet" href="css/custom-lupin.css">
</head>

<body>
<!-- Titulo y descripcion-->
<div id="cuerpo" class="container-md pt-5">
  <a href="https://www.losplanitos.com.ar/" class="text-reset text-decoration-none home">
    <img id='tira' src='./tira-amarilla.gif'>
  </a>
  <header class="px-3">
  <a href="https://www.losplanitos.com.ar/" class="text-reset text-decoration-none home">
  <?php
    $colorArr = array("#dfd158", "#209cbe", "#2a6994", "#ea523d", "#507448", "#a63b52", "#d17539");
    $color = array_rand($colorArr, 1);
      echo "<img class='logo' style='background-color:", $colorArr[$color] ,";' src='./logo-lupin.svg' alt='lupin'>"
  ?>
      <h5 class="text-end fw-bold">LOS PLANITOS</h5>
    </a>
    <p class="text-center fw-light">Un archivo de "los planitos" publicados en la <a class="link-opacity-50-hover ms-1 link-dark" title="Revista Lúpin en AHiRA" href="https://ahira.com.ar/revistas/lupin/" target="_blank"><b>Revista Lúpin</b></a></p>
  </header>

<!-- Formulario busqueda -->
  <search class="px-3 pt-5">
    <form name="formlink" method="GET" class="form-inline" action="index.php" id="busqueda">
      <div class="input-group">
        <input type="text" class="form-control" name="query" placeholder="Buscar planito" required autofocus>
        <!-- <input class="btn btn-dark" type="submit" value="&hearts;"> -->
         <button type="submit" class="btn btn-dark"><div>&#9906;</div></button>
      </div>
    </form>
  </search>

<!-- Categorías -->
  <div class="px-3 pt-4 text-center">
  <form name="categorias" method="GET" action="index.php" id="categorias">
    <button type="submit" name="cat" value="MAQ" class="btn btn-link btn-sm">Maquetas</button>
    <button type="submit" name="cat" value="BAR" class="btn btn-link btn-sm">Barriletes</button>
    <button type="submit" name="cat" value="MG" class="btn btn-link btn-sm">Motor a Goma</button>
    <button type="submit" name="cat" value="MGI" class="btn btn-link btn-sm">Motor a Goma Interior</button>
    <button type="submit" name="cat" value="PL" class="btn btn-link btn-sm">Planeadores</button>
    <button type="submit" name="cat" value="PLC" class="btn btn-link btn-sm">Planeadores Cartulina</button>
    <button type="submit" name="cat" value="ANC" class="btn btn-link btn-sm">Aeromodelos no Convencionales</button>
    <button type="submit" name="cat" value="ARV" class="btn btn-link btn-sm">Artefacto Volador</button>
    <button type="submit" name="cat" value="RC" class="btn btn-link btn-sm">Radio Control</button>
    <button type="submit" name="cat" value="UC" class="btn btn-link btn-sm">U-Control</button>
    <button type="submit" name="cat" value="TA" class="btn btn-link btn-sm">Trucos Aeromodelismo</button>
    <button type="submit" name="cat" value="CHT" class="btn btn-link btn-sm">Cohetes</button>
    <button type="submit" name="cat" value="GL" class="btn btn-link btn-sm">Globos</button>
    <button type="submit" name="cat" value="BT" class="btn btn-link btn-sm">Botes</button>
    <button type="submit" name="cat" value="COM" class="btn btn-link btn-sm">Computación</button>
    <button type="submit" name="cat" value="ELC" class="btn btn-link btn-sm">Electrónica</button>
    <button type="submit" name="cat" value="CIC" class="btn btn-link btn-sm">Ciclismo</button>
    <button type="submit" name="cat" value="FOT" class="btn btn-link btn-sm">Fotografía</button>
    <button type="submit" name="cat" value="AST" class="btn btn-link btn-sm">Astronomía</button>
    <button type="submit" name="cat" value="SCT" class="btn btn-link btn-sm">Scoutismo</button>
    <button type="submit" name="cat" value="DIB" class="btn btn-link btn-sm">Dibujo</button>
    <button type="submit" name="cat" value="OTR" class="btn btn-link btn-sm">Otros</button>
    <button type="submit" name="cat" value="RIN" class="btn btn-link btn-sm">Rincón Lectores</button>
  </form>
  </div>

<!-- Resultados -->
  <main class="px-3 pt-5 d-flex flex-column align-self-center">
      
<?php

require_once 'paginador.class.php';

//Límite de resultados por página
$limit = 10;

function getQuery($q) : string {

  $input = preg_replace("/[^a-z0-9\'\&]+/i", " ", $q);
  $inputa = explode(' ', $input);

  /* if (strlen($input) > 3 ) { */

    if (count($inputa) > 1) {

      $s1 = "";

      foreach ($inputa as $word) {

        
        $s1 .= "[[:print:]]*" . $word;

      }

      $s = "/" . $s1 . "/iu";
      
      return $s;

    } else {

      return "/". $inputa[0] . "/iu";

    }
    
 /*  } else {
  
    $s = "/^\b". $input . "\b/i";
    return $s;
  
  }*/
}

function getName($n) : string {
  
  $name = str_replace([".jpg"], "", $n);
  /*  = str_replace(".", " ", $rmext); */
  return $name;

}

function searchQuery($search, $file) : bool {

  $plan = getName($file->name);

  if (preg_match($search, $plan)) {

    return true;

  } 

  return false;

}

if($_GET) {

  //Se guarda lo ingresado en la búsqueda(log)
  $queryString = date(DATE_RFC1123) . " " . $_GET["query"] . "\n";
  $logQueryFile = "/busquedas-log.txt";
  file_put_contents(__DIR__ . $logQueryFile, $queryString , FILE_APPEND);
  
  $Paginador  = new Paginador( $_GET, $limit );
  $links = $Paginador->getData();

  foreach ($links as $link) {
    
    echo $link;

  }

  echo $Paginador->pagLinks();

}
?>
</main>

  <footer class="px-3 pt-5">
      <div class="border-top text-center">
        <p class="fs-6 fw-light"><b>¿Problemas?</b> <a class="link-opacity-50-hover ms-1 link-dark" href="https://github.com/esaracho/planitos-lupin/issues" target="_blank">GitHub</a><a class="link-opacity-50-hover ms-2 link-dark" href="mailto:losplanitos@proton.me">eMail</a></p>
        <p class="fs-6 fw-light">Algunos planitos fueron extraidos del blog <a class="link-opacity-50-hover ms-1 link-dark" href="https://losplanitosdelupin.wordpress.com/" target="_blank">Los planitos de Lúpin</a></p>
        <p class="fs-6 fw-light">Planitos incluidos en los números: 100-105 / 150-155 / 200-211 / 220-259 / 300-305 / 349-355</p>
        <p class="fs-6 fw-light">Dedicado con &#10084; a G.D.S. y a todos los que colaboraron.</p>
        <img class="fondo" src="./fin.jpg">
      </div>
  </footer>
</div>
</body>

</html>