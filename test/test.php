<?php

require_once __DIR__ . '/../vendor/autoload.php';

(new Wilon\Exception\Handler)
    ->setLogger('exceptions', __DIR__ . '/../exceptions.log')
    ->bootstrap(-1, 'testing');

echo $test;

class test
{
    function echo($str)
    {
        throw new Exception("Error Processing Request", 1);
    }
}

$tt = new test;
$tt->echo(233);