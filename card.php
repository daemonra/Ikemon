<?php
require_once("common.php");

if (!isset($_GET['name'])) {
    header("Location: index.php");
    exit();
}

$card = $cards->findOne(['name' => $_GET['name']]);
?>

<?php
    finalHeader();
?>


<section class="container mt-4 card-details fire-element">
    <h2 class="text-dark">Pokemon Card Details</h2>

    <div class="row">
        <div class="col-md-4">
            <div class="card <?= $card['type'] ?>">
                <div class="card-image" style="background-image: url('<?php echo $card["image"] ?>') !important; "></div>
                <div class="card-text">
                    <h2 class="card-name"><?php echo $card["name"];?></h2>
                    <p class="card-type">🔖 <?php echo $card["type"];?></p>
                    <p class="card-abilites">❤️ <span class="card-hp"><?php echo $card["hp"];?></span> ⚔️ <span class="card-ap"><?php echo $card["attack"];?></span> 🛡️ <span class="card-dp"><?php echo $card["defense"];?></span></p>
                    <p class="card-price">💰 $<span class="price"><?php echo $card["price"];?></span></p>

                    <?php if ($logged && !$isAdmin ) { ?>
                        <?php if ($card['owner'] != $userData['username']) { ?>
                            <p class="card-buy"><a href="buy.php?name=<?= $card['name'] ?>" class="btn btn-primary"> Buy </a></p>
                        <?php } else { ?>
                            <p class="card-buy"><a href="sell.php?name=<?= $card['name'] ?>" class="btn btn-primary"> Sell </a></p>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="col-md-8" style="padding: 30px;">
            <h3><?php echo $card["name"];?></h3>
            
            <p><strong>Health Point:</strong> <?php echo $card["hp"];?></p>
            <p><strong>Type:</strong> <?php echo $card["type"];?></p>
            <p><strong>Attack Power:</strong> <?php echo $card["attack"];?></p>
            <p><strong>Defense Power:</strong> <?php echo $card["defense"];?></p>
            <p><strong>Card Price:</strong> $<?php echo $card["price"];?></p>
            <p><strong>Description:</strong> <?php echo $card["description"];?></p>
            <p><strong>Owner:</strong> <a href="user.php?username=<?= $card['owner'] ?>"><?php echo $card["owner"];?></a></p>
        </div>
    </div>
</section>


<?php
footer();
?>