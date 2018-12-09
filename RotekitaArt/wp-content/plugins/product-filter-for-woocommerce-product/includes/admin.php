<?php
class WPSPF_Admin{
    public function __construct()
    {
        add_action('admin_menu', array($this,'add_settings_page'));
        add_action("admin_init", array($this,"register_filter_settings"));
    }

    public static function add_settings_page()
    {
        add_submenu_page('edit.php?post_type=product', __('WPSPF Filter Settings', 'wpspf'), __('WPSPF Filter Settings', 'wpspf'), 'manage_options', 'wpspf-product-filters', array('WPSPF_Admin', 'settings_page'));
    }

    public static function register_filter_settings()
    {
        add_settings_section("wpspf-product-filters-section", "Product Filters Settings", null, "wpspf-product-filters");
        /* Filter By Search */
        register_setting("wpspf-product-filters-section", "wpspf_search_pr_list_view");
        register_setting("wpspf-product-filters-section", "wpspf_search_by_pr_title");
        register_setting("wpspf-product-filters-section", "wpspf_search_title_text");
        register_setting("wpspf-product-filters-section", "wpspf_search_title_text2");
        register_setting("wpspf-product-filters-section", "wpspf_search_by_pr_sku");
        
        

        /* Filter By Attribute */
        register_setting("wpspf-product-filters-section", "wpspf_filter_by_pr_attr");
        register_setting("wpspf-product-filters-section", "wpspf_attr");

        /* Filter By Category */
        
        register_setting("wpspf-product-filters-section", "wpspf_cat_title_text");
        


        /* Custom CSS*/
        register_setting("wpspf-product-filters-section", "wpspf_custom_css");
    }

