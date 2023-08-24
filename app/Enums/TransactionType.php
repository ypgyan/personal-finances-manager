<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static EXPENSE()
 * @method static static INCOME()
 * @method static static TRANSFER()
 */
final class TransactionType extends Enum
{
    const EXPENSE = 'expense';
    const INCOME = 'income';
    const TRANSFER = 'transfer';
}
