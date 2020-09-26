<?php


namespace AlirezaH\LaravelDevTools\Lib\ErrorLogger;


use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Redis;
use Throwable;


class RedisErrorLogger extends ErrorLogger
{
    private const ERROR_LOGS = 'error_logs';
    private const ERROR_LOGS_PREVIEW_PREFIX = ':preview';
    private const ERROR_LOGS_COUNT_PREFIX = ':count';
    private const ERROR_LOGS_TIME_PREFIX = ':time';

    private const ERROR_LOGS_KEYS_PREFIX_ALL = [
        self::ERROR_LOGS_PREVIEW_PREFIX,
        self::ERROR_LOGS_COUNT_PREFIX,
        self::ERROR_LOGS_TIME_PREFIX,
    ];

    public function getError(string $id, string $type = 'error'): ErrorLogItem
    {
        return $this->getErrorLogItem(
            [
                'key' => $id,
                'type' => $type,
                'message' => Redis::hGet($this->getErrorRedisKey($type), $id),
                'count' => Redis::hGet($this->getCountRedisKey($type), $id),
                'timestamp' => Redis::hGet($this->getTimeRedisKey($type), $id),
                'preview' => Redis::hGet($this->getPreviewRedisKey($type), $id),
            ],
            true
        );
    }

    public function logError(Throwable $exception, string $type = 'error'): void
    {
        $id = $this->getId($exception);

        Redis::hSet($this->getErrorRedisKey($type), $id, substr($this->getErrorMessage($exception), 0, 300));
        Redis::hSet($this->getPreviewRedisKey($type), $id, $this->getPreview($exception));
        Redis::hSet($this->getTimeRedisKey($type), $id, time());

        $count = Redis::hGet($this->getCountRedisKey($type), $id) ?? 0;
        Redis::hSet($this->getCountRedisKey($type), $id, ++$count);
    }

    public function getAllErrors(string $type = 'error'): Collection
    {
        $errorLogs = [
            'errors' => Redis::hGetAll($this->getErrorRedisKey($type)),
            'counts' => Redis::hGetAll($this->getCountRedisKey($type)),
            'times' => Redis::hGetAll($this->getTimeRedisKey($type)),
        ];

        $errorLogItems = collect([]);
        foreach ($errorLogs['errors'] as $id => $errorLog) {
            $errorLogItems->push(
                $this->getErrorLogItem(
                    [
                        'key' => $id,
                        'type' => $type,
                        'message' => $errorLogs['errors'][$id],
                        'count' => $errorLogs['counts'][$id],
                        'timestamp' => $errorLogs['times'][$id],
                    ]
                )
            );
        }

        return $errorLogItems;
    }

    public function getErrorCount(Throwable $exception, string $type = 'error'): int
    {
        return Redis::hGet($this->getCountRedisKey($type), $this->getId($exception)) ?? 0;
    }

    public function remove(string $id, string $type = 'error'): void
    {
        foreach ($this->getAllRedisKeys($type) as $key) {
            Redis::hDel($key, $id);
        }
    }

    public function clear(string $type = 'error'): void
    {
        foreach ($this->getAllRedisKeys($type) as $key) {
            Redis::del($key);
        }
    }

    public function clearOld(string $type = 'error'): void
    {
        $allErrors = $this->getAllErrors($type);
        foreach ($allErrors['times'] as $id => $time) {
            $diff = now()->getTimestamp() - $allErrors['times'][$id];
            if ($diff > $this->getClearOlderThan()) {
                $this->remove($id, $type);
            }
        }
    }

    private function getAllRedisKeys(string $type = 'error')
    {
        $keys[] = $this->getRedisKeyPrefix($type);
        foreach (self::ERROR_LOGS_KEYS_PREFIX_ALL as $key) {
            $keys[] = $this->getRedisKeyPrefix($type, $key);
        }

        return $keys;
    }

    private function getErrorRedisKey(string $type = 'error')
    {
        return $this->getRedisKeyPrefix($type);
    }

    private function getPreviewRedisKey(string $type = 'error')
    {
        return $this->getRedisKeyPrefix($type, self::ERROR_LOGS_PREVIEW_PREFIX);
    }

    private function getTimeRedisKey(string $type = 'error')
    {
        return $this->getRedisKeyPrefix($type, self::ERROR_LOGS_TIME_PREFIX);
    }

    private function getCountRedisKey(string $type = 'error')
    {
        return $this->getRedisKeyPrefix($type, self::ERROR_LOGS_COUNT_PREFIX);
    }

    private function getRedisKeyPrefix(string $type = 'error', string $append = '')
    {
        return $type ? self::ERROR_LOGS.':'.$type.$append : self::ERROR_LOGS.$append;
    }

    private function getErrorLogItem(array $errorLog, bool $withPreview = false)
    {
        return new ErrorLogItem(
            $errorLog['key'],
            $errorLog['type'],
            $errorLog['message'],
            $errorLog['count'],
            $errorLog['timestamp'],
            $withPreview ? $errorLog['preview'] : null
        );
    }
}
