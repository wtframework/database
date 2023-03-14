<?php

declare(strict_types=1);

namespace WTFramework\Database\Statements;

use WTFramework\Database\Traits\Connection;
use WTFramework\SQL\Statements\Insert as StatementsInsert;

class Insert extends StatementsInsert
{
  use Connection;
}