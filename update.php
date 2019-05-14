<?php
    include 'connection.php';

    $description = strip_tags($_POST['description']);
    $date = strip_tags($_POST['date']);
    
    //          che non abbia nulla all'interno            E                       che non abbia tag html
    if(($_POST['description'] !="" && $_POST['date'] !="") && ($description == $_POST['description'] &&  $date == $_POST['date'])){

        //EDIT
        if(isset($_POST['id'])) {

            $id= strip_tags($_POST['id']);
            $stmt = $connection->prepare("UPDATE todolist SET descrizione=?,scadenza=? WHERE id=?");
            $stmt->bind_param("ssi", $description, $date, $id);
        }
        //ADD
        else{

            $stmt = $connection->prepare("INSERT INTO todolist (descrizione, scadenza) VALUES (?,?)"); 
            $stmt->bind_param("ss",$description,$date);
        }
            
    }
    else{
        header("Location: index.php?m=error");
    }

    $stmt->execute();     
    $stmt ->close();
    header("Location: index.php");
?>