<?php

namespace App\Actions;

class GenerateIdFromSubnet
{
    /**
     * Gera Id para subnet Kea
     */
    public static function execute(string $subnet): int
    {
        return (int) sprintf('%u', ip2long($subnet));
    }
}
