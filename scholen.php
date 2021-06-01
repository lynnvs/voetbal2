<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Scholen</title>
    </head>
    <body>

        <?php 
        include 'navbar.php';
        require_once 'database.php';
        require_once 'table-generator.php';
        $geenDataBeschikbaar = true;

        $db = new database();
        $school = $db->select("SELECT * FROM school");

        //checkt of er data in de database table staat
        if(is_array($school) && !empty($school)){
            $geenDataBeschikbaar = false;
            create_table($school, 'school');
        }else if($geenDataBeschikbaar){ ?>
            <p class='no-data'>Geen data beschikbaar</p>
        <?php } ?>  

        <button>
            <a href="add_school.php">Nieuwe school toevoegen</a>
        </button>

        
    </body>
</html>