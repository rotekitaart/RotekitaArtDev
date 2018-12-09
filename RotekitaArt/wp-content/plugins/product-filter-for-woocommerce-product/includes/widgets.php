<?php
class WPSPF_Widget_Basic extends WP_Widget {

    public function __construct()
    {
        parent::__construct('wpspf_pr_filter_widget', __('WPS Products Filter', 'wpspf'), array(
            'classname' => 'wpspf_pr_filter_widget',
            'description' => __('Drag and Drop this widget into sidebar of shop page, where you want. Created by WPSuperiors', 'wpspf')
            )
        );
    }

    public function widget($args, $instance)
    {
        $args['instance'] = $instance;
        $args['sidebar_id'] = $args['id'];
        $args['sidebar_name'] = $args['name'];

        if (isset($args['before_widget']))
        {
            echo $args['before_widget'];
        }
        ?>
        <div class="widget wpspf-pr-widget">
            <?php
            if (!empty($instance['title']))
            {
                if (isset($args['before_title']))
                {
                    echo $args['before_title'];
                    echo $instance['title'];
                    echo $args['after_title'];
                } else
                {
                    echo apply_filters('wpspf_before_widget_title_tag', 'h3');
                    ?>
                    <div class="widget-title"><?php echo $instance['title'] ?></div>
                    <?php
                    echo apply_filters('wpspf_after_widget_title_tag', 'h3');
                }
            }
            ?>


            <?php
            if (isset($instance['additional_text_before']))
            {
                echo do_shortcode($instance['additional_text_before']);
            }

            ?>

            <?php
                if(class_exists('woocommerce')){
                    require WPSPF_INC_PATH.'front.php';
                }
                else{
                    _e('WooCommerce Is Not Active', 'wpspf');
                }
            ?>
        </div>
        <?php
        if (isset($args['after_widget']))
        {
            echo $args['after_widget'];
        }
    }

    public function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['title'] = $new_instance['title'];
        $instance['additional_text_before'] = $new_instance['additional_text_before'];
        return $instance;
    }

    public function form($instance)
    {
        $defaults = array(
            'title' => __('Product Filter', 'wpspf'),
            'additional_text_before' => '',
        );
        $instance = wp_parse_args((array) $instance, $defaults);
        $args = array();
        $args['instance'] = $instance;
        $args['widget'] = $this;
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'wpspf') ?>:</label>
            <input class="widefat" type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('additional_text_before'); ?>"><?php _e('Additional text before', 'wpspf') ?>:</label>
            <textarea class="widefat" type="text" id="<?php echo $this->get_field_id('additional_text_before'); ?>" name="<?php echo $this->get_field_name('additional_text_before'); ?>"><?php echo $instance['additional_text_before']; ?></textarea>
        </p>
        <?php
    }

}
