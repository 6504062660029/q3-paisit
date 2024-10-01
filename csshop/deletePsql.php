<?php include "connect.php" ?>
<?php
    $stmt = $pdo->prepare("DELETE FROM product WHERE pid=?");
    $stmt->bindParam(1, $_GET["pid"]); 
    if ($stmt->execute()) 
    header("location: HW13_1.php"); 
?>
