<?php

/*
 * Envoylope ReactPHP EventLoop heartbeat scheduler.
 * Copyright (c) Dan Phillimore (asmblah)
 * https://github.com/envoylope/event-loop/
 *
 * Released under the MIT license.
 * https://github.com/envoylope/event-loop/raw/main/MIT-LICENSE.txt
 */

declare(strict_types=1);

use Nytris\Boot\BootConfig;
use Nytris\Boot\PlatformConfig;
use Nytris\Nytris;
use Tasque\Core\Scheduler\ContextSwitch\NTockStrategy;
use Tasque\EventLoop\TasqueEventLoopPackage;
use Tasque\TasquePackage;

require_once __DIR__ . '/../vendor/autoload.php';

Mockery::getConfiguration()->allowMockingNonExistentMethods(false);
Mockery::globalHelpers();

Mockery::getConfiguration()->allowMockingNonExistentMethods(false);
Mockery::globalHelpers();

$bootConfig = new BootConfig(new PlatformConfig(dirname(__DIR__) . '/var/nytris/'));
$bootConfig->installPackage(new TasquePackage(new NTockStrategy(1)));
$bootConfig->installPackage(new TasqueEventLoopPackage());

Nytris::boot($bootConfig);
