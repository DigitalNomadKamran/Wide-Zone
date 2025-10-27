<?php
declare(strict_types=1);

return [
    'title'         => __('Careers CTA', 'widezone'),
    'name'          => 'widezone/careers-cta',
    'description'   => __('Call to action for careers with dual buttons.', 'widezone'),
    'categories'    => ['wide-zone'],
    'viewportWidth' => 1200,
    'content'       => '<!-- wp:group {"style":{"spacing":{"padding":{"top":"var(--wp--custom--spacing--lg)","bottom":"var(--wp--custom--spacing--lg)","left":"var(--wp--custom--spacing--md)","right":"var(--wp--custom--spacing--md)"}},"border":{"radius":"var(--wp--custom--radius--md)"}},"backgroundColor":"electricteal","textColor":"deepblue","layout":{"type":"constrained","contentSize":"var(--wp--custom--container--wide)"}} -->
<div class="wp-block-group has-deepblue-color has-electricteal-background-color has-text-color has-background" style="border-radius:var(--wp--custom--radius--md);padding-top:var(--wp--custom--spacing--lg);padding-right:var(--wp--custom--spacing--md);padding-bottom:var(--wp--custom--spacing--lg);padding-left:var(--wp--custom--spacing--md)"><!-- wp:columns {"verticalAlignment":"center"} -->
<div class="wp-block-columns are-vertically-aligned-center"><!-- wp:column {"verticalAlignment":"center"} -->
<div class="wp-block-column is-vertically-aligned-center"><!-- wp:heading {"level":2} -->
<h2>Build the Future. Belong to Something Bigger.</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Shape high-impact ventures across industries with a team that champions ambition, curiosity, and collective progress.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center"} -->
<div class="wp-block-column is-vertically-aligned-center"><!-- wp:buttons {"layout":{"type":"flex","justifyContent":"right","flexWrap":"wrap"},"style":{"spacing":{"blockGap":"var(--wp--custom--spacing--sm)"}}} -->
<div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"deepblue","textColor":"warmsand"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-warmsand-color has-deepblue-background-color has-text-color has-background" href="/careers/">Search Jobs</a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"is-style-outline","textColor":"deepblue"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link has-deepblue-color has-text-color" href="/apply/">Apply Now</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->'
];
