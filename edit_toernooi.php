<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Wijzig toernooi</title>
    </head>
    <body>
        <?php
        include 'navbar.php';
        require_once 'database.php';
        $db= new database();

        if(isset($_GET['id'])){
        $sql = "SELECT omschrijving, datum FROM toernooi WHERE id=:id";
        $toernooi = $db->select($sql, ['id'=>$_GET['id']])[0];
        }

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
            $sql = "UPDATE toernooi SET omschrijving=:omschrijving, datum=:datum WHERE id=:id";
            $placeholders = [
                'id'=>$_POST['id'],
                'omschrijving'=>$_POST['omschrijving'],
                'datum' => $_POST['datum']
            ];
            $db->update_or_delete($sql, $placeholders,'toernooi');
        }
        ?>
        <form action="edit_toernooi.php" method="post">
            <input type="hidden" name="id" value="<?php echo isset($_GET) ? $_GET['id'] : ''?>">
            <label for="omschrijving">omschrijving toernooi</label><br>
            <input type="text" name="omschrijving" onfocus="this.value=''" value="<?= isset($_GET['id']) ? $toernooi['omschrijving'] : ''?>"><br>
            <label for="datum">datum</label><br>
            <input type="date" name="datum" onfocus="this.value=''" value="<?= isset($_GET['id']) ? $toernooi['datum'] : ''?>"><br>
            <input type="submit" value="Wijzig">
        </form>
    </body>
</html>