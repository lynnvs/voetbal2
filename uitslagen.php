<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Uitslag</title>
    </head>
    <body>

    <?php
        include 'navbar.php';
        require_once 'database.php';
        require_once 'table-generator.php';

        $geenDataBeschikbaar = true;

        $db = new database();

        $sql = '
            SELECT 
                w.id, 
                w.ronde, 
                CONCAT(s.roepnaam, " ", s.tussenvoegsel, " ", s.achternaam) as speler1,
                CONCAT(s1.roepnaam, " ", s1.tussenvoegsel, " ", s1.achternaam) as speler2,
                w.score1,
                w.score2,
                CONCAT(s3.roepnaam, " ", s3.tussenvoegsel, " ", s3.achternaam) as winnaar
            FROM wedstrijd w
            INNER JOIN speler s
            ON s.id = w.speler1
            INNER JOIN speler s1
            ON s1.id = w.speler2
            INNER JOIN speler s3
            ON s3.id = w.winnaarID';

        $wedstrijden = $db->select($sql);


        $sql2 = '
        SELECT 
            w.id, 
            w.ronde, 
            CONCAT(s.roepnaam, " ", s.tussenvoegsel, " ", s.achternaam) as speler1,
            CONCAT(s1.roepnaam, " ", s1.tussenvoegsel, " ", s1.achternaam) as speler2,
            w.score1,
            w.score2
        FROM wedstrijd w
        INNER JOIN speler s
        ON s.id = w.speler1
        INNER JOIN speler s1
        ON s1.id = w.speler2';

        $wedstrijden2 = $db->select($sql2);

        

        if(is_array($wedstrijden) && !empty($wedstrijden)){
            $geenDataBeschikbaar = false;
            create_table($wedstrijden, 'uitslag', $enableAction=TRUE, $enableEdit=TRUE, $enableDelete=FALSE);
            create_table($wedstrijden2, 'uitslag', $enableAction=TRUE, $enableEdit=TRUE, $enableDelete=FALSE); 
        }else if($geenDataBeschikbaar){ ?>
            <p class='no-data'>Geen wedstrijd data beschikbaar</p>
        <?php } ?>  

        
    </body>
</html>