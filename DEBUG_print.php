<?php

function DEBUG_print($tab) 
{
    echo "</br ></br >---> DEBUG Print :</br >";
    foreach ($tab as $key1 => $value1) {
        echo "[$key1] {</br >";
        foreach ($value1 as $key => $value) {
            echo ".[$key] = $value </br >";
        }
        echo "}</br >";
    }
    echo "END <--</br >";
}

?>
