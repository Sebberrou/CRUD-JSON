<?php

/*
Every new entrie is defined with an id in the JSON file
6 public function
  - add($datas)
  - get($id)
  - getAll()
  - delete($id)
  - deleteAll()
  - edit($id, $datas)
  - write();

*/

class Base {


// will store the name of the file called, it will need to have the same name as the child class  
  protected $file = '';
//will store the content of the json file
  protected $json;
// path to the files
  private $path ='./datas';

  /**
   *will use the name of the instanciated class to look for and get the content of the json file
   */
  public function  __construct(  ) {

    //Récupérer le nom du json selon la class instanciée
    $this->file=lcfirst(get_class($this)).".json";

    // Récupérer le contenu du fichier
    // et l'encoder dans une structure json
    $str_data=file_get_contents($this->path."/".$this->file);
    $this->json=json_decode($str_data,true);
  }

  /**
   * @param array $datas   the data to add to the file
   * @return integer  the id of the new entry
   */
  public function add( $datas ) {

    //get the key of the last entry and incremente
    $key = key(array_slice($this->json, -1, 1, true)) + 1;   
    $this->json[$key]=$datas;
    return $key;
  }

  /**
   * get the infos from one entry
   * the id needs to be an int
   * @param integer $id     identifiant
   * @return array content of the entry
   */
  public function get( $id = null) {

    if ( !is_null( $id ) && is_int( $id ) ) {
     
      return $this->json[$id];
    }
  }

  /**
   * return of the element from the file
   */
  public function getAll( ) {

    return $this->json;
  }

  /**
   * delete on element *** needs to be followed by $this->write to be applied to the file**
   * @param integer $id  id of the entry to delete
   */
  public function delete( $id = null ) {

    unset($this->json[$id]);


  }

  /**
   * delete all the entries
   * *** needs to be followed by $this->write to be applied to the file***
   */
  static public function deleteAll() {

    $this->json=null;
  }

  /**
   * Edit on entrie
   *
   * @param integer $id     id of the entry
   * @param array   $datas  datas to be stored to this entri
   */
  public function edit( $id, $datas ) {

    $this->json[$id]=$datas;
  }

/**
 * write the modification to the json file
 * 
 */
  public function write()
  {   

    $fh = fopen($this->path."/".$this->file, 'w') 
      or die("Error opening output file");
    fwrite($fh, json_encode($this->json,JSON_UNESCAPED_UNICODE));
    fclose($fh);
  }
}
?>