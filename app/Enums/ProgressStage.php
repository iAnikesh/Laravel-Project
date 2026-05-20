<?php

namespace App\Enums;

enum ProgressStage: string
{
    case Sanctioned = 'sanctioned';
    case Foundation = 'foundation';
    case Plinth = 'plinth';
    case Lintel = 'lintel';
    case Roof = 'roof';
    case Completed = 'completed';

    public function label(): string
    {
        return match ($this) {
            self::Sanctioned => 'Sanctioned',
            self::Foundation => 'Foundation',
            self::Plinth => 'Plinth Level',
            self::Lintel => 'Lintel Level',
            self::Roof => 'Roof Complete',
            self::Completed => 'Fully Completed',
        };
    }

    public function defaultPercentage(): int
    {
        return match ($this) {
            self::Sanctioned => 10,
            self::Foundation => 25,
            self::Plinth => 45,
            self::Lintel => 65,
            self::Roof => 85,
            self::Completed => 100,
        };
    }
}
