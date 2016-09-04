<?php

use Jass\Entity\Game;
use Jass\CardSet;
use Jass\Entity\Trick;
use Jass\Table;

require (__DIR__ . "/../vendor/autoload.php");

echo "Hoi.\n";

$game = new Game();

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

$cardSet = CardSet\jassSet();
Table\deal($cardSet, $players);

$gameStyle = new \Jass\GameStyle\TopDown();
$strategy = new \Jass\Player\Simple();

$trick = new Trick();
$player = $gameStyle->beginningPlayer($players);

while(!\Jass\Trick\isFinished($trick, $players)) {
    $card = $strategy->nextCard($gameStyle, $trick, $player);

    echo $player . " plays " . $card . "\n";

    \Jass\Player\playTurn($trick, $player, $card);

    $player = $player->nextPlayer;
}

$player = \Jass\Trick\winner($trick, $gameStyle);

echo "winner is " . $player . "\n";