<?php
function getScripts($names)
{
    $libBase = file_get_contents('./assets/templates/script.html', FALSE);
    
    $libs="";
    foreach($names as $name)
    {
        $libs .= str_replace("++++script++++", $name, $libBase);
    }
    return $libs;
}

function getStyles($names)
{
    $styleBase = file_get_contents('./assets/templates/style.html', FALSE);
    
    $styles="";
    foreach($names as $name)
    {
        $styles .= str_replace("++++ESTILO++++", $name, $styleBase);
    }
    return $styles;
}
?>