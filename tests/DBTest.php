<?php

declare(strict_types=1);

use WTFramework\Config\Config;
use WTFramework\Database\Connection;
use WTFramework\Database\DB;
use WTFramework\Database\Response;
use WTFramework\Database\Statements\Alter;
use WTFramework\Database\Statements\Create;
use WTFramework\Database\Statements\Delete;
use WTFramework\Database\Statements\Drop;
use WTFramework\Database\Statements\Insert;
use WTFramework\Database\Statements\Replace;
use WTFramework\Database\Statements\Select;
use WTFramework\Database\Statements\Truncate;
use WTFramework\Database\Statements\Update;
use WTFramework\SQL\Column;
use WTFramework\SQL\Constraint;
use WTFramework\SQL\DBMS;

beforeAll(function ()
{

  Config::set([
    'database' => [
      'default' => 'sqlite',
      'sqlite' => [
        'dbms' => DBMS::SQLite,
        'database' => ':memory:',
      ],
      'mirror' => [
        'dbms' => DBMS::SQLite,
        'database' => ':memory:',
      ]
    ]
  ]);

});

it('can get connection', function ()
{

  expect(DB::connection())
  ->toBeInstanceOf(Connection::class);

});

it('can get singleton', function ()
{

  expect(DB::connection())
  ->toBe(DB::connection());

});

it('can get aliased connection', function ()
{

  $connection = DB::connection(alias: 'sqlite2');

  expect($connection)
  ->toBeInstanceOf(Connection::class);

  expect($connection)
  ->not()
  ->toBe(DB::connection());

});

it('can get aliased singleton', function ()
{

  expect(DB::connection(alias: 'sqlite2'))
  ->toBe(DB::connection(alias: 'sqlite2'));

});

it('can get named connection', function ()
{

  $connection = DB::connection(name: 'mirror');

  expect($connection)
  ->toBeInstanceOf(Connection::class);

  expect($connection)
  ->not()
  ->toBe(DB::connection());

});

it('can get named singleton', function ()
{

  expect(DB::connection(name: 'mirror'))
  ->toBe(DB::connection(name: 'mirror'));

});

it('can execute', function ()
{

  expect(DB::unprepared("SELECT 1"))
  ->toBeInstanceOf(Response::class);

});

it('can prepare', function ()
{

  expect(DB::prepare("SELECT 1"))
  ->toBeInstanceOf(Response::class);

});

it('can prepare and execute', function ()
{

  expect(DB::execute("SELECT 1"))
  ->toBeInstanceOf(Response::class);

});

it('can get record', function ()
{

  expect(DB::get("SELECT 1"))
  ->toBeInstanceOf(\stdClass::class);

});

it('can get multiple records', function ()
{

  expect(DB::all("SELECT 1 UNION SELECT 2"))
  ->toBeArray();

});

it('can get alter statement', function ()
{

  expect(DB::alter())
  ->toBeInstanceOf(Alter::class);

});

it('can get create statement', function ()
{

  expect(DB::create())
  ->toBeInstanceOf(Create::class);

});

it('can get delete statement', function ()
{

  expect(DB::delete())
  ->toBeInstanceOf(Delete::class);

});

it('can get drop statement', function ()
{

  expect(DB::drop())
  ->toBeInstanceOf(Drop::class);

});

it('can get insert statement', function ()
{

  expect(DB::insert())
  ->toBeInstanceOf(Insert::class);

});

it('can get replace statement', function ()
{

  expect(DB::replace())
  ->toBeInstanceOf(Replace::class);

});

it('can get select statement', function ()
{

  expect(DB::select())
  ->toBeInstanceOf(Select::class);

});

it('can get truncate statement', function ()
{

  expect(DB::truncate())
  ->toBeInstanceOf(Truncate::class);

});

it('can get update statement', function ()
{

  expect(DB::update())
  ->toBeInstanceOf(Update::class);

});

it('can get column', function ()
{

  expect(DB::column('test'))
  ->toBeInstanceOf(Column::class);

});

it('can get column constraint', function ()
{

  expect(DB::constraint())
  ->toBeInstanceOf(Constraint::class);

});