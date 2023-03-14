<?php

declare(strict_types=1);

namespace WTFramework\Database\Statements;

use WTFramework\Database\Traits\Connection;
use WTFramework\SQL\Statements\Replace as StatementsReplace;

class Replace extends StatementsReplace
{
  use Connection;
}