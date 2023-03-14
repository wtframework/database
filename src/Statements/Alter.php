<?php

declare(strict_types=1);

namespace WTFramework\Database\Statements;

use WTFramework\Database\Traits\Connection;
use WTFramework\SQL\Statements\Alter as StatementsAlter;

class Alter extends StatementsAlter
{
  use Connection;
}