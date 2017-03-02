<?php

/**
 * Core class used to implement dynamic wordpress widgets
 *
 * @since 3.0.0
 *
 * @see WP_Widget
 */
class DtbakerDynamicWidget extends WP_Widget {

    public $widget_config = array();
    public function __construct($widget_config) {
        $this->widget_config = $widget_config;
        $widget_ops = array( 'description' => $this->widget_config['description'] );
        parent::__construct( $this->widget_config['id'], $this->widget_config['title'], $widget_ops );
    }


    public function widget( $args, $instance ) {
        extract( $args );
        $title = isset($instance['title']) ? $instance['title'] : '';
        echo $before_widget;
        echo $title ? ($before_title . $title . $after_title) : '';
        // fire our shortcode below to generate map output.

        echo "This is the content for this dynamic widget: <br/><pre>";
        print_r($this->widget_config);
        echo "\n";
        print_r($instance);
        echo "</pre>";

        echo $after_widget;
    }


    /**
     * Handles updating settings for the current Custom Menu widget instance.
     *
     * @since 3.0.0
     * @access public
     *
     * @param array $new_instance New settings for this instance as input by the user via
     *                            WP_Widget::form().
     * @param array $old_instance Old settings for this instance.
     *
     * @return array Updated settings to save.
     */
    public function update( $new_instance, $old_instance ) {
        return array_merge($old_instance, $new_instance);
    }

    /**
     * Outputs the settings form for the Custom Menu widget.
     *
     * @since 3.0.0
     * @access public
     *
     * @param array $instance Current settings.
     */
    public function form( $instance ) {
        $title    = isset( $instance['title'] ) ? $instance['title'] : '';

        $params = $this->widget_config['params'];

        ?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'dtbaker-insert-page'); ?>
                <input type="text" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr($title);?>">
            </label></p>
        <?php
        foreach($params as $field){
            ?>
            <p><label for="<?php echo $this->get_field_id($field['param_name']); ?>"><?php echo $field['heading']; ?>
                    <?php switch($field['type']){
                        case 'dropdown':
                            $current_val = isset($instance[$field['param_name']])?$instance[$field['param_name']]:$field['std'];
                            ?>
                            <select name="<?php echo $this->get_field_name($field['param_name']); ?>">
                                <?php foreach($field['value'] as $val=>$key){ ?>
                                    <option value="<?php echo esc_attr($key);?>"<?php echo $current_val == $key ? ' selected':'';?>><?php echo $val;?></option>
                                <?php } ?>
                            </select>
                            <?php
                            break;
                        case 'textfield':
                            ?>
                            <input type="text" name="<?php echo $this->get_field_name($field['param_name']); ?>" value="<?php echo esc_attr(isset($instance[$field['param_name']])?$instance[$field['param_name']]:$field['std']);?>">
                            <?php
                            break;
                    } ?>
                </label></p>
            <?php
        }
    }
}
