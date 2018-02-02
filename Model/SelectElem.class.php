<?php

trait SelectElem {
    function select_elem($id, $table, $id_table, $db) {
        $id_key = implode(array_keys($id));
        $req = "SELECT $id_table FROM $table WHERE $id_key=:$id_key";
        // echo $req . "</br >";
        $prep = $db->prepare($req);
        $prep->bindValue(":" . $id_key, $id[$id_key]);
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