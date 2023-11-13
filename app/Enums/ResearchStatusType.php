<?php

namespace App\Enums;
use Illuminate\Support\Str;

enum ResearchStatusType:string{

    case FOR_SCHEDULING = 'for_scheduling'; //separate from the rest of the status

    case TITLE_DEFENSE = 'title_defense'; //1
    case OUTLINE_DEFENSE = 'outline_defense'; //2
    case FINAL_DEFENSE = 'final_defense'; //3
    case FINAL_REVISION = 'final_revision'; //4
    case QUALITY_CHECKING = 'quality_checking'; //5
    case FINAL_CHECKING = 'final_checking'; //6
    case FINAL_SUBMISSION = 'final_submission'; //7
    case COMPLETED = 'completed'; //8
    case ARCHIVED = 'archived';

    // case OUTDATED = 'outdated';
    // case ABANDONED = 'abandoned';

    public static function values()
    {
        return [
            self::TITLE_DEFENSE,
            self::OUTLINE_DEFENSE,
            self::FINAL_DEFENSE,
            self::FINAL_REVISION,
            self::QUALITY_CHECKING,
            self::FINAL_CHECKING,
            self::FINAL_SUBMISSION,
            self::COMPLETED
            // self::FOR_SCHEDULING
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