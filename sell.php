<?php
require_once("common.php");

if ((!isset($_GET['name']) || !$logged) && !$isAdmin) {
    header("Location: index.php");
    exit();
}

$card = $cards->findOne(['name' => $_GET['name']]);

if ($card['owner'] == $userData['username']) {

    $card['owner'] = "admin";
    $userData['money'] += $card['price']*0.9;
    $userData['cards'] -= 1;
    $users->update($userData['username'], $userData);
    $cards->update($card['name'], $card);

    header("Location: user.php?username=".$userData['username']."&sold=1");
    exit();

} else {
    header("Location: user.php?username=".$userData['username']."&sold=0");
    exit();
}
?>


