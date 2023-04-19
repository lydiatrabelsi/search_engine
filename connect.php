<?php
    $HOSTNAME='localhost';
    $USERNAME='root';
    $PASSWORD='';
    $DATABASE='search_engine';

    $conn=mysqli_connect($HOSTNAME,$USERNAME,$PASSWORD,$DATABASE);

    if(!$conn){
        die(mysqli_error($conn));
    }else{
        echo'connexion reussie';
    }
?> 