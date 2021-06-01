<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Wedstrijden</title>

    </head>
    <body>

        <?php
        include 'navbar.php';
        require_once 'database.php';
        require_once 'table-generator.php';

        $geenDataBeschikbaar = true;

        $db = new database();
        // haal eerst alle spelers op die uberhaupt een wedstrijd hebben gespeeld.
        $sql = '
            SELECT 
                id, 
                CONCAT(roepnaam, " ", tussenvoegsel, " ", achternaam) as naam
            FROM 
                speler 
            WHERE neemtDeel=1';
        $spelersMetDeelname = $db->select($sql);
        

        if($_SERVER['REQUEST_METHOD'] == 'POST'){

        $sql = '
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
            ON s1.id = w.speler2

            WHERE w.speler1=:id1 OR w.speler2=:id2';

        
        $placeholders = ['id1'=>$_POST['spelers'], 'id2'=>$_POST['spelers']];
        $wedstrijden = $db->select($sql, $placeholders);

        if(is_array($wedstrijden) && !empty($wedstrijden)){
            $geenDataBeschikbaar = false;
            create_table($wedstrijden, 'wedstrijd', FALSE);
        }else if($geenDataBeschikbaar){ ?>
            <p class='no-data'>Geen wedstrijd data beschikbaar</p>
        <?php } 
        }
        ?>  

        <form action="toernooioverzicht.php" method="post">
            <?php if(is_array($spelersMetDeelname) && !empty($spelersMetDeelname)){?>
                <select name="spelers" required>
                    <?php foreach($spelersMetDeelname as $key => $speler){?>
                        <option value="<?php echo $speler['id'];?>"><?php echo $speler['naam'];?></option>
                    <?php } ?>
                </select><br><br>
            <?php }else{ ?>
                    <p class='no-data'>Voeg eerst een nieuwe wedstrijd toe</p>
            <?php } ?>
            <input type="submit" value="Toon overzicht"><br><br>
        </form>

        <button>
            <a href="add_wedstrijd.php">Nieuwe wedstrijd toevoegen</a>
        </button>

    </body>
</html>