<?php
class WPSPF_Search {

    public function __construct()
    {
        $this->search_html();
        
    }
    public function search_html(){
        $wpspf_search_by_pr_title               = (get_option('wpspf_search_by_pr_title')) ? get_option('wpspf_search_by_pr_title') : 'enable';
        $wpspf_search_min_typed_char_pr_title   = 5;
        $wpspf_search_by_pr_sku                 = (get_option('wpspf_search_by_pr_sku')) ? get_option('wpspf_search_by_pr_sku') : 'enable';
        $wpspf_search_min_typed_char_pr_sku     = 3;
        
        $wpspf_search_pr_title_placeholder  = 'Type Product Name Here...';
        $wpspf_search_pr_sku_placeholder    = 'Type Product SKU Here. Like sk01, sk02 etc.';

        $wpspf_search_loader                = 4;
       

        $loader_url = WPSPF_AST_PATH.'loader-'.$wpspf_search_loader.'.gif';
        ?>
        <?php if($wpspf_search_by_pr_title=='enable'){ ?>
        <input type="text" class="" placeholder="<?php echo $wpspf_search_pr_title_placeholder; ?>" name="wpspf_pr_title_search" id="wpspf_pr_title_search" />
        <div id="wpsps_pr_title_search_result" style="display:none;"></div>
        <?php } ?>

        <?php if($wpspf_search_by_pr_sku=='enable'){ ?>
        <input type="text" class="" placeholder="<?php echo $wpspf_search_pr_sku_placeholder; ?>" name="wpspf_pr_sku_search" id="wpspf_pr_sku_search" />
        <div id="wpsps_pr_sku_search_result" style="display:none;"></div>
        <?php } ?>

        <script type="text/javascript">
            var $ =jQuery.noConflict();
            var searchRequest = null;
            $(function () {
                
                $("#wpspf_pr_title_search").keyup(function () {
                    var minlength = '<?php echo $wpspf_search_min_typed_char_pr_title; ?>';
                    var that = this,
                    value = $(this).val();
                    if (value.length >= minlength ) {
                        if (searchRequest != null) 
                            searchRequest.abort();
                            $("#wpspf_pr_title_search").addClass('wps_pf_pr_loading');
                            searchRequest = $.ajax({
                            type: "POST",
                            url: "<?php echo admin_url('admin-ajax.php'); ?>",
                            data: {
                                'search_keyword' : value,
                                'action':'wpspf_pr_search_by_title',
                                'search_by' : 'title'
                            },
                            dataType: "text",
                            
                            success: function(msg){
                               $("#wpsps_pr_title_search_result").html(msg);
                               $("#wpsps_pr_title_search_result").show();
                               $("#wpspf_pr_title_search").removeClass('wps_pf_pr_loading');
                            }
                        });
                    }
                });

                $("#wpspf_pr_sku_search").keyup(function () {
                    var minlength = '<?php echo $wpspf_search_min_typed_char_pr_sku; ?>';
                    var that = this,
                    value = $(this).val();
                    if (value.length >= minlength ) {
                        if (searchRequest != null) 
                            searchRequest.abort();
                            $("#wpspf_pr_sku_search").addClass('wps_pf_pr_loading');
                            searchRequest = $.ajax({
                            type: "POST",
                            url: "<?php echo admin_url('admin-ajax.php'); ?>",
                            data: {
                                'search_keyword' : value,
                                'action':'wpspf_pr_search_by_title',
                                'search_by' : 'sku'
                            },
                            dataType: "text",
                            
                            success: function(msg){
                               $("#wpsps_pr_sku_search_result").html(msg);
                               $("#wpsps_pr_sku_search_result").show();
                               $("#wpspf_pr_sku_search").removeClass('wps_pf_pr_loading');
                            }
                        });
                    }
                });
            });
        </script>

        <style type="text/css">
            .wps_pf_pr_loading {  
                background-image: url("<?php echo $loader_url; ?>") !important;
            }
        </style>
        
        <?php
    }
    
}new WPSPF_Search;
