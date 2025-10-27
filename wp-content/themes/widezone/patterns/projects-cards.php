<?php
declare(strict_types=1);

return [
    'title'         => __('Projects Cards', 'widezone'),
    'name'          => 'widezone/projects-cards',
    'description'   => __('Grid of project posts with badges.', 'widezone'),
    'categories'    => ['wide-zone'],
    'viewportWidth' => 1400,
    'content'       => '<!-- wp:group {"style":{"spacing":{"padding":{"top":"var(--wp--custom--spacing--lg)","bottom":"var(--wp--custom--spacing--lg)"}}},"layout":{"type":"constrained","contentSize":"var(--wp--custom--container--wide)"}} -->
<div class="wp-block-group" style="padding-top:var(--wp--custom--spacing--lg);padding-bottom:var(--wp--custom--spacing--lg)"><!-- wp:heading {"textAlign":"left","style":{"spacing":{"margin":{"bottom":"var(--wp--custom--spacing--sm)"}}}} -->
<h2 class="has-text-align-left" style="margin-bottom:var(--wp--custom--spacing--sm)">Recent Collaborations</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"textColor":"slategray","style":{"spacing":{"margin":{"bottom":"var(--wp--custom--spacing--md)"}}}} -->
<p class="has-slategray-color has-text-color" style="margin-bottom:var(--wp--custom--spacing--md)">Selected ventures demonstrating Wide Zone’s integrated investment thesis.</p>
<!-- /wp:paragraph -->

<!-- wp:query {"query":{"perPage":6,"postType":"project","order":"desc","orderBy":"date"},"displayLayout":{"type":"flex","columns":3}} -->
<div class="wp-block-query"><!-- wp:post-template -->
<!-- wp:group {"className":"widezone-card","style":{"spacing":{"blockGap":"var(--wp--custom--spacing--sm)","padding":"var(--wp--custom--spacing--sm)"},"border":{"width":"1px","color":"rgba(0,43,91,0.15)","radius":"var(--wp--custom--radius--sm)"}}} -->
<div class="wp-block-group widezone-card"><!-- wp:post-featured-image {"height":"220px","isLink":true,"style":{"border":{"radius":"var(--wp--custom--radius--sm)"}}} /-->

<!-- wp:post-title {"isLink":true,"style":{"typography":{"fontSize":"1.4rem","fontWeight":"600"}}} /-->

<!-- wp:group {"layout":{"type":"flex","flexWrap":"wrap"},"style":{"spacing":{"blockGap":"0.4rem"}}} -->
<div class="wp-block-group"><!-- wp:post-terms {"term":"region","prefix":"Region: "} /-->

<!-- wp:post-terms {"term":"horizon","prefix":"Horizon: "} /--></div>
<!-- /wp:group -->

<!-- wp:post-excerpt /-->

<!-- wp:read-more {"content":"View Project","style":{"color":{"background":"var(--wp--preset--color--electricteal)","text":"var(--wp--preset--color--deepblue)"},"spacing":{"padding":{"top":"0.65rem","bottom":"0.65rem","left":"1.4rem","right":"1.4rem"}},"border":{"radius":"var(--wp--custom--radius--xs)"}}} /--></div>
<!-- /wp:group -->
<!-- /wp:post-template -->

<!-- wp:query-no-results -->
<!-- wp:paragraph -->
<p>No projects found.</p>
<!-- /wp:paragraph -->
<!-- /wp:query-no-results -->
</div>
<!-- /wp:query --></div>
<!-- /wp:group -->'
];
