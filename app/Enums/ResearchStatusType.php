<?php

namespace App\Enums;


enum ResearchStatusType:string{
    case TITLE_DEFENSE = 'title_defense';
    case OUTLINE_DEFENSE = 'outline_defense';
    case FINAL_DEFENSE = 'final_defense';
    case QUALITY_CHECKING = 'quality_checking';
    // case COMPLETED = 'completed';
    // case OUTDATED = 'outdated';
    // case ABANDONED = 'abandoned';

    public static function values()
    {
        return [
            self::TITLE_DEFENSE,
            self::OUTLINE_DEFENSE,
            self::FINAL_DEFENSE,
            self::QUALITY_CHECKING,
            // self::COMPLETED,
            // self::OUTDATED,
            // self::ABANDONED,
        ];
    }
 }