<?php

require (__DIR__ . "/../vendor/autoload.php");

$cards = \Jass\CardSet\jassSet();
shuffle($cards);

file_put_contents(__DIR__ . "/../data/fixedSet.serialized", serialize($cards));