    public static function settings_page()
    {
        ?>
            <form method="post" action="options.php">
                <?php
                settings_fields("wpspf-product-filters-section");
                do_settings_sections("wpspf-product-filters"); 
                settings_errors();
                submit_button();
                ?>
                <div class="tabs">
                    <ul class="tabs-list">
                        <li class="active"><a href="#tab1">Search</a></li>
                        <li><a href="#tab2">Attribute</a></li>
                        <li><a href="#tab3">Category<a/></li>
                        <li><a href="#tab4">Price<a/></li>
                        <li><a href="#tab5">Custom CSS<a/></li>
                    </ul>

                    <?php require WPSPF_INC_PATH.'admin-search.php'; ?>

                    <?php require WPSPF_INC_PATH.'admin-attribute.php'; ?>

                    <?php require WPSPF_INC_PATH.'admin-category.php'; ?>

                    <?php require WPSPF_INC_PATH.'admin-price.php'; ?>

                    <?php require WPSPF_INC_PATH.'admin-css.php'; ?>

               </div>

            <?php 
                submit_button();
            ?>
            </form>
            <script type="text/javascript">
                var $ =jQuery.noConflict();
                $(document).ready(function(){
                  /* Remove a tag */
                  $('.tabs-list li').find('a').each(function(){
                      if($(this).is(':empty'))
                          $(this).remove();
                  });
                  
                  $(".tabs-list li a").click(function(e){
                     e.preventDefault();
                  });

                  $(".tabs-list li").click(function(){
                     var tabid = $(this).find("a").attr("href");
                     $(".tabs-list li,.tabs div.tab").removeClass("active");   // removing active class from tab
                     $(".tab").hide();   // hiding open tab
                     $(tabid).show();    // show tab
                     $(this).addClass("active"); //  adding active class to clicked tab

                  });

                });
            </script>
            <style>
                .tabs{
                    width:100%;
                    height:auto;
                    margin:0 auto;
                }

                /* tab list item */
                .tabs .tabs-list{
                    list-style:none;
                    margin:0px;
                    padding:0px;
                }
                .tabs .tabs-list li{
                    width:100px;
                    float:left;
                    margin:0px;
                    margin-right:2px;
                    padding:10px 5px;
                    text-align: center;
                    background-color:black;
                    border-radius:3px;
                }
                .tabs .tabs-list li:hover{
                    cursor:pointer;
                }
                .tabs .tabs-list li a{
                    text-decoration: none;
                    color:white;
                    font-size: 15px;
                }

                /* Tab content section */
                .tabs .tab{
                    display:none;
                    width:96%;
                    min-height:250px;
                    height:auto;
                    border-radius:3px;
                    padding:20px 15px;
                    background-color:white;
                    color:darkslategray;
                    clear:both;
                }
                .tabs .tab h3{
                    border-bottom:3px solid black;
                    letter-spacing:1px;
                    font-weight:normal;
                    padding:5px;
                    font-style: italic;
                }
                .tabs .tab p{
                    line-height:20px;
                    letter-spacing: 1px;
                }

                /* When active state */
                .active{
                    display:block !important;
                }
                .tabs .tabs-list li.active{
                    background-color:white !important;
                    color:black !important;
                }
                .active a{
                    color:black !important;
                }

                /* Form Fields */
                h1 {
                  font-family: 'Alegreya Sans', sans-serif;
                  font-weight: 100;
                  margin-top: 0;
                  font-size: 17px;
                  margin-bottom: 2px;
                }
                .control {
                  display: block;
                  position: relative;
                  padding-left: 30px;
                  margin-bottom: 15px;
                  cursor: pointer;
                  font-size: 18px;
                  margin-left: 10px;
                }
                .control input {
                  position: absolute;
                  z-index: -1;
                  opacity: 0;
                }
                .control__indicator {
                  position: absolute;
                  top: 2px;
                  left: 0;
                  height: 20px;
                  width: 20px;
                  background: #e6e6e6;
                }
                .control--radio .control__indicator {
                  border-radius: 50%;
                }
                .control:hover input ~ .control__indicator,
                .control input:focus ~ .control__indicator {
                  background: #ccc;
                }
                .control input:checked ~ .control__indicator {
                  background: black;
                }
                .control:hover input:not([disabled]):checked ~ .control__indicator,
                .control input:checked:focus ~ .control__indicator {
                  background: black;
                }
                
                .control__indicator:after {
                  content: '';
                  position: absolute;
                  display: none;
                }
                .control input:checked ~ .control__indicator:after {
                  display: block;
                }
                .control--checkbox .control__indicator:after {
                  left: 8px;
                  top: 4px;
                  width: 3px;
                  height: 8px;
                  border: solid #fff;
                  border-width: 0 2px 2px 0;
                  transform: rotate(45deg);
                }
                .control--checkbox input:disabled ~ .control__indicator:after {
                  border-color: #7b7b7b;
                }
                .control--radio .control__indicator:after {
                  left: 7px;
                  top: 7px;
                  height: 6px;
                  width: 6px;
                  border-radius: 50%;
                  background: #fff;
                }
                
                .select {
                  position: relative;
                  display: inline-block;
                  margin-bottom: 15px;
                  width: 100%;
                }
                .select select {
                  display: inline-block;
                  width: 100%;
                  cursor: pointer;
                  padding: 1px 15px;
                  outline: 0;
                  border: 0;
                  border-radius: 0;
                  height: 34px;
                  /*background: #e6e6e6;*/
                  /*color: #7b7b7b;*/
                  appearance: none;
                  -webkit-appearance: none;
                  -moz-appearance: none;
                }
                .select select::-ms-expand {
                  display: none;
                }
                
                .select__arrow {
                  position: absolute;
                  top: 16px;
                  right: 15px;
                  width: 0;
                  height: 0;
                  pointer-events: none;
                  border-style: solid;
                  border-width: 8px 5px 0 5px;
                  border-color: #7b7b7b transparent transparent transparent;
                }
                .select select:hover ~ .select__arrow,
                .select select:focus ~ .select__arrow {
                  border-top-color: #000;
                }
                .select select:disabled ~ .select__arrow {
                  border-top-color: #ccc;
                }
                input[type=number],input[type=text]{
                    width: 100%;
                    padding: 0px 20px;
                    margin: 5px 0;
                    display: inline-block;
                    border: 1px solid #ccc;
                    height: 33px;
                    box-sizing: border-box;
                }
                textarea{
                    width: 100%;
                    padding: 0px 20px;
                    margin: 8px 0;
                    display: inline-block;
                    border: 1px solid #ccc;
                    height: 80px;
                    box-sizing: border-box;
                }
            </style>
        <?php
    }

}new WPSPF_Admin;


 ?>