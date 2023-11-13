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

namespace Envoylope\EventLoop;

use Asmblah\PhpAmqpCompat\Driver\Common\Heartbeat\HeartbeatTransmitterInterface;
use Asmblah\PhpAmqpCompat\Scheduler\Factory\SchedulerFactoryInterface;
use Asmblah\PhpAmqpCompat\Scheduler\Heartbeat\HeartbeatSchedulerInterface;
use Envoylope\EventLoop\Heartbeat\EventLoopHeartbeatScheduler;
use React\EventLoop\Loop;

/**
 * Class EventLoopSchedulerFactory.
 *
 * Uses a ReactPHP event loop to allow regular heartbeat scheduling.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class EventLoopSchedulerFactory implements SchedulerFactoryInterface
{
    /**
     * @inheritDoc
     */
    public function createScheduler(HeartbeatTransmitterInterface $heartbeatTransmitter): HeartbeatSchedulerInterface
    {
        return new EventLoopHeartbeatScheduler(Loop::get(), $heartbeatTransmitter);
    }
}
