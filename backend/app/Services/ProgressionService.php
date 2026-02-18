<?php

namespace App\Services;

class ProgressionService
{
    public static function xpRequiredForLevel($level)
    {
        if ($level <= 10) {
            return $level * 25;
        }

        return 250;
    }

    public static function calculateLevel($xp)
    {
        $level = 1;
        $remainingXp = $xp;

        while (true) {
            $xpNeeded = self::xpRequiredForLevel($level);

            if ($remainingXp < $xpNeeded) {
                break;
            }

            $remainingXp -= $xpNeeded;
            $level++;
        }

        return [
            'level' => $level,
            'current_level_xp' => $remainingXp,
            'xp_needed' => self::xpRequiredForLevel($level),
            'progress_percent' => $xpNeeded > 0
                ? ($remainingXp / self::xpRequiredForLevel($level)) * 100
                : 0,
        ];
    }
}
