<?php
    session_start();
    if($_POST){
        header("location:./admin/secciones/principal.php");
    }
?>