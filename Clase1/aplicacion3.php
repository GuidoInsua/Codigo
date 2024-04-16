<?php

// Obtener valor del medio . Guido Insua

$a = rand(0, 100);
$b = rand(0, 100);
$c = rand(0, 100);

echo $a."-".$b."-".$c;

if($a == $b || $a == $c || $b == $c)
{
    echo "<br>No hay numero del medio";
}
else
{
    if($a > $b && $a < $c || $a < $b && $a > $c)
    {
        echo "<br>" . $a;
        return;
    }

    if($b > $a && $b < $c || $b < $a && $b > $c)
    {
        echo "<br>" . $b;
        return;
    }
    echo "<br>" . $c;
}

?>