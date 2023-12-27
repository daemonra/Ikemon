<?php
require_once("common.php");


// $adminCards = $users->findById("admin")['cards'];
$cardsArr = $cards->findAll();

finalHeader();
?>

<?php if ($logged) { ?>
<section class="userdata-dis">
    <div class="text-center">Hi, <a class="text-white" href="user.php?username=<?= $userData['username'] ?>"><?= $userData['username'] ?></a> - Your Balance: $<?= $userData['money'] ?></div>
</section>
<?php } ?>

<?php if (isset($_GET['bought'])) { ?>
    <section class="userdata-dis <?php if ($_GET['bought'] == '1') echo "bg-success"; else echo "bg-danger"; ?>">
        <div class="text-center">
            <?php
                if ($_GET['bought'] == '0')
                    if (isset($_GET['limit']) && $_GET['limit'] == '1') 
                        echo "You already have 5 cards, Please sell some to be able to buy again!";
                    else if (isset($_GET['admin']) && $_GET['admin'] == '1') 
                        echo "Someone already bought this card!";
                    else if (isset($_GET['money']) && $_GET['money'] == '1') 
                        echo "Insufficient funds, can't buy this card!"; 
                    else
                        echo "Something went wrong!";
                
                else if ($_GET['bought'] == '1')
                    echo "Card acquired successfully, view in your <a class='text-white' href='user.php?username=".$userData['username']."'>profile</a>!";
            ?>
        </div>
    </section>
<?php } ?>

<section class="container mt-4 text-center">
    <h2 class="text-dark">Welcome to the Pokémons store</h2>
    <p class="text-secondary">These are our available Pokémons cards</p>
</section>

<section class="container mt-4 text-center">
    <h2 class="text-dark">Our Cards</h2>
    
    <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Type: <?= $_GET['filter'] ?? 'All' ?>
        </button>
        <?php
            if ($isAdmin) {
        ?>
                <a href="create.php" class="btn btn-primary">
                    Create new card
                </a> 
        
        <?php
            }
        ?>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" href="index.php">All</a>
            <a class="dropdown-item" href="index.php?filter=fire">Fire</a>
            <a class="dropdown-item" href="index.php?filter=electric">Electric</a>
            <a class="dropdown-item" href="index.php?filter=grass">Grass</a>
            <a class="dropdown-item" href="index.php?filter=water">Water</a>
            <a class="dropdown-item" href="index.php?filter=bug">Bug</a>
            <a class="dropdown-item" href="index.php?filter=normal">Normal</a>
            <a class="dropdown-item" href="index.php?filter=poison">Poison</a>
        </div>
    </div>

    <div class="row">

    <?php foreach ($cardsArr as $id => $card):
            // $card = array_values($cards->findAllByName($cardName))[0];
            if (isset($_GET['filter'])) {
                if ($card['type'] != $_GET['filter']) continue;
            }

        ?>
            <div class="card <?= $card['type'] ?>">
                <div class="card-image" style="background-image: url('<?php echo $card["image"] ?>') !important; " onclick="window.location.href='card.php?name=<?php echo $card['name']; ?>'"></div>
                <div class="card-text">
                    <h2 class="card-name"><?php echo $card["name"];?></h2>
                    <p class="card-type">🔖 <?php echo $card["type"];?></p>
                    <p class="card-abilites">❤️ <span class="card-hp"><?php echo $card["hp"];?></span> ⚔️ <span class="card-ap"><?php echo $card["attack"];?></span> 🛡️ <span class="card-dp"><?php echo $card["defense"];?></span></p>
                    <p class="card-price">💰 $<span class="price"><?php echo $card["price"];?></span></p>

                    <?php if ($logged && !$isAdmin && $card['owner'] != $userData['username']) { ?>
                        <p class="card-buy"><a href="buy.php?name=<?= $card['name'] ?>" class="btn btn-primary"> Buy </a></p>
                    <?php } ?>
                </div>
            </div>
    <?php endforeach ?>

    </div>
</section>

<?php
footer();
?>

