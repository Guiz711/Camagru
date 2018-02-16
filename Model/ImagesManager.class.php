<?php

class ImagesManager extends DbManager {
    function __construct() {
        parent::__construct(".images", "img_id");
        if ($this->verbose)
            echo "ImagesManager --> constructed</br >";
    }

    use SelectElem;

    public function select_where($id) {
        $result = $this->select_elem($id, $this->table, $this->id_name, $this->db);
    }


public function find_userid($id) {
    $req = "SELECT user_id FROM $this->table WHERE img_id=:id";
    if ($this->verbose)
        echo "</br >" . $req . "</br >";
    $prep = $this->db->prepare($req);
    $prep->bindValue(":id", $id);
    $prep->execute();
    $result = $prep->fetchAll();
    return ($result);
}}
?>