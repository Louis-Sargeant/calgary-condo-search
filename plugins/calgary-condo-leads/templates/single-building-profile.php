<?php
/**
 * Reusable single building profile template partial.
 *
 * @package CalgaryCondoLeads
 */

if (!defined('ABSPATH')) {
    exit;
}

$post_id = get_the_ID();

if (!function_exists('ccl_building_profile_meta_raw')) {
    function ccl_building_profile_meta_raw(int $post_id, string $meta_key): string {
        $value = get_post_meta($post_id, $meta_key, true);

        if (is_scalar($value) && '' !== trim((string) $value)) {
            return (string) $value;
        }

        return '';
    }
}

$fields = [
    __('Year Built', 'calgary-condo-leads') => 'ccl_building_year_built',
    __('Total Units', 'calgary-condo-leads') => 'ccl_building_total_units',
    __('Stories', 'calgary-condo-leads') => 'ccl_building_stories',
    __('Amenities', 'calgary-condo-leads') => 'ccl_building_amenities',
    __('Pet Bylaws', 'calgary-condo-leads') => 'ccl_building_pet_bylaws',
    __('Rental Constraints', 'calgary-condo-leads') => 'ccl_building_rental_constraints',
    __('Parking', 'calgary-condo-leads') => 'ccl_building_parking',
];

$inventory_shortcode = trim((string) get_post_meta($post_id, 'building_mrp_shortcode', true));

$has_missing = false;
?>
<section class="ccl-building-profile" aria-label="<?php esc_attr_e('Calgary condo building profile', 'calgary-condo-leads'); ?>">
    <div class="ccl-building-profile__grid">
        <aside class="ccl-building-profile__meta" aria-label="<?php esc_attr_e('Building metadata', 'calgary-condo-leads'); ?>">
            <div class="ccl-building-profile__meta-card">
                <p class="ccl-building-profile__eyebrow"><?php esc_html_e('Building Snapshot', 'calgary-condo-leads'); ?></p>
                <?php foreach ($fields as $label => $meta_key) :
                    $raw = ccl_building_profile_meta_raw((int) $post_id, $meta_key);
                    if ('' === $raw) {
                        $has_missing = true;
                        continue;
                    }
                ?>
                    <div class="ccl-building-profile__meta-row">
                        <span class="ccl-building-profile__meta-label"><?php echo esc_html($label); ?></span>
                        <span class="ccl-building-profile__meta-value"><?php echo esc_html($raw); ?></span>
                    </div>
                <?php endforeach; ?>
                <?php if ($has_missing) : ?>
                    <p class="ccl-building-profile__meta-note"><?php esc_html_e('Some details are still being verified. Contact us for specifics on this building.', 'calgary-condo-leads'); ?></p>
                <?php endif; ?>
            </div>
        </aside>
        <div class="ccl-building-profile__idx">
            <div class="ccl-building-profile__idx-feed">
                <h2><?php esc_html_e('Current Listings In This Building', 'calgary-condo-leads'); ?></h2>
                <?php if ('' !== $inventory_shortcode) : ?>
                    <?php echo do_shortcode($inventory_shortcode); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                <?php else : ?>
                    <p><?php esc_html_e('Live building-specific listings will appear here once the myRealPage saved search is connected for this address.', 'calgary-condo-leads'); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
