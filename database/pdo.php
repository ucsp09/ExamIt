<?php
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=examit', 'ucsp09', 'ucsp09');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>