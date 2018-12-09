// Components
const { __ } = wp.i18n;

const {
	PanelBody,
	SelectControl,
	ServerSideRender,
	ToggleControl	
} = wp.components;

const { 
	Component,
	Fragment
} = wp.element;

const {	InspectorControls } = wp.editor;

/**
 * Create an AIOVGSearchEdit Component.
 */
class AIOVGSearchEdit extends Component {

	constructor() {

		super( ...arguments );
		
		this.toggleAttribute = this.toggleAttribute.bind( this );

	}

	toggleAttribute( attribute ) {

		return ( newValue ) => {
			this.props.setAttributes( { [ attribute ]: newValue } );
		};

	}

	render() {
		
		const { 
			attributes, 
			setAttributes 
		} = this.props;

		const { 
			template, 
			category 
		} = attributes;

		return (
			<Fragment>
				<InspectorControls>
					<PanelBody title={ __( 'Search Form Settings' ) }>
						<SelectControl
							label={ __( 'Select a Template' ) }
							value={ template }
							options={ [
								{ 
									label: __( 'Vertical' ), 
									value: 'vertical' 
								},
								{ 
									label: __( 'Horizontal' ), 
									value: 'horizontal' 
								}
							] }
							onChange={ ( value ) => setAttributes( { template: value } ) }
						/>
	
						<ToggleControl
							label={ __( 'Search by Categories' ) }
							checked={ category }
							onChange={ this.toggleAttribute( 'category' ) }
						/>
					</PanelBody>
				</InspectorControls>

				<ServerSideRender
					block="aiovg/search"
					attributes={ attributes }
				/>
			</Fragment>
		);

	}	

}

export default AIOVGSearchEdit;