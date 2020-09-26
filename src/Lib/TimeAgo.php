<?php


namespace AlirezaH\LaravelDevTools\Lib;


use DateTime;
use DateTimeZone;
use DateInterval;

class TimeAgo
{
    private const TIME_UNIT_YEAR = 'year';
    private const TIME_UNIT_MONTH = 'month';
    private const TIME_UNIT_WEEK = 'week';
    private const TIME_UNIT_DAY = 'day';
    private const TIME_UNIT_HOUR = 'hour';
    private const TIME_UNIT_MINUTE = 'minute';
    private const TIME_UNIT_SECOND = 'second';

    private const AGO_POSTFIX = ' ago';
    private const JUST_NOW = ' Just Now';

    public function getTimeAgo(DateTime $dateTime, $level = 1, string $timeZone = 'Asia/Tehran'): array
    {
        $dateTimeZone = new DateTimeZone($timeZone);
        $now = new DateTime('now', $dateTimeZone);
        $ago = $dateTime->setTimezone($dateTimeZone);
        $diff = $now->diff($ago);

        $diffDays = (float)$diff->format("%R%a");

        if ($diffDays == -1) {
            return ['yesterday' => 'yesterday'];
        }

        if ($diffDays >= +1) {
            return ['scheduled' => 'scheduled'];
        }

        $timeAgo = [];
        foreach ($this->getDifferences($diff) as $key => $value) {
            if ($value) {
                $timeAgo[$key] = $value;
            }
        }

        return array_slice($timeAgo, 0, $level);
    }

    public function getTimeDifference(DateTime $startDateTime, DateTime $endDateTime, $level = 2): array
    {
        $diff = $endDateTime->diff($startDateTime);
        $timeDiff = [];
        foreach ($this->getDifferences($diff) as $key => $value) {
            if ($value) {
                $timeDiff[$key] = $value;
            }
        }

        return array_slice($timeDiff, 0, $level);
    }

    public function getTimeAgoString(DateTime $dateTime, $level = 1, string $timeZone = 'Asia/Tehran'): string
    {
        return $this->flatten($this->getTimeAgo($dateTime, $level, $timeZone));
    }

    public function getTimeDifferenceString(DateTime $startDateTime, DateTime $endDateTime, $level = 2): string
    {
        return $this->flatten($this->getTimeDifference($startDateTime, $endDateTime, $level));
    }

    private function getDifferences(DateInterval $diff)
    {
        $weeks = (int)floor($diff->d / 7);
        $days = $diff->d - ($weeks * 7);

        return [
            self::TIME_UNIT_YEAR => $diff->y,
            self::TIME_UNIT_MONTH => $diff->m,
            self::TIME_UNIT_WEEK => $weeks,
            self::TIME_UNIT_DAY => $days,
            self::TIME_UNIT_HOUR => $diff->h,
            self::TIME_UNIT_MINUTE => $diff->i,
            self::TIME_UNIT_SECOND => $diff->s,
        ];
    }

    private function flatten(array $timeAgo, bool $shorten = true): string
    {
        if (in_array(current($timeAgo), ['yesterday', 'scheduled'])) {
            return current($timeAgo);
        }

        return !empty($timeAgo) ?
            array_reduce(array_keys($timeAgo), function ($result, $value) use ($timeAgo, $shorten) {
            return $result . (!empty($result) ? ', ' : '')
                . $timeAgo[$value] . ' '
                . ($shorten ? $value[0] : $value)
                . (!$shorten && $timeAgo[$value] > 1 ? 's' : '');
        }) . self::AGO_POSTFIX : self::JUST_NOW;
    }
}
