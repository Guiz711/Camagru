<?php
// include_once("../Model/DbManager.class.php");
// include_once("../Model/SelectElem.class.php");

class ImagesManager extends DbManager {
    function __construct() {
        parent::__construct(".images", "img_id");
        echo "ImagesManager --> constructed</br >";
    }

    use SelectElem;

    public function select_where($id) {
        $result = $this->select_elem($id, $this->table, $this->id_name, $this->db);
    }
}
?>