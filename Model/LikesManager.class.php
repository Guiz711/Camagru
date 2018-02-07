<?php

class LikesManager extends DbManager
{
    function __construct() {
        parent::__construct(".likes", "like_id");
        if ($this->verbose)
            echo "likesManager --> constructed</br >";
    }

    use SelectElem;

    public function select_where($id) {
        $result = $this->select_elem($id, $this->table, $this->id_name, $this->db);
    }
}
?>