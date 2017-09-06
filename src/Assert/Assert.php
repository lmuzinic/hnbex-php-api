<?php
declare(strict_types=1);

namespace Hnbex\Assert;


class Assert
{
    public static function date(\DateTimeInterface $date)
    {
        $start = new \DateTimeImmutable('1994-05-30');
        $end = new \DateTimeImmutable('today');

        $interval = $start->diff($date);
        if ($interval->invert === 1) {
            throw new \InvalidArgumentException('Date should be between 1994-05-30 and today');
        }

        $interval = $date->diff($end);
        if ($interval->invert === 1) {
            throw new \InvalidArgumentException('Date should be between 1994-05-30 and today');
        }
    }
}
