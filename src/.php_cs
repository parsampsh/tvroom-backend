<?php

$finder = PhpCsFixer\Finder::create()
    ->files()
    ->in(__DIR__)
    ->name('*.php');

return PhpCsFixer\Config::create()
    ->setUsingCache(true)
    ->setRiskyAllowed(true)
    ->setFinder($finder);
