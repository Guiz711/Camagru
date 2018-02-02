<?php
include_once("../Model/DbManager.class.php");
include_once("../Model/Display.class.php");

class CommentsManager extends DbManager
{
    function __construct() {
        parent::__construct();
        $this->table = $this->db_name . ".comments";
        $this->id_name = "comment_id";
        echo "CommentsManager --> constructed</br >";
    }

    public function insert($var, $table) {
        parent::insert($var, $this->table);
    }

    public function update($id, $var, $table) {
        parent::update($id, $var, $this->table);
    }

    public function delete($id, $table) {
        parent::delete($id, $this->table);
    }

    use Display;

    public function display_for($user_id) {
        $result = $this->display_elem($user_id, $this->table, $this->id_name, $this->db);
    }
}
?>