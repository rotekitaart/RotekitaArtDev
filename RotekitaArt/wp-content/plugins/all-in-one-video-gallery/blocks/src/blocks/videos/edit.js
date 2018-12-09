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
 * Create an AIOVGVideosEdit Component.
 */
class AIOVGVideosEdit extends Component {

	constructor() {

		super( ...arguments );

		this.toggleAttribute = this.toggleAttribute.bind( this );

	}

	getCategoriesTree() {

		const { categoriesList } = this.props;

		let categories = [];

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
			category, 
			columns, 
			limit, 
			orderby, 
			order, 
			featured, 
			related, 
			show_count, 
			show_category, 
			show_date, 
			show_user, 
			show_views, 
			show_duration, 
			show_excerpt, 
			show_pagination 
		} = attributes;

		const categories = this.getCategoriesTree();

		return (
			<Fragment>
				<InspectorControls>
					<PanelBody title={ __( 'Videos Grid Settings' ) }>
						<SelectControl
							multiple
							label={ __( 'Select Categories' ) }
							value={ category }
							options={ categories }
							onChange={ ( value ) => setAttributes( { category: value } ) }
						/>

						<RangeControl
							label={ __( 'Number of Columns' ) }
							value={ columns }							
							min={ 1 }
							max={ 4 }
							onChange={ ( value ) => setAttributes( { columns: value } ) }
						/>

						<RangeControl
							label={ __( 'Limit' ) }
							value={ limit }							
							min={ 1 }
							max={ 100 }
							onChange={ ( value ) => setAttributes( { limit: value } ) }
						/>

						<SelectControl
							label={ __( 'Order By' ) }
							value={ orderby }
							options={ [
								{ 
									label: __( 'Title' ), 
									value: 'title' 
								},
								{ 
									label: __( 'Date Posted' ), 
									value: 'date' 
								},
								{ 
									label: __( 'Views Count' ), 
									value: 'views' 
								},
								{ 
									label: __( 'Random' ), 
									value: 'rand' 
								}
							] }
							onChange={ ( value ) => setAttributes( { orderby: value } ) }
						/>

						<SelectControl
							label={ __( 'Order' ) }
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
							label={ __( 'Featured Only' ) }
							checked={ featured }
							onChange={ this.toggleAttribute( 'featured' ) }
						/>

						<ToggleControl
							label={ __( 'Follow URL?' ) + '(' + __( 'Related Videos' ) + ')' }
							checked={ related }
							onChange={ this.toggleAttribute( 'related' ) }
						/>

						<ToggleControl
							label={ __( 'Videos Count' ) }
							checked={ show_count }
							onChange={ this.toggleAttribute( 'show_count' ) }
						/>

						<ToggleControl
							label={ __( 'Category Name' ) }
							checked={ show_category }
							onChange={ this.toggleAttribute( 'show_category' ) }
						/>

						<ToggleControl
							label={ __( 'Date Added' ) }
							checked={ show_date }
							onChange={ this.toggleAttribute( 'show_date' ) }
						/>

						<ToggleControl
							label={ __( 'Author Name' ) }
							checked={ show_user }
							onChange={ this.toggleAttribute( 'show_user' ) }
						/>

						<ToggleControl
							label={ __( 'Views Count' ) }
							checked={ show_views }
							onChange={ this.toggleAttribute( 'show_views' ) }
						/>

						<ToggleControl
							label={ __( 'Video Duration' ) }
							checked={ show_duration }
							onChange={ this.toggleAttribute( 'show_duration' ) }
						/>

						<ToggleControl
							label={ __( 'Excerpt ( Short Description )' ) }
							checked={ show_excerpt }
							onChange={ this.toggleAttribute( 'show_excerpt' ) }
						/>

						<ToggleControl
							label={ __( 'Show Pagination' ) }
							checked={ show_pagination }
							onChange={ this.toggleAttribute( 'show_pagination' ) }
						/>
					</PanelBody>
				</InspectorControls>
				
				<ServerSideRender
					block="aiovg/videos"
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

} )( AIOVGVideosEdit );