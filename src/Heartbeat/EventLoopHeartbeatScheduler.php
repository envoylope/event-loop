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

namespace Envoylope\EventLoop\Heartbeat;

use Asmblah\PhpAmqpCompat\Bridge\Connection\AmqpConnectionBridgeInterface;
use Asmblah\PhpAmqpCompat\Driver\Common\Heartbeat\HeartbeatTransmitterInterface;
use Asmblah\PhpAmqpCompat\Scheduler\Heartbeat\HeartbeatSchedulerInterface;
use React\EventLoop\LoopInterface;
use React\EventLoop\TimerInterface;
use SplObjectStorage;

/**
 * Class EventLoopHeartbeatScheduler.
 *
 * Uses a ReactPHP event loop to allow regular heartbeat scheduling.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class EventLoopHeartbeatScheduler implements HeartbeatSchedulerInterface
{
    /**
     * @var SplObjectStorage<AmqpConnectionBridgeInterface, TimerInterface>
     */
    private SplObjectStorage $connectionBridgeToTimerMap;

    public function __construct(
        private readonly LoopInterface $loop,
        private readonly HeartbeatTransmitterInterface $heartbeatTransmitter
    ) {
        $this->connectionBridgeToTimerMap = new SplObjectStorage();
    }

    /**
     * @inheritDoc
     */
    public function register(AmqpConnectionBridgeInterface $connectionBridge): void
    {
        $interval = $connectionBridge->getHeartbeatInterval();

        $timer = $this->loop->addPeriodicTimer($interval, function () use ($connectionBridge) {
            $this->heartbeatTransmitter->transmit($this, $connectionBridge);
        });

        $this->connectionBridgeToTimerMap->attach($connectionBridge, $timer);
    }

    /**
     * @inheritDoc
     */
    public function unregister(AmqpConnectionBridgeInterface $connectionBridge): void
    {
        $timer = $this->connectionBridgeToTimerMap[$connectionBridge];

        $this->loop->cancelTimer($timer);
    }
}
