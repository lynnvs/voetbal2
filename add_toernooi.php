<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>toernooi toevoegen</title>
</head>
<body>
        <?php 
        include 'navbar.php';
        require_once 'database.php';

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $db = new database();
            $sql = "INSERT INTO toernooi VALUES (:id, :omschrijving, :datum);";
            $placeholder = [
                'id'=>NULL,
                'omschrijving'=>$_POST['omschrijving'],
                'datum' =>$_POST['datum']
            ];
            $db->insert($sql, $placeholder ,'toernooi');
        }
        ?>
            
        <form action="add_toernooi.php" method="post">
            <label for="omschrijving">omschrijving</label><br>
            <input type="text" name="omschrijving" required><br>

            <label for="datum">datum</label><br>
            <input type="date" name="datum" required><br>
            
            <input type="submit" value="Toernooi toevoegen"><br>
        </form>
</body>
</html>