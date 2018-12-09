<?php
class WPSPF_Front {

    public function __construct()
    {
        $search_active = true ;
        
        if($search_active){
            $this->search_widget();
        }
        echo "<form name='wpspf-attribute-filter' id='wpspf-attribute-filter' method='POST'>";
        $wpspf_filter_by_pr_attr = (get_option('wpspf_filter_by_pr_attr')) ? get_option('wpspf_filter_by_pr_attr') : 'enable';
        if($wpspf_filter_by_pr_attr=='enable'){
            $this->attribute_widget();
        }
        $wpspf_filter_by_pr_cat = (get_option('wpspf_filter_by_pr_cat')) ? get_option('wpspf_filter_by_pr_cat') : 'enable';
        if($wpspf_filter_by_pr_cat=='enable'){
            $this->category_widget();
        }
        echo "</form>";
        ?>
        
        <?php
    }
    public function search_widget(){
        require WPSPF_ELEM_PATH.'search.php';
    }

    public function attribute_widget(){
        
        require WPSPF_ELEM_PATH.'attribute.php';
       
    }
    public function category_widget(){
        require WPSPF_ELEM_PATH.'category.php';
    }
}new WPSPF_Front;
