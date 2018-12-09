<?php
class WPSPF_Category {

    public function __construct()
    {
        $wpspf_cat_title_text = (get_option('wpspf_cat_title_text')) ? get_option('wpspf_cat_title_text') : '';
        $wpspf_filter_by_pr_cat_empty  = 'yes';
        $wpspf_filter_by_pr_cat_count  = 'yes';
        $orderby    = 'default';
        $order      = 'default';



        if($wpspf_filter_by_pr_cat_empty == 'yes'){
            $empty = 1;
        }
        else{
            $empty = 0;
        }

        if($wpspf_filter_by_pr_cat_count == 'yes'){
            $show_count = 1;
        }
        else{
            $show_count = 0;
        }

        if($wpspf_cat_title_text != ''){
            echo "<h3>".$wpspf_cat_title_text."</h3>";
        }
        $this->parentcategory_html($empty,$show_count,$orderby,$order);
        echo '<input type="hidden" name="wpspf_cat_id" value="" id="wpspf_cat_id"/>';
    }
    
    public function parentcategory_html($empty=0,$show_count=0,$orderby,$order){
        $taxonomy = 'product_cat';
        $pad_counts = 1; // 1 for yes, 0 for no
        $title = '';

        $args = array(
            'taxonomy' => $taxonomy,
            'pad_counts' => $pad_counts,
            'title_li' => $title,
            'hide_empty' => $empty,
            'parent'=>0
        );
        
        if($orderby != 'default'){
            $args['orderby'] = $orderby;
        }
        if($order != 'default'){
            $args['order'] = $order;
        }
        $all_categories = get_categories( $args );
        echo "<ul class='wpspf-category'>";
        foreach ($all_categories as $cat)
        {
            $category_id = $cat->term_id;
            $children = get_categories(array('child_of' => 0,'parent' => $category_id,'taxonomy' => $taxonomy,'hide_empty' => $empty));
            if (count($children) >= 1){
                echo "<li class='wpspf-category-collapse has-subcategory'><span data-id=".$category_id.">".$cat->name;
                if($show_count == 1){
                    echo " (".$cat->count.")";
                }
                echo "</span>";
                WPSPF_Category::subcategory_html($category_id,$empty,$show_count,$orderby,$order);
                echo "</li>";
            }else{
               echo "<li><span data-id=".$category_id.">".$cat->name;
               if($show_count == 1){
                    echo " (".$cat->count.")";
                }
                echo "</span></li>";
            }
        }
        echo "<li><span data-id='0'>None / Reset</span></li>";
        echo "</ul>";
    }

    public function subcategory_html($parent_id,$empty=0,$show_count=0,$orderby='default',$order='default'){
        $taxonomy = 'product_cat';
        $pad_counts = 1; // 1 for yes, 0 for no
        $title = '';
        $args2 = array(
            'taxonomy' => $taxonomy,
            'child_of' => 0,
            'parent' => $parent_id,
            'pad_counts' => $pad_counts,
            'title_li' => $title,
            'hide_empty' => $empty
        );
        
        if($orderby != 'default'){
            $args['orderby'] = $orderby;
        }
        if($order != 'default'){
            $args['order'] = $order;
        }
        $sub_cats = get_categories( $args2 );
        if($sub_cats)
        {
            echo "<ul class='subcategory'>";
            foreach($sub_cats as $sub_category)
            {
                
                $category_id = $sub_category->term_id;
                $children = get_categories(array('child_of' => 0,'parent' => $category_id,'taxonomy' => $taxonomy,'hide_empty' => $empty));
                
                if (count($children) >= 1){
                    echo "<li class='wpspf-category-collapse has-subcategory'><span data-id=".$category_id.">".$sub_category->cat_name;
                    if($show_count == 1){
                        echo " (".$sub_category->count.")";
                    }
                    echo "</span>";
                    WPSPF_Category::subcategory_html($category_id);
                    echo "</li>";
                }else{
                    echo "<li><span data-id=".$category_id.">".$sub_category->cat_name;
                    if($show_count == 1){
                        echo " (".$sub_category->count.")";
                    }
                    echo "</span></li>";
                }
            }
            echo "</ul>";
        }
    }

   
  
    
}new WPSPF_Category;
