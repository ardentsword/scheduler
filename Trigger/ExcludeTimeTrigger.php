<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Scheduler\Trigger;

final class ExcludeTimeTrigger implements TriggerInterface
{
    public function __construct(
        private readonly TriggerInterface $inner,
        private readonly \DateTimeImmutable $from,
        private readonly \DateTimeImmutable $to,
    ) {
    }

    public function nextTo(\DateTimeImmutable $run): \DateTimeImmutable
    {
        $nextRun = $this->inner->nextTo($run);
        if ($nextRun >= $this->from && $nextRun <= $this->to) {
            return $this->inner->nextTo($this->to);
        }

        return $nextRun;
    }
}
