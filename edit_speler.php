<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Wijzig speler</title>
    </head>
    <body>
        <?php
        include 'navbar.php';
        require_once 'database.php';
        $db= new database();
        $scholen = $db->select('SELECT * FROM school');

        if(isset($_GET['id'])){
        $sql = '
            SELECT 
                roepnaam, 
                tussenvoegsel, 
                achternaam 
            FROM 
                speler 
            WHERE 
                id=:id';
        $speler = $db->select($sql, ['id'=>$_GET['id']])[0];
        }

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
            $sql = "
                UPDATE 
                    speler 
                SET 
                    roepnaam=:roepnaam, 
                    tussenvoegsel=:tvoegsel, 
                    achternaam=:achternaam,
                    schoolID=:schoolID
                WHERE
                    id=:id
            ";

            $placeholders = [
                'id'=>$_POST['id'],
                'roepnaam'=>$_POST['roepnaam'],
                'tvoegsel'=>$_POST['tvoegsel'],
                'achternaam'=>$_POST['achternaam'],
                'schoolID'=>$_POST['schoolID']
            ];
            $db->update_or_delete($sql, $placeholders,'spelers');
        }
        ?>
        <form action="edit_speler.php" method="post">
            <input type="hidden" name="id" value="<?php echo isset($_GET) ? $_GET['id'] : ''?>">
            <label for="roepnaam">Naam</label><br>
            <input type="text" name="roepnaam" onfocus="this.value=''" value="<?= isset($_GET['id']) ? $speler['roepnaam'] : ''?>" required><br>
            <label for="tvoegsel">Tussenvoegsel</label><br>
            <input type="text" name="tvoegsel" onfocus="this.value=''" value="<?= isset($_GET['id']) ? $speler['tussenvoegsel'] : ''?>"><br>
            <label for="achternaam">Achternaam</label><br>
            <input type="text" name="achternaam" onfocus="this.value=''" value="<?= isset($_GET['id']) ? $speler['achternaam'] : ''?>" required><br>

            <?php if(is_array($scholen) && !empty($scholen)){?>
            <select name="schoolID" required>
                <?php foreach($scholen as $key=> $school){?>
                    <option value="<?php echo $school['id'];?>"><?php echo $school['naam'];?></option>
                <?php } ?>
            </select><br><br>
            <?php }else{ ?>
                    <p class='no-data'>Voeg eerst een vereniging toe</p>
            <?php } ?>

            <input type="submit" value="Wijzig">
        </form>
    </body>
</html>