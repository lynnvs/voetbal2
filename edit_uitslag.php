<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>uitslag invullen</title>
    </head>
    <body>
    <?php 
    include 'navbar.php';
    require_once 'database.php';

    $db = new database();

    if(isset($_GET['id'])){
        $sql = '
            SELECT 
                w.id, 
                w.toernooiID,
                t.omschrijving,
                w.speler1,
                CONCAT(s.roepnaam, " ", s.tussenvoegsel, " ", s.achternaam) as speler11,
                w.speler2,
                CONCAT(s1.roepnaam, " ", s1.tussenvoegsel, " ", s1.achternaam) as speler22,
                w.ronde
            FROM 
                wedstrijd w
            INNER JOIN toernooi t
            ON t.id = w.toernooiID
            INNER JOIN speler s
            ON s.id = w.speler1
            INNER JOIN speler s1
            ON s1.id = w.speler2
            WHERE w.id=:id';
        $wedstrijdData = $db->select($sql, ['id'=>$_GET['id']])[0];
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST'){  
        // winnaarID
        $wid = NULL;

        // bereken winnaarID op basis van ingevoerde punten
        // gelijkspel
        if($_POST['score1'] == $_POST['score2']){
            $wid = NULL;
        }

        if($_POST['score1'] > $_POST['score2']){
            // winnaarid
            $wid = $_POST['speler11'];
        }else{
            // speler 2 heeft hoogst aantal punten
            $wid = $_POST['speler22'];
        }

        $sqll = "UPDATE speler SET neemtDeel=0 WHERE id=:wid";

        $placeholder = [
            'wid'=>$wid
        ];


        $sql = "UPDATE wedstrijd SET score1=:p1, score2=:p2, winnaarID=:wid WHERE id=:id";
   
        $placeholders = [
            'p1'=>$_POST['score1'], 
            'p2'=>$_POST['score2'],
            'wid'=>$wid,
            'id'=>$_POST['id']
        ];



        $db->update_or_delete($sqll, $placeholder);
        $db->update_or_delete($sql, $placeholders, 'uitslagen');

    }
    ?>
    <form action="edit_uitslag.php" method="post">
        <input type="hidden" name="id" value="<?= isset($_GET['id']) ? $_GET['id'] : ''; ?>">
        <label for="toernooi">Toernooi</label><br>
        <select name="toernooi" disabled="disabled">
            <option value="<?= $wedstrijdData['toernooi'] ?>"><?= $wedstrijdData['toernooiID'] ?></option>
        </select><br><br>
        <label for="speler11">Speler 1</label><br>
        <select name="speler11">
            <option value="<?= $wedstrijdData['speler1'] ?>"><?= $wedstrijdData['speler11'] ?></option>
        </select><br><br>
        <label for="speler22">Speler 2</label><br>
        <select name="speler22">
        <option value="<?= $wedstrijdData['speler2'] ?>"><?= $wedstrijdData['speler22'] ?></option>
        </select><br><br>
        <label for="ronde">Ronde</label><br>
        <select name="ronde" disabled="true">
            <option value="<?= $wedstrijdData['ronde'] ?>"><?= 'Ronde ' . $wedstrijdData['ronde'] ?></option>
        </select><br><br>
        <label for="score1">Punten speler 1</label><br>
        <input type="text" name="score1"><br><br>
        <label for="score2">Punten speler 2</label><br>
        <input type="text" name="score2"><br>
        <input type="submit" value="Uitslag toevoegen">
    </form>
        
    </body>
</html>