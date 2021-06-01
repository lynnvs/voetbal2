<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>school toevoegen</title>
</head>
<body>
<?php 
        include 'navbar.php';
        require_once 'database.php';

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $db = new database();
            $sql = "INSERT INTO school VALUES (:id, :naam);";
            $placeholder = [
                'id'=>NULL,
                'naam'=>$_POST['naam']
            ];
            $db->insert($sql, $placeholder ,'scholen');
        }
        ?>
            
        <form action="add_school.php" method="post">
            <label for="naam">school naam</label><br>
            <input type="text" name="naam" required><br>
            
            <input type="submit" value="Toernooi toevoegen"><br>
        </form>
</body>
</html>