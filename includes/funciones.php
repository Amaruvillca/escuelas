<?php

function estadoAutenticado()
{
    if (!$_SESSION['login']) {
        header('Location:/escuela/login.php');
        exit;
    }
}
function debuguear($variable){
    echo '<pre>';
var_dump($variable);
echo '</pre>';
exit;
}