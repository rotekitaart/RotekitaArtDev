/**
 * BLOCK: All-in-One Video Gallery Categories Grid Block.
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
registerBlockType( 'aiovg/categories', {
	title: __( 'AIOVG - Categories Grid' ),
	description: __( 'Display a list of All-in-One Video Gallery Categories.' ),
	icon: 'category',
	category: 'all-in-one-video-gallery',
	keywords: [
		__( 'categories' ),
		__( 'gallery' ),
		__( 'all-in-one-video-gallery' ),
	],
	attributes: {
		id: {
			type: 'number',
			default: 0
		},
		columns: {
			type: 'number',
			default: aiovg.categories.columns
		},
		orderby: {
			type: 'string',
			default: aiovg.categories.orderby
		},
		order: {
			type: 'string',
			default: aiovg.categories.order
		},
		show_description: {
			type: 'boolean',
			default: aiovg.categories.show_description
		},
		show_count: {
			type: 'boolean',
			default: aiovg.categories.show_count
		},
		hide_empty: {
			type: 'boolean',
			default: aiovg.categories.hide_empty
		}
	},

	edit,

	// Render via PHP
	save: function( props ) {
		return null;
	},
} );
