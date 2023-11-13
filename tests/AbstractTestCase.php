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

namespace Envoylope\EventLoop\Tests;

use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase as PhpUnitTestCase;

/**
 * Class AbstractTestCase.
 *
 * Base class for all test cases.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
abstract class AbstractTestCase extends PhpUnitTestCase
{
    use MockeryPHPUnitIntegration;
}
