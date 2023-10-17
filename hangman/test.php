<?php
    $string = "the dark knight";
    echo $string;
    $lista = array();
    echo "<br>";
    $strLength = strlen($string);


        for ($i = 0; $i<$strLength;$i++){
            if ($string[$i] === " "){
                echo " . ";
            }else{
                echo " _ ";
            }
        }
        echo "<br>";
        $string = str_replace(' ', '', $string);
        echo $string;




?>