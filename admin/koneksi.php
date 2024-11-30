<?php
try {
    
    $dbh = new PDO("mysql:host=localhost;dbname=web_lanjut_kel_1", "root", "");
} catch (PDOException $e) {
    
    print "Koneksi atau query bermasalah: " . $e->getMessage() . "<br/>";
    die();
}
?>
