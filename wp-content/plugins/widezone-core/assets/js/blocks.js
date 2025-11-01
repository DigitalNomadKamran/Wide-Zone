
( function( blocks, element, i18n ) {
    const { registerBlockType } = blocks;
    const { createElement: el } = element;
    const { __ } = i18n;

    const blockDefs = [
        {
            name: 'widezone/projects-grid',
            title: __( 'Projects Grid', 'widezone-core' ),
            description: __( 'Displays featured projects with taxonomy badges.', 'widezone-core' ),
            icon: 'grid-view',
        },
        {
            name: 'widezone/industries-grid',
            title: __( 'Industries Grid', 'widezone-core' ),
            description: __( 'Highlights key industries with iconography.', 'widezone-core' ),
            icon: 'screenoptions',
        },
        {
            name: 'widezone/values-list',
            title: __( 'Values List', 'widezone-core' ),
            description: __( 'Outputs the Wide Zone values list.', 'widezone-core' ),
            icon: 'heart',
        },
        {
            name: 'widezone/offices-list',
            title: __( 'Offices List', 'widezone-core' ),
            description: __( 'Shows published office locations.', 'widezone-core' ),
            icon: 'building',
        },
        {
            name: 'widezone/careers-list',
            title: __( 'Careers List', 'widezone-core' ),
            description: __( 'Lists open roles and application links.', 'widezone-core' ),
            icon: 'businessman',
        },
        {
            name: 'widezone/contact-card',
            title: __( 'Contact Card', 'widezone-core' ),
            description: __( 'Outputs configured contact details.', 'widezone-core' ),
            icon: 'phone',
        },
        {
            name: 'widezone/filters-bar',
            title: __( 'Filters Bar', 'widezone-core' ),
            description: __( 'Renders project filters for industry, region, and horizon.', 'widezone-core' ),
            icon: 'filter',
        },
    ];

    blockDefs.forEach( ( block ) => {
        registerBlockType( block.name, {
            title: block.title,
            description: block.description,
            icon: block.icon,
            category: 'widgets',
            supports: {
                html: false,
            },
            edit: () => el( 'p', { className: 'widezone-block-placeholder' }, block.description ),
            save: () => null,
        } );
    } );
} )( window.wp.blocks, window.wp.element, window.wp.i18n );
