<?php

namespace App\Enums;

enum ReturnStatusNote: string
{
    case ON_TIME = 'returned_on_time';
    case LATE_ALLOWED = 'late_within_allowed_duration';
    case OVERDUE = 'overdue';

    public function label(): string
    {
        return match ($this) {
            self::ON_TIME => 'Returned on time',
            self::LATE_ALLOWED => 'Late (within allowed duration)',
            self::OVERDUE => 'Overdue',
        };
    }
}
