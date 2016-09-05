<?php

$ueli = new \Jass\Entity\Player("Ueli");
$sandy = new \Jass\Entity\Player("Sandy");
$heinz = new \Jass\Entity\Player("Heinz");
$peter = new \Jass\Entity\Player("Peter");

$teamUeliAndHeinz = new \Jass\Entity\Team('Ueli and Heinz');
$teamSandyAndPeter = new \Jass\Entity\Team('Sandy and Peter');

$ueli->team = $teamUeliAndHeinz;
$ueli->nextPlayer = $sandy;

$sandy->team = $teamSandyAndPeter;
$sandy->nextPlayer = $heinz;

$heinz->team = $teamUeliAndHeinz;
$heinz->nextPlayer = $peter;

$peter->team = $teamSandyAndPeter;
$peter->nextPlayer = $ueli;

$players = [$ueli, $sandy, $heinz, $peter];
$teams = [$teamUeliAndHeinz, $teamSandyAndPeter];

return [$teams, $players];