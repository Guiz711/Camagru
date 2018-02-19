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

public function userLastImage($user_id)
{
    $req = "SELECT img_id FROM $this->table WHERE user_id=:user_id
        ORDER BY date_creation DESC LIMIT 1";

    if ($this->verbose)
        echo "</br >" . $req . "</br >";
    $prep = $this->db->prepare($req);
    $prep->bindValue(':user_id', $user_id);
    $prep->execute();
    $result = $prep->fetch();
    return ($result['img_id']);
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