<?php
declare(strict_types=1);

return [
    'title'         => __('Values List', 'widezone'),
    'name'          => 'widezone/values-list',
    'description'   => __('Brand values list with descriptions.', 'widezone'),
    'categories'    => ['wide-zone'],
    'viewportWidth' => 1200,
    'content'       => '<!-- wp:group {"style":{"spacing":{"padding":{"top":"var(--wp--custom--spacing--lg)","bottom":"var(--wp--custom--spacing--lg)","left":"var(--wp--custom--spacing--md)","right":"var(--wp--custom--spacing--md)"}},"border":{"radius":"var(--wp--custom--radius--md)"}},"backgroundColor":"deepblue","textColor":"warmsand","layout":{"type":"constrained","contentSize":"var(--wp--custom--container--wide)"}} -->
<div class="wp-block-group has-warmsand-color has-deepblue-background-color has-text-color has-background" style="border-radius:var(--wp--custom--radius--md);padding-top:var(--wp--custom--spacing--lg);padding-right:var(--wp--custom--spacing--md);padding-bottom:var(--wp--custom--spacing--lg);padding-left:var(--wp--custom--spacing--md)"><!-- wp:heading {"textAlign":"center","level":2,"style":{"spacing":{"margin":{"bottom":"var(--wp--custom--spacing--md)"}}}} -->
<h2 class="has-text-align-center" style="margin-bottom:var(--wp--custom--spacing--md)">Values That Drive Wide Zone</h2>
<!-- /wp:heading -->

<!-- wp:list {"className":"widezone-values","style":{"typography":{"fontSize":"clamp(1.05rem, 1rem + 0.3vw, 1.3rem)","lineHeight":"1.8"},"spacing":{"blockGap":"var(--wp--custom--spacing--xs)"}}} -->
<ul class="widezone-values"><li><strong>Expansiveness</strong> — We design networks that span markets and mindsets.</li><li><strong>Inclusivity</strong> — Every voice and vantage point has a place in our ecosystem.</li><li><strong>Innovation</strong> — We test, iterate, and scale what is next.</li><li><strong>Integrity</strong> — Transparent partnerships sustain meaningful growth.</li><li><strong>Agility</strong> — Adaptive teams thrive amid constant change.</li><li><strong>Collaboration</strong> — Shared intelligence compounds results.</li><li><strong>Impact</strong> — We measure success by the legacies we enable.</li></ul>
<!-- /wp:list --></div>
<!-- /wp:group -->'
];
