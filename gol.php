<?php

use Life\Game;

require './vendor/autoload.php';

$command = new \Commando\Command();

$command->option('i')
    ->aka('input')
    ->describe('Input XML file')
    ->require();

$command->option('o')
    ->aka('output')
    ->describe('Output XML file')
    ->default('out.xml');

$game = new Game();

$game->run($command['input'], $command['output']);
