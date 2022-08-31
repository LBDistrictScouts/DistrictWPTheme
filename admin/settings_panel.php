<?php

	add_action('admin_menu', 'add_plugin_page');
    add_action('admin_init', 'admin_page_init');

    function add_plugin_page()
    {
        add_options_page( 'LBD Specific Settings', 'LBD Settings', 'manage_options', 'lbd-settings-admin', 'lbd_admin_page' );
    }

    function lbd_admin_page()
    {
        ?>
        <div class="wrap">
            <form method="post" action="options.php">
                <?php
                settings_fields('lbd_settings_group');
                	do_settings_sections('lbd_options');
                    do_settings_sections('ldb_uah');
                    do_settings_sections('ldb_recap');
                submit_button();
                ?>
            </form>
            <hr/>
        </div>
        <?php
    }

	function admin_page_init()
    {
        register_setting('lbd_settings_group', 'lbd_settings');
        	add_settings_section('contact', 'Contact Email Settings', null, 'lbd_options');
        		add_settings_field('dc_email', 'DC Email Address', 'render_dc_email_field', 'lbd_options', 'contact');
                add_settings_field('form_email', 'Form Output Email Address', 'render_form_email_field', 'lbd_options', 'contact');
            add_settings_section('lbd_recap', 'Google Recapture API', null, 'lbd_options');
        		add_settings_field('recap_secret', 'Recapture Secure Secret', 'render_recap_secret_field', 'lbd_options', 'lbd_recap');
        		add_settings_field('recap_site_id', 'Recapture Site ID Code', 'render_recap_site_id_field', 'lbd_options', 'lbd_recap');
            add_settings_section('lbd_uah', 'User Admin Hub', null, 'lbd_options');
                add_settings_field('uah_id', 'User Admin Hub Username', 'render_uah_id_field', 'lbd_options', 'lbd_uah');
                add_settings_field('uah_key', 'User Admin Hub API Key', 'render_uah_key_field', 'lbd_options', 'lbd_uah');
    }

    function sanitize($input)
    {

        $new_input = [];

        if (!empty($input['dc_email'])) {
            $new_input['dc_email'] = sanitize_text_field($input['dc_email']);
        }

        if (!empty($input['form_email'])) {
            $new_input['form_email'] = sanitize_text_field($input['form_email']);
        }

        if (!empty($input['recap_secret'])) {
            $new_input['recap_secret'] = sanitize_text_field($input['recap_secret']);
        }

        // if(!empty($input['transactional'])) {
        //   $new_input['transactional'] = true;
        // } else {
        //   $new_input['transactional'] = false;
        // }

        return $new_input;
    }

    function render_dc_email_field()
    {
    	$sets = get_option('lbd_settings');
        echo '<input type="email" id="dc_email" name="lbd_settings[dc_email]" class="regular-text" value="' . $sets['dc_email'] .  '" />';
    }

    function render_form_email_field()
    {
        $sets = get_option('lbd_settings');
        echo '<input type="email" id="form_email" name="lbd_settings[form_email]" class="regular-text" value="' . $sets['form_email'] .  '" />';
    }

    function render_recap_secret_field()
    {
    	$sets = get_option('lbd_settings');
        echo '<input type="text" id="recap_secret" name="lbd_settings[recap_secret]" class="regular-text" value="' . $sets['recap_secret'] .  '" />';
    }

    function render_recap_site_id_field()
    {
    	$sets = get_option('lbd_settings');
        echo '<input type="text" id="recap_site_id" name="lbd_settings[recap_site_id]" class="regular-text" value="' . $sets['recap_site_id'] .  '" />';
    }

    function render_uah_id_field()
    {
        $sets = get_option('lbd_settings');
        echo '<input type="text" id="uah_id" name="lbd_settings[uah_id]" class="regular-text" value="' . $sets['uah_id'] .  '" />';
    }

    function render_uah_key_field()
    {
        $sets = get_option('lbd_settings');
        echo '<input type="text" id="uah_key" name="lbd_settings[uah_key]" class="regular-text" value="' . $sets['uah_key'] .  '" />';
    }