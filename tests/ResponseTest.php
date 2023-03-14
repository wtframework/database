<?php

declare(strict_types=1);

use WTFramework\Database\Connection;
use WTFramework\Database\Response;

$connection = new Connection(pdo: new \PDO('sqlite::memory:'));

function createTestRecords($connection): Response
{

  $connection->unprepared("DROP TABLE IF EXISTS test");

  $connection->unprepared("CREATE TABLE test (id INT PRIMARY KEY NOT NULL)");

  return (new Response(
    $connection,
    $connection->pdo->prepare("
      INSERT INTO test (id) VALUES (1), (2), (3)
    ")
  ))
  ->execute();

}

it('can get response', function () use ($connection)
{

  expect(
    new Response(
      $connection,
      $connection->pdo->query("SELECT 1")
    )
  )
  ->toBeInstanceOf(Response::class);

});

it('can get record', function () use ($connection)
{

  expect(
    (new Response(
      $connection,
      $connection->pdo->query("
        SELECT
          'test1' col1,
          'test2' col2
      ")
    ))
    ->get()
  )
  ->toEqual((object) [
    'col1' => 'test1',
    'col2' => 'test2',
  ]);

});

it('can get multiple records', function () use ($connection)
{

  expect(
    (new Response(
      $connection,
      $connection->pdo->query("
        SELECT
          'test1' col1,
          'test2' col2
        UNION
        SELECT
          'test3',
          'test4'
      ")
    ))
    ->all()
  )
  ->toEqual([
    (object) [
      'col1' => 'test1',
      'col2' => 'test2',
    ],
    (object) [
      'col1' => 'test3',
      'col2' => 'test4',
    ],
  ]);

});

it('can get insert id', function () use ($connection)
{

  expect(
    createTestRecords($connection)
    ->insertID()
  )
  ->toEqual(3);

});

it('can get affected rows', function () use ($connection)
{

  expect(
    createTestRecords($connection)
    ->affectedRows()
  )
  ->toEqual(3);

});