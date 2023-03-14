<?php

declare(strict_types=1);

namespace WTFramework\Database\Statements;

use WTFramework\Database\Traits\Connection;
use WTFramework\SQL\Statements\Update as StatementsUpdate;

class Update extends StatementsUpdate
{
  use Connection;
}