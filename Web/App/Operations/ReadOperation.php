<?php

namespace App\Operations;

use App\Utils\RedisCache;

abstract class ReadOperation extends DatabaseRelatedOperation
{

  static private RedisCache $RedisCache;
  static protected function getRedisCache(): RedisCache
  {
    if (!isset(
      $RedisCache
    )) {
      $RedisCache
        = new RedisCache($_ENV['REDIS'],);
    }
    return $RedisCache;
  }
  static abstract public function getSingleObjectById($id, bool $ignoreActiveStatus = false): mixed;
  static abstract public function getAllObjects(bool $ignoreActiveStatus = false): mixed;
  static abstract public function getObjectWithOffset(int $offset = 0, int $limit = 5, bool $ignoreActiveStatus = false): mixed;
  static abstract public function getAllObjectsByFieldAndValue(string $fieldName, $value, bool $ignoreActiveStatus = false): mixed;
  static abstract public function getObjectWithOffsetByFielAndValue(string $name, $value, int $offset = 0, int $limit = 5, bool $ignoreActiveStatus = false): mixed;
  static abstract public function getPaging(int $limit, int $offset);
}
