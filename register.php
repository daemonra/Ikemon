<?php 
require_once("common.php");

if ($logged) {
    header("Location: index.php");
    die();
}

$username = $_POST['username'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$password2 = $_POST['passwordRepeat'] ?? '';

$usersArr = $users->findAll();

if(count($_POST) > 0) {
    $errors = [];

    if(trim($username) === '')
        $errors['username'] = 'username is required!';
    else if(count(explode(' ', trim($username))) > 1)
        $errors['username'] = 'the username should be one word!';

    if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        $errors['email'] = 'The e-mail address is not valid';

    if(trim($password) === '' || trim($password2 === ''))
        $errors['password'] = 'password is required!';
    else if (strlen($password) < 8)
        $errors['password'] = 'password should at least be 8 charactars long!';
    else if ($password != $password2)
        $errors['password'] = 'passwords do not match!';


    if (count($errors) == 0)
        foreach ($usersArr as $id => $u):
            if ($u['username'] == $username) {
                $errors['username'] = 'username already in use! pick another!';
            } else if ($u['email'] == $email) {
                $errors['email'] = 'username already in use! pick another!';
            }
        endforeach;

    $errors = array_map(fn($e) => "<span style='color: red'> $e </span>", $errors);

    if (count($errors) == 0) {
        $newUser = [
            'username' => $username,
            'email' => $email,
            'password' => $password,
            'money' => 1000,
            'cards'=> []
        ];
        $users->addUser($newUser);
        $_SESSION['username'] = $newUser['username'];
        header("Location: index.php");
        exit();
    }
}



?>

<?php
    finalHeader();
?>
<section class="container mt-4">
    <h2 class="text-dark">Register</h2>
    <form action="register.php" method="post">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" value="">  <?= $errors['username'] ?? '' ?> <br>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" value=""> <?= $errors['email'] ?? '' ?> <br>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" value=""> <?= $errors['password'] ?? '' ?> <br>
        </div>
        <div class="form-group">
            <label for="passwordRepeat">Repeat Password:</label>
            <input type="password" class="form-control" id="passwordRepeat" name="passwordRepeat" placeholder="Repeat your password" value="">
        </div>
        <button type="submit" class="btn btn-primary">Register</button>
    </form>
</section>

<?php
footer();
?>