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

        $db = new database();
        $toernooien = $db->select("SELECT * FROM toernooi");

        // haalt alle spelers zonder deelname op
        $sql = '
            SELECT 
                id, 
                CONCAT(roepnaam, " ", tussenvoegsel, " ", achternaam) as naam
            FROM 
                speler
            WHERE neemtDeel=0';

        $spelers = $db->select($sql);

        // we moeten twee spelers selecteren, maar de mogelijkheid om 2x zelfde te selecteren uitsluiten.
        // zorg dat alle spelers op een even index naar lijst 2 gaan, alle andere naar lijst 1.
        $spelersLijst1 = [];

        foreach($spelers as $key=>$speler){
            // met de modulo kun je restanten berekenen. 
            // Wanneer de restand van een deling met 2 in een 0 resulteert, spreken we van een even getal.
            if($key % 2 == 0){
                array_push($spelersLijst1, $speler);
            }else{
                array_push($spelersLijst1, $speler);
            }
        }
        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            // zorg ervoor dat de deelname status van de speler updated wordt
            $sql = "UPDATE speler SET neemtdeel=1 WHERE id IN (:id, :speler1)";
            $placeholders = [
                'id'=>$_POST['speler1']
            ];
            $db->update_or_delete($sql, $placeholders);

            // zorg er vervolgens voor dat de data uit het form wordt opgeslagen.
            $sql1 = "INSERT INTO aanmelding VALUES (:id, :toernooi, :speler1)";
            
            $placeholders1 = [
                'id'=>NULL,
                'toernooiID'=>$_POST['toernooi'],
                'speler1ID'=>(int)$_POST['speler1']
            ];

            $db->insert($sql1, $placeholders1, 'handmatig');
        }
        
        
        ?>
        <form action="add_aanmelding.php" method="post">
            <?php if(is_array($toernooien) && !empty($toernooien)){?>
                <label for="toernooi">Toernooien</label>
                <select name="toernooi" required>
                    <?php foreach($toernooien as $key=> $toernooi){?>
                        <option value="<?php echo $toernooi['id'];?>"><?php echo $toernooi['omschrijving'];?></option>
                    <?php } ?>
                </select><br><br>
            <?php }else{ ?>
                    <p class='no-data'>Voeg eerst een toernooi toe</p>
            <?php } ?>

            <!-- Speler 1 -->
            <?php if(is_array($spelersLijst1) && !empty($spelersLijst1)){?>
                <label for="speler1">Speler </label>
                <select name="speler1" required>
                    <?php foreach($spelersLijst1 as $key=> $speler){?>
                        <option value="<?php echo $speler['id'];?>"><?php echo $speler['naam'];?></option>
                    <?php } ?>
                </select><br><br>
            <?php }else{ ?>
                    <p class='no-data'>Wacht op een beschikbare speler</p>
            <?php } ?>

            <input type="submit" value="Voeg aanmelding toe">
        </form>
        
    </body>
</html>