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
        $this->_end = ( $this->_page * $this->_limit ) - 1;
    }

    public function getData() {
        
        
        //Busqueda por categoria
        if (!empty($this->_cat)) {

            $path = "db/" . $this->_cat . ".json";
            $data = file_get_contents($path);
            $json = json_decode($data);
            $dir = [...$json[0]->contents];
            

            if (is_null($this->_total)) {

              foreach ($dir as $file) {
                
                $thumbnail = str_replace([".jpg"], "-mini.jpg", $file->name);
                $link = "<a class='linkimg mb-3 mx-auto' href='planitos/". $file->name ."' download><img class='img-thumbnail img-fluid mx-auto d-block' src='mini/". $thumbnail ."'><div class='overlay'><span>&darr;</span></div></a>";
                $results[] = $link;
                
              }

              $this->_total = sizeof($results);

              return array_slice($results, $this->_start, $this->_limit);

           } else {

              $count = 0;

              foreach ($dir as $file) {
                
              $thumbnail = str_replace([".jpg"], "-mini.jpg", $file->name);
              $link = "<a class='linkimg mb-3 mx-auto' href='planitos/". $file->name ."' download><img class='img-thumbnail img-fluid mx-auto d-block' src='mini/". $thumbnail ."'><div class='overlay'><span>&darr;</span></div></a>";
              $results[] = $link;
              

              if ($count == $this->_end) {

                return array_slice($results, $this->_start);

              }

              $count++;

            }

            return array_slice($results, $this->_start);

          }
          
          //Busqueda por palabras
          } elseif (!empty($this->_query)) {
        
              $search = getQuery($this->_query);
              $data = file_get_contents("db/ALL.json");
              $json = json_decode($data);
              $dir = [...$json[0]->contents];
              $noResults = true;

              if (is_null($this->_total)) {

                
              
                foreach ($dir as $file) {
        
                if (searchQuery($search, $file)) {
                  
                  $noResults = false;
                  $thumbnail = str_replace([".jpg"], "-mini.jpg", $file->name);
                  $link = "<a class='linkimg mb-3 mx-auto' href='planitos/". $file->name ."' download><img class='img-thumbnail img-fluid mx-auto d-block' src='mini/". $thumbnail ."'><div class='overlay'><span>&darr;</span></div></a>";
                  $results[] = $link;

                }

              }
              
              //Si no hay resultados devuelve mensaje 
              if ($noResults) {
              
                $results[] = '<p class="text-center">No hay resultados  :(</p>';
                return $results;
              
              }

              $this->_total = sizeof($results);
              return array_slice($results, $this->_start, $this->_limit);


          } else {
              
              $count = 0;

              foreach ($dir as $file) {
                
                if (searchQuery($search, $file)) {
                  
                  $thumbnail = str_replace([".jpg"], "-mini.jpg", $file->name);
                  $link = "<a class='linkimg mb-3 mx-auto' href='planitos/". $file->name ."' download><img class='img-thumbnail img-fluid mx-auto d-block' src='mini/". $thumbnail ."'><div class='overlay'><span>&darr;</span></div></a>";
                  $results[] = $link;
                  
                  if ($count == $this->_end) {
                    
                    return array_slice($results, $this->_start);
    
                  }
                
                  $count++;

                }

              }

              return array_slice($results, $this->_start);
    
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
      $html = '<div class="paginador"><a class="' . $class . '" href="?total=' . $this->_total . '&page=1&query=' . $this->_query . '&cat=' . $this->_cat . '" > &#8676 </a><a class="' . $class . '" href="?total=' . $this->_total . '&page=' . ($this->_page - 1) . '&query=' . $this->_query . '&cat=' . $this->_cat . '" > &#8612 </a>';
      
      $html .= '<span>' . $this->_page . ' de ' . $last . '</span>';
      
      $class = ( $this->_page == $last ) ? "disabled" : "";
      $html .= '<a class="' . $class . '" href="?total=' . $this->_total . '&page=' . ($this->_page + 1) . '&query=' . $this->_query . '&cat=' . $this->_cat . '" > &#8614 </a><a class="' . $class . '" href="?total=' . $this->_total . '&page=' . $last .'&query=' . $this->_query . '&cat=' . $this->_cat . '" > &#8677 </a></div>';

      return $html;

    }
    

}

?>