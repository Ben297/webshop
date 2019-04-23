<h1>Labby Shop</h1>

<?php
foreach($this->_['products'] as $product) {
    ?>

    <h2><a href="?view=entry&id=<?php echo $product['id'] ?>"><?php echo $product['name']; ?></a></h2>

    <p><?php echo $product['description']; ?></p>

    <?php
}
    ?>