<?php

trait Display {
    function display_elem($user_id, $table, $id_table, $db) {
        $req = "SELECT $id_table FROM $table WHERE user_id=:user_id";
        // echo $req . "</br >";
        $prep = $db->prepare($req);
        $prep->bindValue(":user_id", $user_id);
        $prep->execute();
		$result = $prep->fetchAll();
		$tab = array();
        foreach ($result as $value1) {
            foreach ($value1 as $key => $value) {
                if ($key === $id_table) {
                    $tab[] = $value;
                }
            }
        }
        echo "</br >RESULT Traite</br >";
        print_r($tab);
        return ($tab);
    }
}
?>