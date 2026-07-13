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

$listings_page_url = trim((string) get_post_meta($post_id, 'building_listings_page_url', true));
$has_custom_listings_page_url = '' !== $listings_page_url;
$resolved_listings_page_url = $has_custom_listings_page_url ? $listings_page_url : '/calgary-condos-for-sale/';
$listings_button_label = $has_custom_listings_page_url
    ? __('View Current Listings', 'calgary-condo-leads')
    : __('Search Live Listings', 'calgary-condo-leads');
$building_address = trim((string) get_post_meta($post_id, 'building_address', true));
$fallback_search_hint = '' !== $building_address ? $building_address : get_the_title($post_id);
$listings_heading = sprintf(
    /* translators: %s: building name */
    __('Current Listings in %s', 'calgary-condo-leads'),
    get_the_title($post_id)
);

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
                <h2><?php echo esc_html($listings_heading); ?></h2>
                <p><?php esc_html_e('View live MLS listings available in this building. Listing data is powered by myRealPage and updates with active market inventory.', 'calgary-condo-leads'); ?></p>
                <div class="ccl-building-profile-page__hero-actions">
                    <a href="<?php echo esc_url($resolved_listings_page_url); ?>" class="ccl-btn ccl-building-profile-page__section-cta"><?php echo esc_html($listings_button_label); ?></a>
                    <?php if ($has_custom_listings_page_url) : ?>
                        <p class="ccl-building-profile__meta-note"><?php esc_html_e('Live listings for this building.', 'calgary-condo-leads'); ?></p>
                    <?php else : ?>
                        <p class="ccl-building-profile__meta-note"><?php esc_html_e('Search this building by name or address on the live MLS condo search.', 'calgary-condo-leads'); ?></p>
                        <p class="ccl-building-profile__meta-note">
                            <?php
                            echo esc_html(
                                sprintf(
                                    /* translators: %s: building search hint */
                                    __('Search: %s', 'calgary-condo-leads'),
                                    $fallback_search_hint
                                )
                            );
                            ?>
                        </p>
                    <?php endif; ?>
                    <button type="button" class="ccl-btn ccl-building-profile-page__secondary-cta" data-ccl-lead-open data-lead-source="Building Profile" data-requested-category="Building Risk Report" data-clicked-cta="Get My Building Review"><?php esc_html_e('Get My Building Review', 'calgary-condo-leads'); ?></button>
                </div>
            </div>
        </div>
    </div>
</section>
