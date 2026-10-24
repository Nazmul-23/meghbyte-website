<?php

namespace App\Enums;

enum LeadStatus: string
{
    case New = 'new';
    case Contacted = 'contacted';
    case Quoted = 'quoted';
    case Won = 'won';
    case Lost = 'lost';

    public function label(): string
    {
        return ucfirst($this->value);
    }

    public function color(): string
    {
        return match ($this) {
            self::New => 'blue',
            self::Contacted => 'orange',
            self::Quoted => 'purple',
            self::Won => 'green',
            self::Lost => 'gray',
        };
    }
}
