<?php
/**
 * Building data source mode option utilities.
 *
 * @package CalgaryCondoLeads
 */

if (!defined('ABSPATH')) {
    exit;
}

final class Calgary_Condo_Building_Data_Mode {
    public const OPTION_KEY = 'ccl_building_data_mode';
    public const MODE_CPT_FIRST = 'cpt_first';
    public const MODE_ARRAY_FIRST = 'array_first';

    public static function get_mode(): string {
        $raw = get_option(self::OPTION_KEY, self::MODE_CPT_FIRST);
        return self::sanitize_mode(is_string($raw) ? $raw : self::MODE_CPT_FIRST);
    }

    public static function is_array_first(): bool {
        return self::MODE_ARRAY_FIRST === self::get_mode();
    }

    public static function sanitize_mode(string $mode): string {
        return in_array($mode, [self::MODE_CPT_FIRST, self::MODE_ARRAY_FIRST], true) ? $mode : self::MODE_CPT_FIRST;
    }
}
