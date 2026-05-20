<?php

namespace App\Enums;

enum FinancialRecordType: string
{
    case BudgetAllocation = 'budget_allocation';
    case Installment = 'installment';
    case Expenditure = 'expenditure';

    public function label(): string
    {
        return match ($this) {
            self::BudgetAllocation => 'Budget Allocation',
            self::Installment => 'Installment / Payment',
            self::Expenditure => 'Expenditure',
        };
    }
}
