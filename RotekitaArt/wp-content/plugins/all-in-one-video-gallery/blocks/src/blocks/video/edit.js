// Components
const { __ } = wp.i18n;

const {
	BaseControl,
	Button,
	IconButton,
	PanelBody,	
	ServerSideRender,
	TextControl,	
	ToggleControl,
	Toolbar,	
	withNotices	
} = wp.components;

const { 
	Component,
	Fragment,
	createRef
} = wp.element;

const {
	BlockControls,	
	InspectorControls,
	MediaPlaceholder,
	MediaUpload,
} = wp.editor;

/**
 * Create an AIOVGVideoEdit Component.
 */
class AIOVGVideoEdit extends Component {

	constructor() {

		super( ...arguments );

		// edit component has its own src in the state so it can be edited
		// without setting the actual value outside of the edit UI
		this.state = {
			editing: ! this.props.attributes.src,
		};

		this.videoPlayer = createRef();
		this.toggleAttribute = this.toggleAttribute.bind( this );
		this.onSelectURL = this.onSelectURL.bind( this );
		this.onSelectPoster = this.onSelectPoster.bind( this );
		this.onRemovePoster = this.onRemovePoster.bind( this );

	}

	toggleAttribute( attribute ) {

		return ( newValue ) => {
			this.props.setAttributes( { [ attribute ]: newValue } );
		};

	}

	onSelectURL( newSrc ) {

		const { 
			attributes, 
			setAttributes 
		} = this.props;

		const { src } = attributes;

		// Set the block's src from the edit component's state, and switch off
		// the editing UI.
		if ( newSrc !== src ) {
			setAttributes( { src: newSrc } );
		}

		this.setState( { editing: false } );

	}

	onSelectPoster( image ) {

		const { setAttributes } = this.props;
		setAttributes( { poster: image.url } );

	}

	onRemovePoster() {

		const { setAttributes } = this.props;
		setAttributes( { poster: '' } );

	}

	render() {
		
		const { 
			attributes, 
			setAttributes, 
			className, 
			noticeOperations, 
			noticeUI 
		} = this.props;

		const {
			poster,
			width,
			ratio,
			autoplay,
			loop,
			playpause,
			current,
			progress,
			duration,
			volume,
			fullscreen
		} = attributes;

		const { editing } = this.state;

		const switchToEditing = () => {
			this.setState( { editing: true } );
		};

		const onSelectVideo = ( media ) => {

			if ( ! media || ! media.url ) {
				// in this case there was an error and we should continue in the editing state
				// previous attributes should be removed because they may be temporary blob urls
				setAttributes( { src: undefined } );
				switchToEditing();
				return;
			}
			// sets the block's attribute and updates the edit component from the
			// selected media, then switches off the editing UI
			setAttributes( { src: media.url } );
			this.setState( { src: media.url, editing: false } );

		};

		if ( editing ) {
			return (
				<MediaPlaceholder
					icon="media-video"
					labels={ {
						title: __( 'Add MP4, WebM, OGV, YouTube, Vimeo, Dailymotion or a Facebook Video URL.' ),
						name: __( 'a video' )
					} }
					className={ className }					
					accept="video/*"
					type="video"
					value={ attributes }
					onSelect={ onSelectVideo }
					onSelectURL={ this.onSelectURL }
					notices={ noticeUI }
					onError={ noticeOperations.createErrorNotice }
				/>
			);
		}

		return (
			<Fragment>
				<BlockControls>
					<Toolbar>
						<IconButton
							className="components-icon-button components-toolbar__control"
							label={ __( 'Edit video' ) }
							onClick={ switchToEditing }
							icon="edit"
						/>
					</Toolbar>
				</BlockControls>

				<InspectorControls>
					<PanelBody title={ __( 'Video Settings' ) }>
						<TextControl
							label={ __( 'Width' ) }
							help={ __( 'In pixels. Maximum width of the player. Leave this field empty to scale 100% of its enclosing container/html element.' ) }
							value={ width > 0 ? width : '' }
							onChange={ ( value ) => setAttributes( { width: Number( value ) } ) }
						/>

						<TextControl
							label={ __( 'Ratio' ) }
							help={ __( "In percentage. 1 to 100. Calculate player's height using the ratio value entered." ) }
							value={ ratio }
							onChange={ ( value ) => setAttributes( { ratio: value } ) }
						/>

						<ToggleControl
							label={ __( 'Autoplay' ) }							
							checked={ autoplay }
							onChange={ this.toggleAttribute( 'autoplay' ) }
						/>

						<ToggleControl
							label={ __( 'Loop' ) }							
							checked={ loop }
							onChange={ this.toggleAttribute( 'loop' ) }
						/>

						<BaseControl
							className="editor-video-poster-control"
							label={ __( 'Poster Image' ) }
						>
							<MediaUpload
								title={ __( 'Select Poster Image' ) }
								onSelect={ this.onSelectPoster }
								type="image"
								render={ ( { open } ) => (
									<Button isDefault onClick={ open }>
										{ ! poster ? __( 'Select Poster Image' ) : __( 'Replace image' ) }
									</Button>
								) }
							/>
							{ !! poster &&
								<Button onClick={ this.onRemovePoster } isLink isDestructive>
									{ __( 'Remove Poster Image' ) }
								</Button>
							}
						</BaseControl>
					</PanelBody>	

					<PanelBody title={ __( 'Show / Hide Player Controls' ) }>
						<ToggleControl
							label={ __( 'Play / Pause' ) }							
							checked={ playpause }
							onChange={ this.toggleAttribute( 'playpause' ) }
						/>

						<ToggleControl
							label={ __( 'Current Time' ) }							
							checked={ current }
							onChange={ this.toggleAttribute( 'current' ) }
						/>

						<ToggleControl
							label={ __( 'Progressbar' ) }							
							checked={ progress }
							onChange={ this.toggleAttribute( 'progress' ) }
						/>

						<ToggleControl
							label={ __( 'Duration' ) }							
							checked={ duration }
							onChange={ this.toggleAttribute( 'duration' ) }
						/>

						<ToggleControl
							label={ __( 'Volume' ) }							
							checked={ volume }
							onChange={ this.toggleAttribute( 'volume' ) }
						/>

						<ToggleControl
							label={ __( 'Fullscreen' ) }							
							checked={ fullscreen }
							onChange={ this.toggleAttribute( 'fullscreen' ) }
						/>							
					</PanelBody>
				</InspectorControls>
				
				<ServerSideRender
					block="aiovg/video"
					attributes={ attributes }
				/>
			</Fragment>
		);

	}	

}

export default withNotices( AIOVGVideoEdit );