<?php 
/**
 * @package Flour heart menu wp plugin Admin Page
 */
namespace Inc\Pages;

use \Inc\API\SettingsAPI;
use \Inc\API\Callbacks\AdminCallbacks;

class Admin
{
    public $settings;
    public $callbacks;
    public $pages = array();
    public $sub_pages = array();

    public function register() 
    {
        $this->settings = new SettingsAPI();
        $this->callbacks = new AdminCallbacks();

        $this->setPages();
        $this->setSubPages();
        
        $this->setSettings();
        $this->setSections();
        $this->setFields();

        $this->settings->addPages( $this->pages )->withSubPage( 'Dashboard' )->addSubPages( $this->sub_pages )->register();
    }

    public function setPages() 
    {
        $this->pages = array(
            array(
                'page_title' => 'Flour Heart Menu Plugin',
                'menu_title' => 'Flour Heart Menu',
                'capability' => 'manage_options',
                'menu_slug' => 'flour_heart_menu_plugin',
                'callback' => array( $this->callbacks, 'adminDashboard'),
                'icon_url' => 'dashicons-carrot',
                'position' => 110
            )
        );
    }
    
    public function setSubPages() 
    {
        $this->sub_pages = array(
            array(
                'parent_slug' => 'flour_heart_menu_plugin',
                'page_title' => 'Lunch menu',
                'menu_title' => 'Lunch',
                'capability' => 'manage_options',
                'menu_slug' => 'flour_heart_menu_lunch',
                'callback' => array( $this->callbacks, 'adminLunch' ),
            ),
            array(
                'parent_slug' => 'flour_heart_menu_plugin',
                'page_title' => 'Dinner menu',
                'menu_title' => 'Dinner',
                'capability' => 'manage_options',
                'menu_slug' => 'flour_heart_menu_dinner',
                'callback' => array( $this->callbacks, 'adminDinner' ),
            )
        );
    }

    public function setSettings()
    {
        $args = array(
            array(
                'option_group' => 'flour_heart_options_group',
                'option_name' => 'text_example',
                'callback' => array( $this->callbacks, 'flourHeartOptionGroup' )
            )
        );

        $this->settings->setSettings( $args );
    }
    
    public function setSections()
    {
        $args = array(
            array(
                'id' => 'flour_heart_admin_index',
                'title' => 'Settings',
                'callback' => array( $this->callbacks, 'flourHeartAdminSection' ),
                'page' => 'flour_heart_menu_plugin'
            )
        );

        $this->settings->setSections( $args );
    }
    
    public function setFields()
    {
        $args = array(
            array(
                'id' => 'text_example',
                'title' => 'Text example',
                'callback' => array( $this->callbacks, 'flourHeartTextExample' ),
                'page' => 'flour_heart_menu_plugin',
                'section' => 'flour_heart_admin_index',
                'args' => array(
                    'label_for' => 'text_example',
                    'class' => 'example-class'
                )
            )
        );

        $this->settings->setFields( $args );
    }
}
