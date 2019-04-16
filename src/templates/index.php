<?php /*zur Zeit nicht genutzt */ ?>


<h1>Product Overview</h1>

<?php
foreach($this->_['products'] as $product){
?>

<h2><a href="?view=product&id=<?php echo $product['id'] ?>"><?php echo $product['name']; ?></a>
</h2>
<p><?php echo $product['description']; ?></p>

<?php
        }
?>