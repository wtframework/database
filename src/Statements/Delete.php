<?php

declare(strict_types=1);

namespace WTFramework\Database\Statements;

use WTFramework\Database\Traits\Connection;
use WTFramework\SQL\Statements\Delete as StatementsDelete;

class Delete extends StatementsDelete
{
  use Connection;
}