<?php
// include_once("../Model/DbManager.class.php");
// include_once("../Model/SelectElem.class.php");

class CommentsManager extends DbManager
{
    function __construct() {
        parent::__construct(".comments", "comment_id");
        echo "CommentsManager --> constructed</br >";
    }

    use SelectElem;

    public function select_where($id) {
        $result = $this->select_elem($id, $this->table, $this->id_name, $this->db);
    }
}
?>