<?php 
require_once("common.php");

if (!$isAdmin) {
    header("Location: index.php");
    die();
}

$cardname = $_POST['cardname'] ?? '';
$type = $_POST['type'] ?? '';
$hp = $_POST['health'] ?? '';
$attack = $_POST['attack'] ?? '';
$defense = $_POST['defense'] ?? '';
$price = $_POST['price'] ?? '';
$desc = $_POST['desc'] ?? '';
$image = $_POST['image'] ?? '';

$cardsArr = $cards->findAll();

if(count($_POST) > 0) {
    $errors = [];

    if(trim($cardname) === '')
        $errors['cardname'] = 'Card name is required!';
    else if(count(explode(' ', trim($cardname))) > 1)
        $errors['cardname'] = 'the card name should be one word!';
    else if (array_search($cardname, array_map(fn($card) => $card['name'], $cardsArr)))
        $errors['cardname'] = 'Card name exists already!';

    if(trim($type) === '')
        $errors['type'] = 'Card type is required!';
    else if (!array_search($type, array_map(fn($card) => $card['type'], $cardsArr)))
        $errors['type'] = 'Card type is not valid!';

    if(filter_var($hp, FILTER_VALIDATE_INT) === false){
        $errors['health'] = 'Health points must be an integer';
    }else{
        $hp = intval($hp);
        if( $hp < 1 && $hp > 100) $errors['health'] = 'Health points must be between 1 and 100';
    }

    if(filter_var($attack, FILTER_VALIDATE_INT) === false){
        $errors['attack'] = 'Attack power must be an integer';
    }else{
        $attack = intval($attack);
        if( $attack < 1 && $attack > 100) $errors['attack'] = 'Attack power must be between 1 and 100';
    }

    if(filter_var($defense, FILTER_VALIDATE_INT) === false){
        $errors['defense'] = 'Defense power must be an integer';
    }else{
        $defense = intval($defense);
        if( $defense < 1 && $defense > 100) $errors['defense'] = 'Defense power must be between 1 and 100';
    }

    if(filter_var($price, FILTER_VALIDATE_INT) === false){
        $errors['price'] = 'price must be an integer';
    }else{
        $price = intval($price);
        if( $price < 1 && $price > 1000) $errors['price'] = 'price must be between 1 and 1000';
    }

    if(trim($desc) === '')
        $errors['desc'] = 'Card description is required!';

    if(filter_var($image, FILTER_VALIDATE_URL) === false)
        $errors['image'] = 'Image must be a working url';


    $errors = array_map(fn($e) => "<span style='color: red'> $e </span>", $errors);

    if (count($errors) == 0) {
        //echo 'doce';
        $newCard = [
            'name' => $cardname,
            'type' => $type,
            'hp' => $hp,
            'attack' => $attack,
            'defense' => $defense,
            'price' => $price,
            'description' => $desc,
            'image' => $image,
            'owner' => "admin"
        ];
        $cards->addCard($newCard);
        // array_push($userData['cards'], $newCard['name']);
        // $users->update($userData['username'], $userData);
        header("Location: card.php?name=".$newCard['name']);
        exit();
    }
}

?>

<?php
    finalHeader();
?>
<section class="container mt-4">
    <h2 class="text-dark">Create new card</h2>
    <form action="create.php" method="post">
        <div class="form-group">
            <label for="cardname">Card Name:</label>
            <input type="text" class="form-control" id="cardname" name="cardname" placeholder="Pikachu" value=""> <?= $errors['cardname'] ?? '' ?> <br>
        </div>
        <div class="form-group">
            <label for="type">Type:</label>
            <input type="text" class="form-control" id="type" name="type" placeholder="Grass" value=""> <?= $errors['type'] ?? '' ?> <br>
        </div>
        <div class="form-group">
            <label for="health">Health Points:</label>
            <input type="text" class="form-control" id="health" name="health" placeholder="90" value=""> <?= $errors['health'] ?? '' ?> <br>
        </div>
        <div class="form-group">
            <label for="attack">Attack Power:</label>
            <input type="text" class="form-control" id="attack" name="attack" placeholder="20" value=""> <?= $errors['attack'] ?? '' ?> <br>
        </div>
        <div class="form-group">
            <label for="defense">Defense Power:</label>
            <input type="text" class="form-control" id="defense" name="defense" placeholder="20" value=""> <?= $errors['defense'] ?? '' ?> <br>
        </div>
        <div class="form-group">
            <label for="price">Price:</label>
            <input type="text" class="form-control" id="price" name="price" placeholder="499" value=""> <?= $errors['price'] ?? '' ?> <br>
        </div>
        <div class="form-group">
            <label for="desc">Description:</label>
            <textarea type="text" class="form-control" id="desc" name="desc" placeholder="Description" value=""></textarea>  <?= $errors['desc'] ?? '' ?> <br>
        </div>
        <div class="form-group">
            <label for="image">Image url:</label>
            <input type="text" class="form-control" id="image" name="image" placeholder="google.com/" value="">  <?= $errors['image'] ?? '' ?> <br>
        </div>
        <button type="submit" class="btn btn-primary">Create</button>
    </form>
</section>

<?php
footer();
?>