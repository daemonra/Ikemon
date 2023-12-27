<?php
require_once("common.php");

if (isset($_GET['username'])) {
    $u = $users->findById($_GET['username']);
} else if ($logged) {
    $u = $userData;
} else {
    header("Location: index.php");
    exit();
}

$cardsArr = $cards->findAll(['owner' => $u['username']]);


finalHeader();
?>

<?php if (isset($_GET['sold'])) { ?>
    <?php if ($_GET['sold'] == '1') { ?>
        <section class="userdata-dis bg-success">
            <div class="text-center">Card sold successfully!</div>
        </section>
    <?php } else { ?>
        <section class="userdata-dis bg-danger">
            <div class="text-center">Something went wrong. You can't sell this card!</div>
        </section>
    <?php }  ?>
<?php } ?>

<section class="container mt-4 card-details fire-element">
    <h2 class="text-dark">User Details</h2>

    <div class="row" style="padding: 30px 0;">
        <div class="col-md-4">
            <img src="assets/profile.jpg" alt="" style="max-width: 200px;">
        </div>
        <div class="col-md-8" style="padding: 30px;">
            
            <p><strong>Username:</strong> <?php echo $u["username"];?></p>
            <p><strong>Email:</strong> <?php echo $u["email"];?></p>
            <p><strong>Money:</strong> <?php echo $u["money"];?></p>
        </div>
    </div>
</section>

<section class="container mt-4 text-center">
    <h2 class="text-dark"><?php echo $u['username']."'s" ?> Cards</h2>
    <div class="row">

        <?php foreach ($cardsArr as $id => $card):
                // foreach ($u['cards'] as $id => $cardName):
                // $card = array_values($cards->findAllByName($cardName))[0];
        ?>
            <div class="card <?= $card['type'] ?>">
                <div class="card-image" style="background-image: url('<?php echo $card["image"] ?>') !important; " onclick="window.location.href='card.php?name=<?php echo $card['name']; ?>'"></div>
                <div class="card-text">
                    <h2 class="card-name"><?php echo $card["name"];?></h2>
                    <p class="card-type">🔖 <?php echo $card["type"];?></p>
                    <p class="card-abilites">❤️ <span class="card-hp"><?php echo $card["hp"];?></span> ⚔️ <span class="card-ap"><?php echo $card["attack"];?></span> 🛡️ <span class="card-dp"><?php echo $card["defense"];?></span></p>
                    <p class="card-price">💰 $<span class="price"><?php echo $card["price"];?></span></p>

                    <?php if ($logged && !$isAdmin) { ?>
                        <p class="card-buy"><a href="sell.php?name=<?= $card['name'] ?>" class="btn btn-primary"> Sell </a></p>
                    <?php } ?>
                </div>
            </div>
        <?php endforeach ?>

    </div>
</section>


<?php
footer();
?>