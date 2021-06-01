<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Wijzig school</title>
    </head>
    <body>
        <?php
        include 'navbar.php';
        require_once 'database.php';
        $db= new database();

        if(isset($_GET['id'])){
        $sql = "SELECT naam FROM school WHERE id=:id";
        $school = $db->select($sql, ['id'=>$_GET['id']])[0];
        }

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
            $sql = "UPDATE school SET naam=:naam WHERE id=:id";
            $placeholders = [
                'id'=>$_POST['id'],
                'naam'=>$_POST['naam']
            ];
            $db->update_or_delete($sql, $placeholders,'scholen');
        }
        ?>
        <form action="edit_school.php" method="post">
            <input type="hidden" name="id" value="<?php echo isset($_GET) ? $_GET['id'] : ''?>">
            <label for="naam">naam school</label><br>
            <input type="text" name="naam" onfocus="this.value=''" value="<?= isset($_GET['id']) ? $school['naam'] : ''?>"><br>
            <input type="submit" value="Wijzig">
        </form>
    </body>
</html>