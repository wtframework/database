<?php

declare(strict_types=1);

namespace WTFramework\Database\Statements;

use WTFramework\Database\Traits\Connection;
use WTFramework\SQL\Statements\Create as StatementsCreate;

class Create extends StatementsCreate
{
  use Connection;
}