<?php
if (!isset($vault) || $vault !== true)
{
	header('HTTP/1.0 403 Forbidden');
	die();
}

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