// Import block dependencies and components
import { 
	BuildTree,
	GroupByParent
 } from '../../utils/helper.js';

// Components
const { __ } = wp.i18n;

const {
	PanelBody,
	RangeControl,
	SelectControl,
	ServerSideRender,
	ToggleControl	
} = wp.components; 

const { 
	Component,
	Fragment
} = wp.element;

const {	InspectorControls } = wp.editor;

const { withSelect } = wp.data;

/**
 * Create an AIOVGCategoriesEdit Component.
 */
class AIOVGCategoriesEdit extends Component {

	constructor() {

		super( ...arguments );

		this.toggleAttribute = this.toggleAttribute.bind( this );

	}

	getCategoriesTree() {

		const { categoriesList } = this.props;

		let categories = [{ 
			label: '-- ' + __( 'Top Categories' ) + ' --', 
			value: 0
		}];

		if ( categoriesList && categoriesList.length > 0 ) {		
			let grouped = GroupByParent( categoriesList );
			let tree = BuildTree( grouped );
			
			categories = [ ...categories, ...tree ];
		}

		return categories;

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
			id, 
			columns, 
			orderby, 
			order, 
			show_description, 
			show_count, 
			hide_empty 
		} = attributes;

		const categories = this.getCategoriesTree();

		return (
			<Fragment>
				<InspectorControls>
					<PanelBody title={ __( 'Categories Grid Settings' ) }>
						<SelectControl
							label={ __( 'Select Parent' ) }
							value={ id }
							options={ categories }
							onChange={ ( value ) => setAttributes( { id: value } ) }
						/>

						<RangeControl
							label={ __( 'Number of Columns' ) }
							value={ columns }							
							min={ 1 }
							max={ 4 }
							onChange={ ( value ) => setAttributes( { columns: value } ) }
						/>

						<SelectControl
							label={ __( 'Sort Categories by' ) }
							value={ orderby }
							options={ [
								{ label: __( 'ID' ), value: 'id' },
								{ label: __( 'Count' ), value: 'count' },
								{ label: __( 'Name' ), value: 'name' },
								{ label: __( 'Slug' ), value: 'slug' }
							] }
							onChange={ ( value ) => setAttributes( { orderby: value } ) }
						/>

						<SelectControl
							label={ __( 'Order Categories by' ) }
							value={ order }
							options={ [
								{ 
									label: __( 'ASC' ), 
									value: 'asc' 
								},
								{ 
									label: __( 'DESC' ), 
									value: 'desc' 
								}
							] }
							onChange={ ( value ) => setAttributes( { order: value } ) }
						/>

						<ToggleControl
							label={ __( 'Show Description?' ) }
							checked={ show_description }
							onChange={ this.toggleAttribute( 'show_description' )  }
						/>

						<ToggleControl
							label={ __( 'Show Videos Count?' ) }
							checked={ show_count }
							onChange={ this.toggleAttribute( 'show_count' ) }
						/>

						<ToggleControl
							label={ __( 'Hide Empty Categories?' ) }
							checked={ hide_empty }
							onChange={ this.toggleAttribute( 'hide_empty' ) }
						/>
					</PanelBody>
				</InspectorControls>

				<ServerSideRender
					block="aiovg/categories"
					attributes={ attributes }
				/>
			</Fragment>
		);

	}	

}

export default withSelect( ( select ) => {

	const { getEntityRecords } = select( 'core' );

	const categoriesListQuery = {
		per_page: 100
	};

	return {
		categoriesList: getEntityRecords( 'taxonomy', 'aiovg_categories', categoriesListQuery )
	};

} )( AIOVGCategoriesEdit );