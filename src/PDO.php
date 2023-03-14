<?php

declare(strict_types=1);

namespace WTFramework\Database;

use WTFramework\SQL\DBMS;

class PDO
{

  private function __construct() {}

  public static function get(
    #[\SensitiveParameter] array $config
  ): \PDO
  {

    return new \PDO(
      self::dsn(config: $config),
      $config['user'] ?? null,
      $config['password'] ?? null,
      [\PDO::ATTR_EMULATE_PREPARES => false]
    );

  }

  public static function dsn(
    #[\SensitiveParameter] array $config
  ): string
  {

    if (is_string($dbms = $config['dbms'] ?? ''))
    {
      $dbms = DBMS::from($dbms);
    }

    return match ($dbms)
    {

      DBMS::MariaDB, DBMS::MySQL =>
        self::mysql(config: $config),

      DBMS::SQLite =>
        self::sqlite(config: $config),

      DBMS::PostgreSQL =>
        self::pgsql(config: $config),

      DBMS::SQLServer =>
        self::sqlsrv(config: $config),

      default =>
        throw new DatabaseException('No DBMS set for PDO connection'),

    };

  }

  protected static function mysql(
    #[\SensitiveParameter] array $config
  ): string
  {

    foreach ([
      'host',
      'port',
      'dbname',
      'unix_socket',
      'charset'
    ] as $key)
    {

      $config[$key] ??= '';

      $$key = $config[$key] ? "$key={$config[$key]}" : '';

    }

    $dsn = implode(';', array_filter([
      $unix_socket ?: $host,
      $unix_socket ? '' : $port,
      $dbname,
      $charset
    ]));

    return "mysql:$dsn";

  }

  protected static function sqlite(
    #[\SensitiveParameter] array $config
  ): string
  {

    $database = $config['database'] ?? '';

    return "sqlite:$database";

  }

  protected static function pgsql(
    #[\SensitiveParameter] array $config
  ): string
  {

    foreach ([
      'host',
      'port',
      'dbname',
      'sslmode'
    ] as $key)
    {

      $config[$key] ??= '';

      $$key = $config[$key] ? "$key={$config[$key]}" : '';

    }

    $dsn = implode(';', array_filter([
      $host,
      $port,
      $dbname,
      $sslmode
    ]));

    return "pgsql:$dsn";

  }

  protected static function sqlsrv(
    #[\SensitiveParameter] array $config
  ): string
  {

    foreach ([
      'Server',
      'Database',
      'APP',
      'ConnectionPooling',
      'Encrypt',
      'Failover_Partner',
      'LoginTimeout',
      'MultipleActiveResultSets',
      'QuotedId',
      'TraceFile',
      'TraceOn',
      'TransactionIsolation',
      'TrustServerCertificate',
      'WSID',
    ] as $key)
    {

      $config[$key] ??= '';

      $$key = $config[$key] ? "$key={$config[$key]}" : '';

    }

    $dsn = implode(';', array_filter([
      $Server,
      $Database,
      $APP,
      $ConnectionPooling,
      $Encrypt,
      $Failover_Partner,
      $LoginTimeout,
      $MultipleActiveResultSets,
      $QuotedId,
      $TraceFile,
      $TraceOn,
      $TransactionIsolation,
      $TrustServerCertificate,
      $WSID,
    ]));

    return "sqlsrv:$dsn";

  }

}