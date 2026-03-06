<?php



class Paginador {

    private $_limit;
    private $_page;
    private $_total;
    private $_query;
    private $_cat;
    private $_start;
    private $_end;

    public function __construct( $get, $limit ) {

        $this->_limit = $limit;
        $this->_page = ( isset( $get['page'] ) ) ? $get['page'] : 1;
        $this->_total = ( isset( $get['total'] ) ) ? $get['total'] : NULL;
        $this->_query = ( isset( $get['query'] ) ) ? $get['query'] : NULL;
        $this->_cat = ( isset( $get['cat'] ) ) ? $get['cat'] : NULL;
        $this->_start = ( $this->_page -1 ) * $this->_limit;
        $this->_end = ( $this->_page * $this->_limit );
    }


  private function getTitle($file) {

    //inicio del nombre del fichero
    //$patterns[0] = '/[[:upper:]]+-num-[[:digit:]]+-/';
    //fin del nombre del archivo
    $patterns[0] = '/(-[[:digit:]])?.jpg/';
    //$replacements[0] = '';
    $replacements[0] = '';

    return preg_replace($patterns, $replacements, $file);

  }


  private function getQuery($q) : string {

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

  private function getName($n) : string {
  
    $name = str_replace([".jpg"], "", $n);
    /*  = str_replace(".", " ", $rmext); */
    return $name;

}

  private function searchQuery($search, $file) : bool {

    $plan = $this->getName($file->name);

      if (preg_match($search, $plan)) {

        return true;

      }

        return false;

  }


    public function getData() {
        
        
        //Busqueda por categoria
        if (!empty($this->_cat)) {

            $path = "db/" . $this->_cat . ".json";
            $data = file_get_contents($path);
            $json = json_decode($data);
            $dir = [...$json[0]->contents];
            $results = [];

            if (is_null($this->_total)) {

              $repeatsitself = $this->getTitle($dir[0]->name);
              $count = 0;

              foreach ($dir as $file) {
                
                $fileTitle = $this->getTitle($file->name);
                

                if ( $fileTitle !== $repeatsitself ) {
                  
                  $results[] = "<div class='card mx-auto'>" . implode($group) . "<button class='hijo dl' type='submit' form='descarga' name='files' value='" . implode(",", $files) . "'><span class='dl-icon'></span></button></div>";
                  $files = [];
                  $group = [];
                  
                }

                $thumbnail = str_replace([".jpg"], "-mini.jpg", $file->name);
                /* $link = "<a class='linkimg mb-3 mx-auto' href='planitos/". $file->name ."' download><img class='img-thumbnail img-fluid mx-auto d-block' src='mini/". $thumbnail ."'><div class='overlay'><span>&darr;</span></div></a>";
                $results[] = $link; */
                $files[]=$file->name;
                $group[] = "<img class='hijo' src='mini/" . $thumbnail . "' >";
                $repeatsitself = $fileTitle;
                ++$count;
                
                if ($count == sizeof($dir)) {

                  $results[] = "<div class='card mx-auto'>" . implode($group) . "<button class='hijo dl' type='submit' form='descarga' name='files' value='" . implode(",", $files) . "'><span class='dl-icon'></span></button></div>";
                  
                }                

              }

              $this->_total = sizeof($results);
              return array_slice($results, $this->_start, $this->_limit);

           } else {

              $repeatsitself = $this->getTitle($dir[0]->name);
              $count = 0;

              foreach ($dir as $file) {

              $fileTitle = $this->getTitle($file->name);
                

              if ( $fileTitle !== $repeatsitself ) {
                  
                $results[] = "<div class='card mx-auto'>" . implode($group) . "<button class='hijo dl' type='submit' form='descarga' name='files' value='" . implode(",", $files) . "'><span class='dl-icon'></span></button></div>";
                $files = [];
                $group = [];
                $count++;
                
                if ($count == $this->_end) {

                  //$results[] = "<div class='card mx-auto'>" . implode($group) . "<button class='hijo dl'>descargar</button></div>";
                  return array_slice($results, $this->_start);

                }
              }
                
              $thumbnail = str_replace([".jpg"], "-mini.jpg", $file->name);
              /* $link = "<a class='linkimg mb-3 mx-auto' href='planitos/". $file->name ."' download><img class='img-thumbnail img-fluid mx-auto d-block' src='mini/". $thumbnail ."'><div class='overlay'><span>&darr;</span></div></a>";
              $results[] = $link; */
              $files[]=$file->name;
              $group[] = "<img class='hijo' src='mini/" . $thumbnail . "' >";
              $repeatsitself = $fileTitle;
            
            }
            
            $results[] = "<div class='card mx-auto'>" . implode($group) . "<button class='hijo dl' type='submit' form='descarga' name='files' value='" . implode(",", $files) . "'><span class='dl-icon'></span></button></div>";
            return array_slice($results, $this->_start);

          }
          
          //Busqueda por palabras
          } elseif (!empty($this->_query)) {


              $search = $this->getQuery($this->_query);
              $data = file_get_contents("db/ALL.json");
              $json = json_decode($data);
              $dir = [...$json[0]->contents];
              $noResults = true;
              $count = 0;

              if (is_null($this->_total)) {

                
              
                foreach ($dir as $file) {

                
        
                if ($this->searchQuery($search, $file)) {
                  
                  if ($noResults){
                    $noResults = false;
                    $repeatsitself = $this->getTitle($file->name);
                  }
                  
                  $fileTitle = $this->getTitle($file->name);                                  
                  
                  if ( $fileTitle !== $repeatsitself ) {
                  
                  $results[] = "<div class='card mx-auto'>" . implode($group) . "<button class='hijo dl' type='submit' form='descarga' name='files' value='" . implode(",", $files) . "'><span class='dl-icon'></span></button></div>";
                  $files = [];
                  $group = [];
                  
                  }
                  $thumbnail = str_replace([".jpg"], "-mini.jpg", $file->name);
                  /* $link = "<a class='linkimg mb-3 mx-auto' href='planitos/". $file->name ."' download><img class='img-thumbnail img-fluid mx-auto d-block' src='mini/". $thumbnail ."'><div class='overlay'><span>&darr;</span></div></a>"; */
                  /* $results[] = $link; */
                  $files[]=$file->name;
                  $group[] = "<img class='hijo' src='mini/" . $thumbnail . "' >";
                  $repeatsitself = $fileTitle;

                }

                ++$count;

                if ($count == sizeof($dir) && !$noResults) {

                  $results[] = "<div class='card mx-auto'>" . implode($group) . "<button class='hijo dl' type='submit' form='descarga' name='files' value='" . implode(",", $files) . "'><span class='dl-icon'></span></button></div>";

                }

              }
              
              //Si no hay resultados devuelve mensaje 
              if ($noResults) {
              
                $results[] = '<p class="text-center">No hay resultados  :(</p>';
                return $results;
              
              } else {

                $this->_total = sizeof($results);
                return array_slice($results, $this->_start, $this->_limit);

              }


          } else {
              
              $count = 0;
              $noResults = true;

              foreach ($dir as $file) {

                
        
                if ($this->searchQuery($search, $file)) {
                  
                  if ($noResults){
                    $noResults = false;
                    $repeatsitself = $this->getTitle($file->name);
                  }
                  
                  $fileTitle = $this->getTitle($file->name);                                  
                  
                  if ( $fileTitle !== $repeatsitself ) {
                  
                  $results[] = "<div class='card mx-auto'>" . implode($group) . "<button class='hijo dl' type='submit' form='descarga' name='files' value='" . implode(",", $files) . "'><span class='dl-icon'></span></button></div>";
                  $files = [];
                  $group = [];
                  ++$count;

                  if ($count == $this->_end) {

                  //$results[] = "<div class='card mx-auto'>" . implode($group) . "<button class='hijo dl'>descargar</button></div>";
                  return array_slice($results, $this->_start);

                  }
                  
                  }
                  $thumbnail = str_replace([".jpg"], "-mini.jpg", $file->name);
                  /* $link = "<a class='linkimg mb-3 mx-auto' href='planitos/". $file->name ."' download><img class='img-thumbnail img-fluid mx-auto d-block' src='mini/". $thumbnail ."'><div class='overlay'><span>&darr;</span></div></a>"; */
                  /* $results[] = $link; */
                  $files[]=$file->name;
                  $group[] = "<img class='hijo' src='mini/" . $thumbnail . "' >";
                  $repeatsitself = $fileTitle;

                }

              }
              
              $results[] = "<div class='card mx-auto'>" . implode($group) . "<button class='hijo dl' type='submit' form='descarga' name='files' value='" . implode(",", $files) . "'><span class='dl-icon'></span></button></div>";
              return array_slice($results, $this->_start, $this->_limit);

    
          }
     }

    }

    public function pagLinks() {

      
      //Si no hay resultados no se muestra la paginación
      if (empty($this->_total)) {

        return "";

      }
      
      $last = ceil( $this->_total / $this->_limit );
      $class = ( $this->_page == 1 ) ? "disabled" : "";
      $html = '<div class="paginador"><a title="Primera" class="' . $class . '" href="?total=' . $this->_total . '&page=1&query=' . $this->_query . '&cat=' . $this->_cat . '" > &#8676 </a><a title="Anterior" class="' . $class . '" href="?total=' . $this->_total . '&page=' . ($this->_page - 1) . '&query=' . $this->_query . '&cat=' . $this->_cat . '" > &#8612 </a>';
      
      $html .= '<span>' . $this->_page . ' de ' . $last . '</span>';
      
      $class = ( $this->_page == $last ) ? "disabled" : "";
      $html .= '<a title="Siguiente" class="' . $class . '" href="?total=' . $this->_total . '&page=' . ($this->_page + 1) . '&query=' . $this->_query . '&cat=' . $this->_cat . '" > &#8614 </a><a title="Última" class="' . $class . '" href="?total=' . $this->_total . '&page=' . $last .'&query=' . $this->_query . '&cat=' . $this->_cat . '" > &#8677 </a></div>';

      return $html;

    }
    

}

?>