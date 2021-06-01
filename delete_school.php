<?php
require_once 'delete.php';
delete("DELETE FROM school WHERE id=:id", 'scholen');

?>