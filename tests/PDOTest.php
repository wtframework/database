<?php

declare(strict_types=1);

use WTFramework\Database\PDO;
use WTFramework\SQL\DBMS;

it('can get pdo', function ()
{

  expect(
    PDO::get([
      'dbms' => DBMS::SQLite,
      'database' => ':memory:',
    ])
  )
  ->toBeInstanceOf(\PDO::class);

});

it('can get mariadb dsn', function ()
{

  expect(
    PDO::dsn([
      'dbms' => DBMS::MariaDB,
      'host' => 'localhost',
      'port' => 3306,
      'dbname' => 'test',
      'charset' => 'utf8',
    ])
  )
  ->toEqual('mysql:host=localhost;port=3306;dbname=test;charset=utf8');

});

it('can get mariadb dsn with unix socket', function ()
{

  expect(
    PDO::dsn([
      'dbms' => DBMS::MariaDB,
      'host' => 'localhost',
      'port' => 3306,
      'dbname' => 'test',
      'charset' => 'utf8',
      'unix_socket' => '/tmp/mysql.sock',
    ])
  )
  ->toEqual('mysql:unix_socket=/tmp/mysql.sock;dbname=test;charset=utf8');

});

it('can get mysql dsn', function ()
{

  expect(
    PDO::dsn([
      'dbms' => DBMS::MySQL,
      'host' => 'localhost',
      'port' => 3306,
      'dbname' => 'test',
      'charset' => 'utf8',
    ])
  )
  ->toEqual('mysql:host=localhost;port=3306;dbname=test;charset=utf8');

});

it('can get mysql dsn with unix socket', function ()
{

  expect(
    PDO::dsn([
      'dbms' => DBMS::MySQL,
      'host' => 'localhost',
      'port' => 3306,
      'dbname' => 'test',
      'charset' => 'utf8',
      'unix_socket' => '/tmp/mysql.sock',
    ])
  )
  ->toEqual('mysql:unix_socket=/tmp/mysql.sock;dbname=test;charset=utf8');

});

it('can get sqlite dsn', function ()
{

  expect(
    PDO::dsn([
      'dbms' => DBMS::SQLite,
      'database' => ':memory:',
    ])
  )
  ->toEqual('sqlite::memory:');

});

it('can get postgresql dsn', function ()
{

  expect(
    PDO::dsn([
      'dbms' => DBMS::PostgreSQL,
      'host' => 'localhost',
      'port' => 3306,
      'dbname' => 'test',
      'sslmode' => 'require'
    ])
  )
  ->toEqual('pgsql:host=localhost;port=3306;dbname=test;sslmode=require');

});

it('can get sqlserver dsn', function ()
{

  expect(
    PDO::dsn([
      'dbms' => DBMS::SQLServer,
      'Server' => 'localhost',
      'Database' => 'test',
    ])
  )
  ->toEqual('sqlsrv:Server=localhost;Database=test');

});