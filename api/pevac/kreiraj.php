<?php
include '../../logika/controller.php';
include '../../logika/dbbroker.php';
include '../../logika/ZanrServis.php';
include '../../logika/PevacServis.php';
include '../../logika/PesmaServis.php';

$controller=Controller::getController();
$controller->obradiZahtev('kreirajPevaca');
?>