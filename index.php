<?php
// unsere Klassen einbinden
include('webshop/src/controller/controller.php');
include('webshop/src/model/modelProduct.php');
include('webshop/src/view/view.php');

// $_GET und $_POST zusammenfasen
$request = array_merge($_GET, $_POST);
// Controller erstellen
$controller = new Controller($request);
// Inhalt der Webanwendung ausgeben.
echo $controller->display();
?>
