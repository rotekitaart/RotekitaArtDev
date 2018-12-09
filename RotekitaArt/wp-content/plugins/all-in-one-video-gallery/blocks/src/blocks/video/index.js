/**
 * BLOCK: All-in-One Video Gallery Video Block.
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
registerBlockType( 'aiovg/video', {
	title: __( 'AIOVG - Video Player' ),
	description: __( 'All-in-One Video Gallery Video Player.' ),
	icon: 'format-video',
	category: 'all-in-one-video-gallery',
	keywords: [
		__( 'video' ),
		__( 'player' ),
		__( 'all-in-one-video-gallery' ),
	],
	attributes: {
		src: {
			type: 'string'
		},
		poster: {
			type: 'string'
		},
		width: {
			type: 'number',
			default: aiovg.video.width
		},
		ratio: {
			type: 'number',
			default: aiovg.video.ratio
		},
		autoplay: {
			type: 'boolean',
			default: aiovg.video.autoplay
		},
		loop: {
			type: 'boolean',
			default: aiovg.video.loop
		},
		playpause: {
			type: 'boolean',
			default: aiovg.video.playpause
		},
		current: {
			type: 'boolean',
			default: aiovg.video.current
		},
		progress: {
			type: 'boolean',
			default: aiovg.video.progress
		},
		duration: {
			type: 'boolean',
			default: aiovg.video.duration
		},		
		volume: {
			type: 'boolean',
			default: aiovg.video.volume
		},
		fullscreen: {
			type: 'boolean',
			default: aiovg.video.fullscreen
		}
	},

	edit,

	// Render via PHP
	save: function( props ) {
		return null;
	},
} );
