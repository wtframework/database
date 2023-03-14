<?php

declare(strict_types=1);

namespace WTFramework\Database\Statements;

use WTFramework\Database\Traits\Connection;
use WTFramework\SQL\Statements\Drop as StatementsDrop;

class Drop extends StatementsDrop
{
  use Connection;
}