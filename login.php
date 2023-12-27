<?php
require_once("common.php");

if ($logged) {
    header("Location: index.php");
    die();
}

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if(count($_POST) > 0) {
    $errors = [];
    if(trim($username) === '')
        $errors['username'] = 'username is required!';

    if(trim($password) === '')
        $errors['password'] = 'password is required!';

    if($users->findById($username) == NULL)
        $errors['username'] = 'username does not exist!';
    else if ($users->findById($username)['password'] != $password)
        $errors['password'] = 'Wrong password!';

    $errors = array_map(fn($e) => "<span style='color: red'> $e </span>", $errors);

    if (count($errors) == 0) {
        $_SESSION['username'] = $username;
        header("Location: index.php");
        exit();
    }       
}

?>

<?php finalHeader(); 
?>
<section class="container mt-4">
    <h2 class="text-dark">Login</h2>
    <form action="login.php" method="post">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" value="">  <?= $errors['username'] ?? '' ?> <br>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" value="">  <?= $errors['password'] ?? '' ?> <br>
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
    </form>
</section>

<?php
footer();
?>