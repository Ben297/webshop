<?php /*Default Template - Rendert alle Elemente "Produkte" - diese kommen aus der Methode "getProducts" im Model */ ?>

<h1><?php echo $this->_['title']; ?><h1>

<?php foreach($this->_['products'] as $product) {
?>
    <h2><?php echo print_r(json_encode($product)) ?></h2>
    <h2><?php echo print_r($product, true) ?></h2>
<?php
}
?>

<a href="?view=default">Zurück zur &Uuml;bersicht</a>