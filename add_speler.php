<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Nieuwe speler toevoegen</title>

    </head>
    <body>

        <?php 

        include 'navbar.php'; 
        require_once 'database.php';

        $db = new database();
        $scholen = $db->select('SELECT * FROM school');

        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            $sql = "
                INSERT INTO 
                    speler 
                VALUES (:id, :roepnaam, :tvoegsel, :achternaam, :schoolID, :neemtdeel)";

            $named_placeholders = [
                'id'=> NULL,
                'roepnaam'=>$_POST['roepnaam'],
                'tvoegsel'=>$_POST['tussenvoegsel'],
                'achternaam'=>$_POST['achternaam'],
                'schoolID'=>$_POST['naam'],
                'neemtdeel'=> 0
            ];

            $db->insert($sql, $named_placeholders, 'spelers');
        }

        ?>

        <form action="" method="post">
            <label for="roepnaam">Roepnaam</label><br>
            <input type="text" name="roepnaam" required><br>
            <label for="tussenvoegsel">Tussenvoegsel</label><br>
            <input type="text" name="tussenvoegsel"><br>
            <label for="achternaam">Achternaam</label><br>
            <input type="text" name="achternaam" required><br><br>
            <label for="naam">School</label><br>

            <?php if(is_array($scholen) && !empty($scholen)){?>
            <select name="naam" required>
                <?php foreach($scholen as $key=> $school){?>
                    <option value="<?php echo $school['id'];?>"><?php echo $school['naam'];?></option>
                <?php } ?>
            </select><br><br>
            <?php }else{ ?>
                    <p class='no-data'>Voeg eerst een school toe</p>
            <?php } ?>
            <input type="submit" value="Speler toevoegen" <?php if(!is_array($scholen) && empty($scholen)){ ?> disabled="disabled" <?php } ?>>
        </form>
    </body>
</html>