<?php

namespace App\Enums;
use Illuminate\Support\Str;

enum ResearchStatusType:string{
    case TITLE_DEFENSE = 'title_defense';
    case OUTLINE_DEFENSE = 'outline_defense';
    case FINAL_DEFENSE = 'final_defense';
    case QUALITY_CHECKING = 'quality_checking';
    case FINAL_CHECKING = 'final_checking';
    case FOR_SCHEDULING = 'for_scheduling';
    case COMPLETED = 'completed';
    case FINAL_REVISION = 'final_revision';

    // case OUTDATED = 'outdated';
    // case ABANDONED = 'abandoned';

    public static function values()
    {
        return [
            self::TITLE_DEFENSE,
            self::OUTLINE_DEFENSE,
            self::FINAL_DEFENSE,
            self::QUALITY_CHECKING,
            self::COMPLETED,
            self::FINAL_CHECKING,
            self::FOR_SCHEDULING
            // self::OUTDATED,
            // self::ABANDONED,
        ];
    }

    public static function byValue(int $value): ?static
    {
        foreach (static::cases() as $key => $case) {
            if ($case->value == $value) {
                return $case;
            }
        }

        return null;
    }

    public static function byName(string $name): ?static
    {
        $name = Str::lower($name);

        foreach (self::cases() as $key => $case) {
            if (Str::lower($case->name) == $name) {
                return $case;
            }
        }

        return null;
    }
 }