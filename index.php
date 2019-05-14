<?php
    include 'connection.php';
?>

<html lang="en">
<head>
    <title>ASL</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Open+Sans" />
    
    <style>

        * {
            font-family: 'Open Sans'; 
        }

        #add {
            background-color: rgb(220, 229, 230);
        }

        .scadenza {
            font-size: 14px;
            color: grey;
        }

        .sticker {

            margin: 10px 0px 10px 0px;
            padding: 15px;
            border-radius: 5px;
            background-color: rgb(242, 248, 249);
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }

    </style>

</head>
<body>

    <div class="container">

        <h1 class="text-center">Welcome to your TODO list</h1>

        <div class="col-12">
            <form id="add" action="update.php" method="post" class="rounded p-4">
                <div class="row">

                    <?php

                        if(isset($_GET['edit']) && $_GET['edit'] == 'on'){

                            echo '<div class="col-5">
                                    <label for="description">Description</label>
                                    <input class="form-control" id="description" name="description" type="text" value="'.$_POST['description'].'">
                                </div>

                                <div class="col-5">
                                    <label for="date">Expiring date:</label>
                                    <input class="form-control" id="date" name="date" type="text" value="'.$_POST['date'].'">
                                </div> 

                                <div class="col-2 align-self-end">
                                    <input type="hidden" name="id" value="'.$_POST['id'].'">
                                    <button type="submit" class="btn btn-outline-success border border-0 ">
                                            <i class="fa fa-check-square"></i> Edit           
                                    </button> 
                                </div> <script> edit(); </script>';

                        }else{

                            echo '<div class="col-5">
                                    <label for="description">Description</label>
                                    <input class="form-control" id="description" name="description" type="text" placeholder="...">
                                  </div>

                                  <div class="col-5">
                                    <label for="date">Expiring date:</label>
                                    <input class="form-control" id="date" name="date" type="text" placeholder="yyyy/mm/dd">
                                  </div> 

                                  <div class="col-2 align-self-end">
                                    <button type="submit" class="btn btn-outline-primary border border-0 ">
                                            <i class="fa fa-plus-circle"></i> Add           
                                    </button> 
                                  </div>';
                        }
                    ?>
                </div>
            </form> 
        </div>

        <div class="col-12">

        <form action="upload.php" method="post">
            <?php   

            if(isset($_GET['m'])){

                if($_GET['m'] == 'error')
                    echo '<div class="alert alert-danger" role="alert">
                    ERRORE! Inserimento non valido o non permesso.</div>'; 

                if($_GET['m'] == 'noSelect')
                    echo '<div class="alert alert-danger" role="alert">
                    ERRORE! Nessun elemento selezionato.</div>'; 
                
                    
            }

            echo '<input name="delete" type="submit" onclick="if(confirm("Do you want to delete them?")) return true; return false;"
                        class="btn btn-outline-danger border border-0 align-self-end d-inline" value="Delete all selected.">';
            echo '<input name="confirm" type="submit" onclick="if(confirm("Do you want to confim them?")) return true; return false;"
                        class="btn btn-outline-success border border-0 align-self-end d-inline" value="Confirm all selected.">';

            $stmt = $connection->prepare("SELECT * FROM todolist WHERE done='0' ORDER BY scadenza");
            $stmt->execute();

            $var = $stmt->get_result();

            //per ogni riga di non fatti
            foreach($var as $riga){    

                echo ' <div class="sticker">
                        <p style="width: 900px;">'.$riga['descrizione'].'</p>
                        <p class="font-italic scadenza">Exp. '.$riga['scadenza'].'</p>

                        <form action="index.php?edit=on" method="post" class="text-right align-self-end">
                            <input type="hidden" name="id" value="'.$riga['id'].'">
                            <input type="hidden" name="description" value="'.$riga['descrizione'].'">
                            <input type="hidden" name="date" value="'.$riga['scadenza'].'">
                            <button style="margin-left: 870px;" type="submit" class="btn btn-outline-warning border border-0 align-self-end">
                                <i class="fa fa-pencil"></i> Edit
                            </button>           
                        </form>

                        <div class="form-group form-check">
                            <label class="form-check-label">
                            <input class="form-check-input" name="check[]" type="checkbox" value="'.$riga['id'].'">
                            </label>
                        </div>
                       </div>';
            }

            $stmt2 = $connection->prepare("SELECT * FROM todolist WHERE done='1' ORDER BY scadenza"); 

            $stmt2->execute();

            $var2 = $stmt2->get_result();

            foreach($var2 as $riga){

                echo ' <div class="sticker" style="background-color: rgb(120, 255, 120);">
                        <p style="width: 900px;">'.$riga['descrizione'].'</p>
                        <p class="font-italic scadenza">Exp. '.$riga['scadenza'].'</p>

                        <div class="form-group form-check">
                            <label class="form-check-label">
                            <input class="form-check-input" name="check[]" type="checkbox" value="'.$riga['id'].'">
                            </label>
                        </div>
                
                    </div>';
            }
            $stmt2->close();

            ?>  
        </form>
        </div>    
        
    </div>

</body>
</html>