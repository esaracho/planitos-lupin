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
  <meta name="keywords" content="Planos, Planitos, Aeromodelismo, Revista Lúpin, Maquetas, Barriletes, Electrónica, Computación, Archivo">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/custom.css">
  <link rel="stylesheet" href="css/custom-lupin.css">
</head>

<body>
<!-- Titulo y descripcion-->
  <header class="container-md mt-5">
  <a href="https://www.losplanitos.com.ar/" class="text-reset text-decoration-none home">
  <?php
    $colorArr = array("#ffdb39", "#209cbe", "#2a6994", "#ea523d", "#507448", "#a63b52", "#d17539");
    $color = array_rand($colorArr, 1);
      echo "<img class='logo' style='background-color:", $colorArr[$color] ,";' src='./logo-lupin.svg' alt='lupin'>"
  ?>
      <h5 class="text-end fw-bold">LOS PLANITOS</h5>
    </a>
    <p class="text-center fw-light">Un archivo de "los planitos" publicados en la <a class="link-opacity-50-hover ms-1 link-dark" title="Revista Lúpin en AHiRA" href="https://ahira.com.ar/revistas/lupin/" target="_blank"><b>Revista Lúpin</b></a></p>
    <p class="text-center novedades">Novedades: Se agregó lo publicado en los números 300 a 305 y 349. Quedan en revisión dos planos de los números 300 y 303.</p>
  </header>

<!-- Formulario busqueda -->
  <search class="container-md mt-5">
    <form name="formlink" method="post" class="form-inline" action="index.php" id="busqueda">
      <div class="input-group">
        <input type="text" class="form-control" name="query" placeholder="Buscar planito" required autofocus>
        <input class="btn btn-dark" type="submit" name="Submit" value="&hearts;">
      </div>
    </form>
  </search>

<!-- Categorías -->
  <div class="container-md mt-4 text-center">
  <form name="categorias" method="post" action="index.php" id="categorias">
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
    <button type="submit" name="cat" value="OTR" class="btn btn-link btn-sm">Otros</button>
    <button type="submit" name="cat" value="RIN" class="btn btn-link btn-sm">Rincón Lectores</button>
  </form>
  </div>

<!-- Resultados -->
  <main class="container-md mt-5 d-flex flex-column align-self-center">
      
<?php

function getQuery($q) : string {

  $input = preg_replace("/[^a-z0-9\'\&]+/i", " ", $q);
  $inputa = explode(' ', $input);

  /* if (strlen($input) > 3 ) { */

    if (count($inputa) > 1) {

      $s1 = "";

      foreach ($inputa as $word) {

        
        $s1 .= "[[:print:]]*" . $word;

      }

      $s = "/" . $s1 . "/i";
      
      return $s;

    } else {

      return "/". $inputa[0] . "/i";

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

if ($_SERVER["REQUEST_METHOD"] === "POST") {
 
  if (array_key_exists("cat", $_POST)) {

    $path = "db/" . $_POST["cat"] . ".json";
    $data = file_get_contents($path);
    $json = json_decode($data);
    $dir = [...$json[0]->contents];
    

    foreach ($dir as $file) {
    
      $thumbnail = str_replace([".jpg"], "-mini.jpg", $file->name);
      echo "<a class='linkimg mb-3 mx-auto' href='planitos/", $file->name ,"' download><img class='img-thumbnail img-fluid mx-auto d-block' src='mini/", $thumbnail ,"'><div class='overlay'><span>&darr;</span></div></a>";

    }


  } elseif (array_key_exists("query", $_POST)) {

      $search = getQuery($_POST["query"]);
      $data = file_get_contents("db/ALL.json");
      $json = json_decode($data);
      $dir = [...$json[0]->contents];
      
      foreach ($dir as $file) {

        if (searchQuery($search, $file)) {

          $thumbnail = str_replace([".jpg"], "-mini.jpg", $file->name);
          echo "<a class='linkimg mb-3 mx-auto' href='planitos/", $file->name ,"' download><img class='img-thumbnail img-fluid d-block' src='mini/", $thumbnail ,"'><div class='overlay'><span>&darr;</span></div></a>";
  
        }
      }

  }
  

}
?>
</main>

  <footer class="container-md mt-5">
      <div class="border-top text-center">
        <p class="fs-6 fw-light"><b>¿Problemas?</b> <a class="link-opacity-50-hover ms-1 link-dark" href="https://github.com/esaracho/planitos-lupin/issues" target="_blank">GitHub</a><a class="link-opacity-50-hover ms-2 link-dark" href="mailto:losplanitos@proton.me">eMail</a></p>
        <p class="fs-6 fw-light">Para <b>colaborar</b>, enviar el planito con número de Lúpin y en buena calidad a <a class="link-opacity-50-hover ms-1 link-dark" href="mailto:losplanitos@proton.me">eMail</a></p>
        <p class="fs-6 fw-light">Algunos planitos fueron extraidos del blog <a class="link-opacity-50-hover ms-1 link-dark" href="https://losplanitosdelupin.wordpress.com/" target="_blank">Los planitos de Lúpin</a></p>
        <p class="fs-6 fw-light">Dedicado con &#10084; a G.D.S. y a todos los que colaboraron.</p>
        <?php
          $cuadrito = rand(1, 7);
          echo "<img class='fondo' src='fondo/", $cuadrito,".jpg' >"
        ?>
    </div>
  </footer>

</body>

</html>