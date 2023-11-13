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

namespace Envoylope\EventLoop\Tests\Functional\Heartbeat;

use AMQPConnection;
use Asmblah\PhpAmqpCompat\AmqpManager;
use Asmblah\PhpAmqpCompat\Configuration\Configuration;
use Envoylope\EventLoop\EventLoopSchedulerFactory;
use Envoylope\EventLoop\Tests\Functional\AbstractFunctionalTestCase;
use PhpAmqpLib\Exception\AMQPHeartbeatMissedException;
use Tasque\EventLoop\TasqueEventLoop;

/**
 * Class ClientHeartbeatUsingEventLoopSchedulerTest.
 *
 * Checks connection heartbeat handling when the client fails to send its own heartbeats
 * nor check for server heartbeats on a real connection to a real AMQP broker server
 * when EventLoopHeartbeatScheduler is in use.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class ClientHeartbeatUsingEventLoopSchedulerTest extends AbstractFunctionalTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        AmqpManager::setAmqpIntegration(null);
        AmqpManager::setConfiguration(new Configuration(
            schedulerFactory: new EventLoopSchedulerFactory()
        ));
    }

    public function tearDown(): void
    {
        parent::tearDown();

        AmqpManager::setAmqpIntegration(null);
        AmqpManager::setConfiguration(null);
    }

    public function testMissedClientHeartbeatIsHandledCorrectly(): void
    {
        $amqpConnection = new AMQPConnection(['heartbeat' => 1]);
        $amqpConnection->connect();

        $this->expectException(AMQPHeartbeatMissedException::class);

        // Block heartbeats from being processed.
        sleep(5);

        TasqueEventLoop::getEventLoopThread()->join();
    }
}
