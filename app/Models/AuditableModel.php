<?php

namespace App\Models;

use OwenIt\Auditing\Auditable as AuditableTrait;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * Base model for any model that should be audited.
 *
 * PHP traits cannot implement interfaces, so the Auditable contract is
 * declared here once. Models extending this class inherit the contract
 * (and the AuditableTrait) without repeating `implements Auditable`.
 */
abstract class AuditableModel extends Model implements Auditable
{
    use AuditableTrait;
}
