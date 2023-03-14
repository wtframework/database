<?php

declare(strict_types=1);

namespace WTFramework\Database\Statements;

use WTFramework\Database\Traits\Connection;
use WTFramework\SQL\Statements\Truncate as StatementsTruncate;

class Truncate extends StatementsTruncate
{
  use Connection;
}