<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Scheduler\Messenger;

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Transport\TransportInterface;
use Symfony\Component\Scheduler\Exception\LogicMessengerException;
use Symfony\Component\Scheduler\Schedule\ScheduleInterface;

class ScheduleTransport implements TransportInterface
{
    private readonly array $stamps;

    public function __construct(
        private readonly ScheduleInterface $schedule,
    ) {
        $this->stamps = [new ScheduledStamp()];
    }

    public function get(): iterable
    {
        foreach ($this->schedule->getMessages() as $message) {
            yield new Envelope($message, $this->stamps);
        }
    }

    public function ack(Envelope $envelope): void
    {
        // ignore
    }

    public function reject(Envelope $envelope): void
    {
        throw new LogicMessengerException('Messages from ScheduleTransport must not be rejected.');
    }

    public function send(Envelope $envelope): Envelope
    {
        throw new LogicMessengerException('The ScheduleTransport cannot send messages.');
    }
}