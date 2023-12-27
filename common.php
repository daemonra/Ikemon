<?php
session_start();

require("storage.php");
$users = new Storage(new JsonIO("./data/users.json"));
#$log = new JsonIO("./data/log.json");
$cards = new Storage(new JsonIO("./data/cards.json"));
$logged = isset($_SESSION['username']) ? true : false;
if ($logged) {
    $isAdmin = $_SESSION['username'] == "admin" ? true : false; 
    $userData = $users->findById($_SESSION['username']);   
}

function finalHeader() {

    if (!isset($_SESSION['username']))
        headerNotLoggedIn();
    else 
        headerLoggedIn();
}


function headerNotLoggedIn() {
    echo '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Pokémons Store</title>
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/style.css">
    </head>
    <body>
    
    <!-- Your content goes here -->
    <header class="bg-dark text-white text-center py-4">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 text-left">
                    <h1 class="" style="font-size: 1.5rem;"><a href="index.php" class="text-white">Pokémons Store</a></h1>
                </div>
                <div class="col-md-6 text-right plus-padding">
                    <nav>
                        <ul class="list-inline">
                            <li class="list-inline-item"><a href="login.php" class="text-white">Login</a></li>
                            <li class="list-inline-item"><a href="register.php" class="text-white">Register</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </header>';
}

function headerLoggedIn() {
    echo '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Pokémons Store</title>
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/style.css">
    </head>
    <body>
    
    <!-- Your content goes here -->
    <header class="bg-dark text-white text-center py-4">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 text-left">
                    <h1 class="" style="font-size: 1.5rem;"><a href="index.php" class="text-white">Pokémons Store</a></h1>
                </div>
                <div class="col-md-6 text-right plus-padding">
                    <nav>
                        <ul class="list-inline">
                            <li class="list-inline-item"><a href="user.php" class="text-white">Profile</a></li>
                            <li class="list-inline-item"><a href="logoff.php" class="text-white">Log off</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </header>';
}

function footer() {
        echo '
        <footer>
            <div class="text-center">
            Pokemon Store | Copyright &copy; 2023
            </div>
        </footer>
        <!-- Bootstrap JS and Popper.js (optional) -->
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        
        </body>
        </html>
        ';
}
?>
