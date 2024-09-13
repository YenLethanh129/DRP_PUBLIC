<? 
namespace  App\Utils;
use Predis\Client;
class RedisCache {

  private Client $client;
  public function __construct(array $config) {
    $this->client = new Client($config);
  }


  /**
   * Calculates the time-to-live (TTL) value in seconds from a given DateInterval.
   *
   * @param \DateInterval $interval The DateInterval object representing the time interval.
   * @return int The TTL value in seconds.
   */
  private function calculateTtlFromInterval(\DateInterval $interval): int {
    $now = new \DateTime();
    $future = $now->add($interval);
    return $future->getTimestamp() - $now->getTimestamp();
  }

  
  /**
   * Sets a value in the Redis cache.
   *
   * @param string $key The key to set the value for.
   * @param mixed $value The value to set.
   * @param \DateInterval|int|null $ttl The time-to-live for the value. Can be a \DateInterval object, an integer representing seconds, or null for no expiration.
   */
  public function set(string $key, mixed $value, \DateInterval|int|null $ttl = null) {
    $arguments = [$key, $value];

    if ($ttl instanceof \DateInterval) {
      $ttl = $this->calculateTtlFromInterval($ttl);
      $arguments[] = 'EX';
      $arguments[] = $ttl;
    } elseif ($ttl !== null) {
      $arguments[] = 'EX';
      $arguments[] = $ttl;
    }

    return $this->client->set(...$arguments);
  }


  public function get(string $key) : mixed {
    return $this->client->get($key);
  }


  public function delete(string $key) : int {
      return $this->client->del($key) === 1;
  }

  public function deleteKeysStartingWith(string $prefix): int {
    $cursor = null;
    $deletedCount = 0;

    do {
      $result = $this->client->scan($cursor, ['MATCH' => $prefix . '*']);

      $keys = $result[1];

      // Delete each key
      foreach ($keys as $key) {
        if ($this->client->del($key) === 1) {
          $deletedCount++;
        }
      }
    } while ($cursor !== "0");

    return $deletedCount;
  }

  public function clear() {
    $this->client->flushdb();
  }

  public function getMultiple(iterable $keys, $default = null): iterable {
    if (!is_array($keys) && !($keys instanceof \Traversable)) {
      throw new \InvalidArgumentException('Keys must be an array or Traversable object.');
    }

    $keysArray = is_array($keys) ? $keys : iterator_to_array($keys);
    $values = $this->client->mget($keysArray);

    return array_map(fn($value) => $value !== null ? $value : $default, array_combine($keysArray, $values));
  }

  public function setMultiple(array $data, \DateInterval|int|null $ttl = null): bool {
    $data = (array) $data;
    $result = $this->client->mset($data);
    if($ttl !== null) {
      if($ttl instanceof \DateInterval) {
        $ttl = $this->calculateTtlFromInterval($ttl);
      }
      foreach(array_keys($data) as $key) {
        $this->client->expire($key, $ttl);
      }
    }
    return $result;
  }
  
  public function deleteMultiple(iterable $keys): int {
    $pipeline = $this->client->pipeline();
    foreach ($keys as $key) {
      $pipeline->del($key);
    }
    $results = $pipeline->execute();
    
    // Đếm số lượng khóa đã bị xóa
    $deletedCount = array_sum($results);

    return $deletedCount;
  }

  public function has(string $key) : bool {
    return $this->client->exists($key) === 1;
  }
}
