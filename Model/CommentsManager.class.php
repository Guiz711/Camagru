<?php

class CommentsManager extends DbManager
{
    function __construct() {
        parent::__construct(".comments", "comment_id");
        if ($this->verbose)
            echo "CommentsManager --> constructed</br >";
    }

    use SelectElem;

    public function select_where($id) {
        $result = $this->select_elem($id, $this->table, $this->id_name, $this->db);
    }

    public function find_last($img_id) {
        $req = "SELECT * FROM $this->table WHERE img_id=:img_id ORDER BY date_creation DESC LIMIT 1";
        if ($this->verbose)
            echo $req;
        $prep = $this->db->prepare($req);
        $prep->bindValue(":img_id", $img_id);
        $prep->execute();
        $result = $prep->fetchAll();
        return ($result);
    } 
}
?>