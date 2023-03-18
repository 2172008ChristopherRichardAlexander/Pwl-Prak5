<?php
function login($email, $password)
{
    $link = createMySQLConnection();
    $query = "SELECT id, name, emal FORM user WHERE emal = ? AND password = ?";
    $stmt = $link -> prepare($query);
    $stmt -> bindParam(1,$email);
    $stmt -> bindParam(2,$password);
    $stmt -> execute();
    $user = $stmt->fetch();
    $link = null;
    return $user;
}
?>
