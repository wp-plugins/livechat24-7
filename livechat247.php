<?php
/**
 * Plugin Name:       livechat24-7
 * Plugin URI:        https://www.livechat24-7.com/?ref=wp_plugin
 * Description:       <a href="https://www.livechat24-7.com/">Live chat</a> that learns from you as you engage with your customers. Automatically builds your knowledge base and acts as a robot agent 24/7.
 * Version:           1.0
 * Author:            botego
 * Author URI:        https://www.livechat24-7.com/?ref=wp_plugin
 * Text Domain:       livechat247
 */


$plugurldir = get_option('siteurl') . '/' . PLUGINDIR . '/livechat247/';
add_action('init', 'livechat247_init');
add_action('wp_footer', 'livechat247_embed_code');
add_action('admin_notices', 'livechat247_admin_notice');
add_filter('plugin_action_links', 'livechat247_plugin_actions', 10, 2);

function livechat247_init()
    {
    if (function_exists('current_user_can') && current_user_can('manage_options')) add_action('admin_menu', 'livechat247_add_settings_page');
    if (!function_exists('get_plugins')) require_once (ABSPATH . 'wp-admin/includes/plugin.php');

    $options = get_option('livechat247Disable');
    }

function livechat247_settings()
    {
    register_setting('livechat247-group', 'Livechat247ID');
    register_setting('livechat247-group', 'livechat247Disable');
    add_settings_section('livechat247', "Livechat24-7", "", 'livechat247-group');
    }

function plugin_get_version()
    {
    if (!function_exists('get_plugins')) require_once (ABSPATH . 'wp-admin/includes/plugin.php');

    $plugin_folder = get_plugins('/' . plugin_basename(dirname(__FILE__)));
    $plugin_file = basename((__FILE__));
    return $plugin_folder[$plugin_file]['Version'];
    }

function livechat247_embed_code()
    {
    global $current_user;
    if (get_option('Livechat247ID'))
        {
        echo ('
    <!-- livechat24-7.com widget --> 
    <script type="text/javascript"> 
    window.$_liveChat247||function(a,b){b.$_liveChat247=function(a,b){var c=a.getElementsByTagName("head")[0];b._hostURL="https://www.livechat24-7.com";var d=a.createElement("script");d.src=b._hostURL+"/dashboard/liveChatIframe.js",d.type="text/javascript",c.appendChild(d),b._liveChat={},b._liveChat.profile={accountId:"' . get_option("Livechat247ID") . '"}},b.$_liveChat247(a,b)}(document,window);
    </script> 
    <!-- /livechat24-7.com widget -->');
        }
    }

function livechat247_admin_notice()
    {
    if (!get_option('Livechat247ID')) echo ('<div class="error"><p><strong>' . sprintf(__('Livechat24-7 is disabled. Please go to the <a href="%s">plugin page</a> and enter a valid account ID to enable it.') , admin_url('options-general.php?page=livechat247')) . '</strong></p></div>');
    }

function livechat247_plugin_actions($links, $file)
    {
    global $plugurldir;
    static $this_plugin;
    if (!$this_plugin) $this_plugin = plugin_basename(__FILE__);
    if ($file == $this_plugin && function_exists('admin_url'))
        {
        $settings_link = '<a href="' . admin_url('options-general.php?page=livechat247') . '">' . __('Settings') . '</a>';
        array_unshift($links, $settings_link);
        }

    return ($links);
    }

function livechat247_add_settings_page()
    {
    global $plugurldir;
    function livechat247_settings_page()
        {
        global $plugurldir;
?>
    <div class="wrap">
        <?php screen_icon(); ?>
        <h2>
            <?php _e('Livechat24-7'); ?>
            <small><?php echo plugin_get_version(); ?></small>
        </h2>
        <div class="metabox-holder meta-box-sortables ui-sortable pointer">
            <div class="postbox" style="float:left;width:30em;left: -196px;margin-left: 50%;">
                <h3 class="hndle"><span><?php _e('livechat24-7 Account ID'); ?></span></h3>
                <div class="inside" style="padding: 0 10px">
                    <p style="text-align:center">
                        <a target="_blank" href="https://www.livechat24-7.com/dashboard/login.html?ref=wp_plugin">
                            <img src="<?php echo ($plugurldir); ?>lc.png" height="39" width="159" alt="<?php _e('livechat24-7 Logo');?>" />
                        </a>
                    </p>
                    <form method="post" action="options.php">
                        <?php settings_fields('livechat247-group'); ?>
                        <p>
                            <label for="Livechat247ID">
                                <?php printf(__('Enter your %1$slivechat24-7%2$s account ID below to activate the plugin.') , '<strong><a target="_blank" href="https://www.livechat24-7.com/dashboard/login.html?ref=wp_plugin" >', '</a></strong>'); ?>
                            </label><br />
                            <input type="text" name="Livechat247ID" value="<?php echo get_option('Livechat247ID'); ?>" style="width:100%" />
                        </p>
                        <p class="submit">
                            <input type="submit" class="button-primary" value="<?php _e('Save Changes'); ?>" />
                        </p>
                    </form>
                    
                    <small class="nonessential"><?php _e('Entering an incorrect ID will result in an error!');?></small>
                    <p style="font-size:smaller;color:#999239;background-color:#ffffe0;padding:0.4em 0.6em !important;border:1px solid #e6db55;-moz-border-radius:3px;-khtml-border-radius:3px;-webkit-border-radius:3px;border-radius:3px"><?php printf(__('%1$sRegister for a free livechat24-7 account today!%2$sRegister for a <strong>FREE</strong> livechat24-7 account right now!%3$s') , '<a target="_blank" href="https://www.livechat24-7.com/dashboard/login.html?ref=wp_plugin" title="', '">', '</a>'); ?></p>
                </div>
            </div>
        </div>
    </div>

<?php 
        }

    add_action('admin_init', 'livechat247_settings');
    add_submenu_page('options-general.php', __('Livechat24-7') , __('Livechat24-7') , 'manage_options', 'livechat247', 'livechat247_settings_page');
    }

?>
