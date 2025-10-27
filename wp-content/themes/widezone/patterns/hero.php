<?php
/**
 * Hero pattern for Wide Zone.
 */

declare(strict_types=1);

return [
    'title'         => __('Hero Showcase', 'widezone'),
    'name'          => 'widezone/hero',
    'description'   => __('Full-width cinematic hero with dual headline and triple CTAs.', 'widezone'),
    'categories'    => ['wide-zone'],
    'viewportWidth' => 1400,
    'content'       => '<!-- wp:cover {"useFeaturedImage":false,"dimRatio":60,"overlayColor":"deepblue","minHeight":560,"style":{"color":{"duotone":""},"spacing":{"padding":{"top":"var(--wp--custom--spacing--xl)","bottom":"var(--wp--custom--spacing--xl)","left":"var(--wp--custom--spacing--md)","right":"var(--wp--custom--spacing--md)"}},"border":{"radius":"var(--wp--custom--radius--md)"}},"url":"https://images.unsplash.com/photo-1521737604893-d14cc237f11d?auto=format&fit=crop&w=1600&q=80","id":0,"alt":"Skyline background"} -->
<div class="wp-block-cover"><span aria-hidden="true" class="wp-block-cover__background has-deepblue-background-color has-background-dim-60 has-background-dim"></span><img class="wp-block-cover__image-background" alt="Skyline background" src="https://images.unsplash.com/photo-1521737604893-d14cc237f11d?auto=format&amp;fit=crop&amp;w=1600&amp;q=80" data-object-fit="cover"/><div class="wp-block-cover__inner-container"><!-- wp:group {"layout":{"type":"flex","orientation":"vertical","justifyContent":"flex-start","verticalAlignment":"top"},"style":{"spacing":{"blockGap":"var(--wp--custom--spacing--sm)"}}} -->
<div class="wp-block-group"><!-- wp:heading {"style":{"typography":{"fontSize":"clamp(3rem, 2.5rem + 2vw, 4.2rem)","lineHeight":"1.05","fontWeight":"700"}},"textColor":"warmsand"} -->
<h2 class="has-warmsand-color has-text-color" style="font-size:clamp(3rem, 2.5rem + 2vw, 4.2rem);line-height:1.05;font-weight:700">Boundless Thinking. Unified Impact.</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"style":{"typography":{"fontSize":"clamp(1.2rem, 1rem + 0.5vw, 1.6rem)","lineHeight":"1.5"}},"textColor":"warmsand"} -->
<p class="has-warmsand-color has-text-color" style="font-size:clamp(1.2rem, 1rem + 0.5vw, 1.6rem);line-height:1.5">Where Boundaries End, Possibilities Begin.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"style":{"typography":{"fontSize":"clamp(1.1rem, 1rem + 0.3vw, 1.4rem)","lineHeight":"1.6"}},"textColor":"warmsand"} -->
<p class="has-warmsand-color has-text-color" style="font-size:clamp(1.1rem, 1rem + 0.3vw, 1.4rem);line-height:1.6">We connect industries to build ecosystems where innovation thrives and impact multiplies.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"left","flexWrap":"wrap"},"style":{"spacing":{"blockGap":"var(--wp--custom--spacing--sm)"}}} -->
<div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"electricteal","textColor":"deepblue","style":{"spacing":{"padding":{"top":"0.75rem","bottom":"0.75rem","left":"1.8rem","right":"1.8rem"}},"border":{"radius":"var(--wp--custom--radius--sm)"}}} -->
<div class="wp-block-button"><a class="wp-block-button__link has-deepblue-color has-electricteal-background-color has-text-color has-background" href="/portfolio/">Explore Our World</a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"is-style-outline","style":{"spacing":{"padding":{"top":"0.75rem","bottom":"0.75rem","left":"1.8rem","right":"1.8rem"}},"border":{"radius":"var(--wp--custom--radius--sm)"}},"textColor":"warmsand"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link has-warmsand-color has-text-color" href="/partner-with-us/">Partner With Us</a></div>
<!-- /wp:button -->

<!-- wp:button {"backgroundColor":"sunsetorange","textColor":"warmsand","style":{"spacing":{"padding":{"top":"0.75rem","bottom":"0.75rem","left":"1.8rem","right":"1.8rem"}},"border":{"radius":"var(--wp--custom--radius--sm)"}}} -->
<div class="wp-block-button"><a class="wp-block-button__link has-warmsand-color has-sunsetorange-background-color has-text-color has-background" href="/insights/">See What’s Next</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div></div>
<!-- /wp:cover -->'
];
