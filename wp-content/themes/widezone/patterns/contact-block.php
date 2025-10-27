<?php
declare(strict_types=1);

return [
    'title'         => __('Contact Block', 'widezone'),
    'name'          => 'widezone/contact-block',
    'description'   => __('Comprehensive contact section with offices and form placeholder.', 'widezone'),
    'categories'    => ['wide-zone'],
    'viewportWidth' => 1400,
    'content'       => '<!-- wp:group {"style":{"spacing":{"padding":{"top":"var(--wp--custom--spacing--lg)","bottom":"var(--wp--custom--spacing--lg)"}}},"layout":{"type":"constrained","contentSize":"var(--wp--custom--container--wide)"}} -->
<div class="wp-block-group" style="padding-top:var(--wp--custom--spacing--lg);padding-bottom:var(--wp--custom--spacing--lg)"><!-- wp:heading -->
<h2>Let’s Create What’s Next</h2>
<!-- /wp:heading -->

<!-- wp:columns {"className":"widezone-contact","style":{"spacing":{"margin":{"bottom":"var(--wp--custom--spacing--md)"}}}} -->
<div class="wp-block-columns widezone-contact" style="margin-bottom:var(--wp--custom--spacing--md)"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"level":4} -->
<h4>General Inquiries</h4>
<!-- /wp:heading -->

<!-- wp:list -->
<ul><li><a href="mailto:info@widezone.co">info@widezone.co</a></li><li><a href="tel:+9660111234567">+966 (0) 11 123 4567</a></li></ul>
<!-- /wp:list -->

<!-- wp:heading {"level":4} -->
<h4>Partnerships</h4>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><a href="mailto:partners@widezone.co">partners@widezone.co</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"level":4} -->
<h4>Investors</h4>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><a href="mailto:investors@widezone.co">investors@widezone.co</a></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":4} -->
<h4>Careers</h4>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><a href="mailto:careers@widezone.co">careers@widezone.co</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"level":4} -->
<h4>Headquarters</h4>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Riyadh, Saudi Arabia<br>King Abdullah Financial District<br>Innovation Tower, Level 18</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":4} -->
<h4>Regional Offices</h4>
<!-- /wp:heading -->

<!-- wp:list -->
<ul><li>Dubai, UAE</li><li>Manama, Bahrain</li><li>Cairo, Egypt</li><li>Amman, Jordan</li></ul>
<!-- /wp:list --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:group {"className":"widezone-form","style":{"spacing":{"padding":"var(--wp--custom--spacing--md)"},"border":{"color":"rgba(0,43,91,0.1)","width":"1px","radius":"var(--wp--custom--radius--sm)"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group widezone-form" style="border-color:rgba(0,43,91,0.1);border-width:1px;border-radius:var(--wp--custom--radius--sm);padding:var(--wp--custom--spacing--md)"><!-- wp:heading {"level":4} -->
<h4>Contact Form</h4>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>This is a placeholder form. Replace with your preferred form plugin block.</p>
<!-- /wp:paragraph -->

<!-- wp:group {"layout":{"type":"flex","orientation":"vertical"},"style":{"spacing":{"blockGap":"var(--wp--custom--spacing--sm)"}}} -->
<div class="wp-block-group"><!-- wp:group {"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group"><label for="widezone-name" class="widezone-label">Name</label><input id="widezone-name" class="widezone-input" type="text" placeholder="Your name" /></div>
<!-- /wp:group -->

<!-- wp:group {"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group"><label for="widezone-email" class="widezone-label">Email</label><input id="widezone-email" class="widezone-input" type="email" placeholder="you@example.com" /></div>
<!-- /wp:group -->

<!-- wp:group {"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group"><label for="widezone-message" class="widezone-label">How can we help?</label><textarea id="widezone-message" class="widezone-input" rows="4" placeholder="Share your vision"></textarea></div>
<!-- /wp:group -->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"left"}} -->
<div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"deepblue","textColor":"warmsand"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-warmsand-color has-deepblue-background-color has-text-color has-background" href="#">Submit</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->'
];
