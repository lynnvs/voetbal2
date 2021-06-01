<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>spelers</title>
    </head>
    <body>

        <?php 
        include 'navbar.php';
        require_once 'database.php';
        require_once 'table-generator.php';
        $geenDataBeschikbaar = true;

        $db = new database();
        $school = $db->select(
            'SELECT s.id, s.roepnaam, s.tussenvoegsel, s.achternaam,
            sc.naam as school, s.neemtdeel FROM speler s
            INNER JOIN school sc
            ON sc.id = s.schoolID');

        //checkt of er data in de database table staat
        if(is_array($school) && !empty($school)){
            $geenDataBeschikbaar = false;
            create_table($school, 'speler');
        }else if($geenDataBeschikbaar){ ?>
            <p class='no-data'>Geen data beschikbaar</p>
        <?php } ?>  

        <button>
            <a href="add_speler.php">Nieuwe speler toevoegen</a>
        </button>

        
    </body>
</html>