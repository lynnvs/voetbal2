<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>toernooien</title>
    </head>
    <body>

        <?php 
        include 'navbar.php';
        require_once 'database.php';
        require_once 'table-generator.php';
        $geenDataBeschikbaar = true;

        $db = new database();
        $toernooi = $db->select("SELECT * FROM toernooi");

        //checkt of er data in de database table staat
        if(is_array($toernooi) && !empty($toernooi)){
            $geenDataBeschikbaar = false;
            create_table($toernooi, 'toernooi');
        }else if($geenDataBeschikbaar){ ?>
            <p class='no-data'>Geen data beschikbaar</p>
        <?php } ?>  

        <button>
            <a href="add_toernooi.php">Nieuw toernooi toevoegen</a>
        </button>
    </body>
</html>