/**
 * BLOCK: All-in-One Video Gallery Videos Grid Block.
 */

// Import block dependencies and components
import edit from './edit';

// Components
const { __ } = wp.i18n;

const { registerBlockType } = wp.blocks;

/**
 * Register the block.
 *
 * @param  {string}   name     Block name.
 * @param  {Object}   settings Block settings.
 * @return {?WPBlock}          The block, if it has been successfully
 *                             registered; otherwise `undefined`.
 */
registerBlockType( 'aiovg/videos', {
	title: __( 'AIOVG - Videos Grid' ),
	description: __( 'Display a list of All-in-One Video Gallery Videos.' ),
	icon: 'playlist-video',
	category: 'all-in-one-video-gallery',
	keywords: [
		__( 'videos' ),
		__( 'gallery' ),
		__( 'all-in-one-video-gallery' ),
	],
	attributes: {
		category: {
			type: 'array'
		},
		columns: {
			type: 'number',
			default: aiovg.videos.columns
		},
		limit: {
			type: 'number',
			default: aiovg.videos.limit
		},
		orderby: {
			type: 'string',
			default: aiovg.videos.orderby
		},
		order: {
			type: 'string',
			default: aiovg.videos.order
		},
		featured: {
			type: 'boolean',
			default: aiovg.videos.featured
		},
		related: {
			type: 'boolean',
			default: aiovg.videos.related
		},
		show_count: {
			type: 'boolean',
			default: aiovg.videos.show_count
		},
		show_category: {
			type: 'boolean',
			default: aiovg.videos.show_category
		},
		show_date: {
			type: 'boolean',
			default: aiovg.videos.show_date
		},
		show_user: {
			type: 'boolean',
			default: aiovg.videos.show_user
		},
		show_views: {
			type: 'boolean',
			default: aiovg.videos.show_views
		},
		show_duration: {
			type: 'boolean',
			default: aiovg.videos.show_duration
		},
		show_excerpt: {
			type: 'boolean',
			default: aiovg.videos.show_excerpt
		},
		show_pagination: {
			type: 'boolean',
			default: aiovg.videos.show_pagination
		}
	},

	edit,

	// Render via PHP
	save: function( props ) {
		return null;
	},
} );
