<?php
    
    include 'connection.php';

    if(!isset($_POST['check']))
        header("Location: index.php?m=noSelect");
    else{

        foreach($_POST['check'] as $id){
            //elimino riga
            if(isset($_POST['delete'])) $stmt = $connection->prepare("DELETE FROM todolist WHERE id=?"); 
            else if(isset($_POST['confirm'])) $stmt = $connection->prepare("UPDATE todolist SET done='1' WHERE id=?");
            else if(isset($_POST['unconfirm'])) $stmt = $connection->prepare("UPDATE todolist SET done='0' WHERE id=?");
            $stmt->bind_param("i",$id);
            $stmt->execute();
            $stmt->close();
        }

        header("Location: index.php");
    }
?>