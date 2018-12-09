/**
 * BLOCK: All-in-One Video Gallery Search Block.
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
registerBlockType( 'aiovg/search', {
	title: __( 'AIOVG - Search Form' ),
	description: __( 'All-in-One Video Gallery Videos Search Form.' ),
	icon: 'search',
	category: 'all-in-one-video-gallery',
	keywords: [
		__( 'search' ),
		__( 'videos' ),
		__( 'all-in-one-video-gallery' ),
	],
	attributes: {
		template: {
			type: 'string',
			default: aiovg.search.template
		},
		category: {
			type: 'boolean',
			default: aiovg.search.category
		}
	},

	edit,

	// Render via PHP
	save: function( props ) {
		return null;
	},
} );
