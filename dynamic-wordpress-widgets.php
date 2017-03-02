<?php 

/** 
 * Plugin Name: Dynamic WordPress Widget Example
 * Description: Generate Dynamic Widget Instances
 * Plugin URI: https://dtbaker.net
 * Version: 0.0.1
 * Author: dtbaker 
 * Author URI: https://dtbaker.net
 * Text Domain: dynamic-wordpress-widgets
 */ 



class DtbakerDynamicWidgetManager {
	private static $instance = null;

	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	public function init() {
		add_action( 'widgets_init', array( $this, 'widgets_init' ) );
	}

	public function widgets_init(){

        require_once 'class.widget.php';

        $widgets = array();

        // generate our dynamic widget properties.
        // pull this in from visual composer map settings.
        $widgets[] = array(
            'title' => 'Widget Type 1',
            'id' => 'dynamic1', // unique
            'description' => 'Insert a widget with blah blah',
            'params' => array(
                array(
                    'type' => 'dropdown', // dropdown
                    'holder' => 'div',
                    "class" => "",
                    "heading" => 'Choose Page',
                    "param_name" => 'post_id',
                    "value" => array(
                        "Test Blah 1" => 1,
                        "Test Blah 2" => 2,
                    ),
                    "std" => "",
                    'save_always' => true,
                    "description" => 'Choose which content to insert here.'
                ),
                array(
                    'type' => 'textfield', // dropdown
                    'holder' => 'div',
                    "class" => "",
                    "heading" => 'Block ID',
                    "param_name" => 'block_id',
                    "value" => substr(md5(time()),0,6),
                    "std" => substr(md5(time()),0,6),
                    'save_always' => true,
                    "description" => 'Choose an ID for this inserted content.'
                )
            ),
        );

        $widgets[] = array(
            'title' => 'Widget Type 2',
            'id' => 'dynamic2', // unique
            'description' => 'Another dynamic widget',
            'params' => array(
                array(
                    'type' => 'textfield', // dropdown
                    'holder' => 'div',
                    "class" => "",
                    "heading" => 'Test Stuff',
                    "param_name" => 'block_id',
                    "value" => substr(md5(time()),0,6),
                    "std" => substr(md5(time()),0,6),
                    'save_always' => true,
                    "description" => 'Choose an ID for this inserted content.'
                )
            ),
        );

        foreach($widgets as $widget_config){

            register_widget(new DtbakerDynamicWidget($widget_config));
        }

	}


}

DtbakerDynamicWidgetManager::get_instance()->init();


