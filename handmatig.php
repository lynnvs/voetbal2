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

        // haal alle spelers zonder deelname op, anderen spelen namelijk al
        $sql = '
            SELECT 
                id, 
                CONCAT(roepnaam, " ", tussenvoegsel, " ", achternaam) as naam
            FROM 
                speler 
            WHERE neemtDeel=0';

        $spelers = $db->select($sql);

        $spelerslijst1 = [];
        $spelerslijst2 = [];

        foreach($spelers as $key=>$speler){
            // met de modulo kun je restanten berekenen. 
            // Wanneer de restand van een deling met 2 in een 0 resulteert, spreken we van een even getal.
            if($key % 2 == 0){
                array_push($spelerslijst1, $speler);
            }else{
                array_push($spelerslijst1, $speler);
            }
        }

        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            // zorg er vervolgens voor dat de data uit het form wordt opgeslagen.
            $sql1 = "INSERT INTO aanmelding VALUES (:id, :spelerID, :toernooiID)";
            
            $placeholders1 = [
                'id'=>NULL,
                'spelerID'=>$_POST['spelerID'],
                'toernooiID'=>$_POST['toernooi']
            ];

            $db->insert($sql1, $placeholders1, 'handmatig');
        }
        
        ?>
        <form action="handmatig.php" method="post">
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
            <?php if(is_array($spelerslijst1) && !empty($spelerslijst1) ){?>
                <label for="spelerID">Speler</label>
                <select name="spelerID" required>
                    <?php foreach($spelerslijst1 as $key=> $speler){?>
                        <option value="<?php echo $speler['id'];?>"><?php echo $speler['naam'];?></option>
                    <?php } ?>
                </select><br><br>
            <?php }else{ ?>
                    <p class='no-data'>Wacht op een beschikbare speler</p>
            <?php } ?>

            

            <input type="submit" value="Voeg wedstrijd toe">
        </form>
        


    </body>
</html>