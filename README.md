Jass
====

A small experiment how much it takes to teach the computer to play Jass (a Swiss card game) in PHP.

It is very very basic and should be structured quite differently, probably. But it was quite quick to write and you could extend it a lot now...

Run it yourself
---------------
```
git clone git@github.com:urbanetter/jass.git
cd jass
composer dumpautoload
php tests/manual.php
```

Some simple tests
-----------------

I've run 50 x 1000 games with the strategies implemented. All players use the smae strategy.
The numbers show how many times the starting player wins using the given strategy.

| Strategy | How many games the strategy wins out of 1000 |
-----------------------------------------------------------
| Dumb     | 485                                          |
| Simple   | 428                                          |
-----------------------------------------------------------