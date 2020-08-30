<?php
require __DIR__ . '/vendor/autoload.php';

return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet(\App\Services\Doctrine::getInst()->getEm());
