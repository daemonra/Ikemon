<?php
require_once("common.php");

if ((!isset($_GET['name']) || !$logged) && !$isAdmin) {
    header("Location: index.php");
    exit();
}

$card = $cards->findOne(['name' => $_GET['name']]);

if ($card['owner'] != $userData['username']) {

    if ($userData['cards'] > 4) {
        header("Location: index.php?bought=0&limit=1");
        exit();
    } else if ($userData['money'] < $card['price']) {
        header("Location: index.php?bought=0&money=1");
        exit();
    } else if ($card['owner'] != "admin") {
        header("Location: index.php?bought=0&admin=1");
        exit();
    }
        
    $card['owner'] = $userData['username'];
    $userData['money'] -= $card['price'];
    $userData['cards'] += 1;
    $users->update($userData['username'], $userData);
    $cards->update($card['name'], $card);

    header("Location: index.php?bought=1");
    exit();

} else {
    header("Location: index.php?bought=0");
    exit();
}
?>


