<?php

use Jass\Hand;

class HandTest extends \PHPUnit\Framework\TestCase
{
    public function testBockFunction()
    {
        $game = new \Jass\GameStyle\TopDown();
        $orderFunction = [$game, 'orderValue'];
        $suit = \Jass\Entity\Card\Suit::ROSE;


        $cards = Hand\suit(\Jass\CardSet\jassSet(), $suit);

        $played = [];

        $expected = array_pop($cards);
        $this->assertEquals($expected, Hand\bock($played, $suit, $orderFunction));

        $played[] = $expected;

        $expected = array_pop($cards);
        $this->assertEquals($expected, Hand\bock($played, $suit, $orderFunction));

        $played[] = $cards[4];

        $this->assertEquals($expected, Hand\bock($played, $suit, $orderFunction));

    }

    public function testPotentialFunction()
    {
        $game = new \Jass\GameStyle\TopDown();
        $orderFunction = [$game, 'orderValue'];
        $suit = \Jass\Entity\Card\Suit::ROSE;

        $hand = \Jass\CardSet\jassSet();

        // 9 cards + bock in 0 cards
        $this->assertEquals(109, Hand\potential([], $hand, $suit, $orderFunction));

        $hand = Hand\suit($hand, $suit);
        // 9 cards + bock in 0 cards
        $this->assertEquals(109, Hand\potential([], $hand, $suit, $orderFunction));

        $hand = Hand\ordered($hand, $orderFunction);

        // remove lowest card
        array_pop($hand);

        // 8 cards + bock in 0 cards
        $this->assertEquals(108, Hand\potential([], $hand, $suit, $orderFunction));

        // get ace out of hand
        $ace = array_shift($hand);

        // 7 cards + bock in 1 cards (9)
        $this->assertEquals(97, Hand\potential([], $hand, $suit, $orderFunction));

        // 7 cards + bock in 0 cards
        $this->assertEquals(107, Hand\potential([$ace], $hand, $suit, $orderFunction));

        $king = array_shift($hand);
        $queen = array_shift($hand);

        // 5 cards + bock in 3 cards
        $this->assertEquals(75, Hand\potential([], $hand, $suit, $orderFunction));

        // 1 card + no bock
        $this->assertEquals(1, Hand\potential([], [$king], $suit, $orderFunction));

        // 2 card + no bock
        $this->assertEquals(2, Hand\potential([], [$queen, $hand[0]], $suit, $orderFunction));

        $this->assertEquals(92, Hand\potential([$ace], [$queen, $hand[0]], $suit, $orderFunction));



    }
}