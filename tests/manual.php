<?php

require ("../vendor/autoload.php");


echo "Hoi.\n";

$dealer = new \Jass\Service\DealerService();
$set = \Jass\Service\SetService::getJassSet();

$hans = new \Jass\Entity\Player();
$hans->name = "Hans";

$fridolin = new \Jass\Entity\Player();
$fridolin->name = "Fridolin";

$fritz = new \Jass\Entity\Player();
$fritz->name = "Fritz";

$heidi = new \Jass\Entity\Player();
$heidi->name = "Heidi";

$players = [$hans, $fridolin, $fritz, $heidi];

$players = $dealer->deal($set, $players);

$simplePlayerStrategy = new \Jass\Player\Random();
$topDownGame = new \Jass\Game\TopDown();


echo "First Round, Obe Abe\n";

$turns = [];
foreach ($players as $player) {
    $turns = $simplePlayerStrategy->play($player, $turns);
}

foreach ($turns as $turn) {
    echo (string) $turn->player . " plays " . (string) $turn->card . "\n";
}

$winner = $topDownGame->getWinningTurn($turns);

echo "Winner of the turn is " . $winner->player->name . "\n";