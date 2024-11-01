<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Plugin Name: Sign Pantograph Extension
 * Plugin URI: https://github.com/HuynhTuanWD/sign-pantograph-extension
 * Description: Web3 login. Enable crypto wallet logins to WordPress.
 * Author: Bacoor
 * Version: 0.0.1
 * Author URI: https://github.com/HuynhTuanWD
 */

function wbpspane_create_shortcode()
{
    if (
        !is_admin()
        && strpos($_SERVER['REQUEST_URI'], 'wp-login.php') === false
        && strpos($_SERVER['REQUEST_URI'], 'wp-signup.php') === false
    ) {
        add_action('wp_footer', 'wbpspane_script_bind_code_react');
    }
    if (
        !is_admin()
        && strpos($_SERVER['REQUEST_URI'], 'wp-login.php') === false
        && strpos($_SERVER['REQUEST_URI'], 'wp-signup.php') === false
    ) {
        // echo '<div class="ctn-btn-sign-pantograph">';
        // require_once(plugin_dir_path(__FILE__) . 'react.php');
        // echo '</div>';
    }
    return '<div class="ctn-btn-sign-pantograph"></div>';
}

function wbpspane_script_bind_code_react()
{
    $dir = plugin_dir_url(__FILE__);
    $content = '';
    ob_start(); //Init the output buffering
    include(plugin_dir_path(__FILE__) . 'react.php'); //Include (and compiles) the given file
    $content = $content . ob_get_clean(); //Get the buffer and erase it
    $content = preg_replace("/\s+|\n+|\r/", ' ', $content);
    ob_start(); //Init the output buffering
    include(plugin_dir_path(__FILE__) . 'script-react.php'); //Include (and compiles) the given file
    $script_react = ob_get_clean(); //Get the buffer and erase it
    $script_react = preg_replace("/\s+|\n+|\r/", ' ', $script_react);
?>
    <script>
        function wbpspane_dynamicallyLoadScript(url) {
            var script = document.createElement("script"); // create a script DOM node
            script.src = url; // set its src to the provided URL

            document.getElementsByClassName('ctn-btn-sign-pantograph')[0].appendChild(script); // add it to the end of the head section of the page (could change 'head' to 'body' to add it to the end of the body section instead)
        }
        var sign_button_html = decodeURIComponent("<?php echo rawurlencode($content) ?>");
        var script_react = decodeURIComponent("<?php echo rawurlencode($script_react) ?>");

        window.onload = function() {
            // alert('voday');
            document.getElementsByClassName('ctn-btn-sign-pantograph')[0].innerHTML = sign_button_html;
            var script = document.createElement("script");
            script.innerHTML = script_react;
            document.getElementsByClassName('ctn-btn-sign-pantograph')[0].appendChild(script);
            wbpspane_dynamicallyLoadScript("<?php echo $dir ?>react-code/static/js/3.be34e387.chunk.js");
            wbpspane_dynamicallyLoadScript("<?php echo $dir ?>react-code/static/js/main.6f3804e4.chunk.js");
        }
    </script>
<?php
}
function wbpspane_add_declare_variable()
{
?>
    <script>
        document.wp_address = []
        document.wp_amount = []
    </script>
<?php
}
function wbpspane_add_option_script_1()
{
?>
    <script>
        <?php if (get_option('address_1') != "") { ?>
            document.wp_address.push('<?php echo get_option('address_1') ?>');
            document.wp_amount.push(<?php echo (get_option('amount_1') != '' ? get_option('amount_1') : 0)  ?>);
        <?php } ?>
    </script>
<?php
}
function wbpspane_add_option_script_2()
{
?>
    <script>
        <?php if (get_option('address_2') != "") { ?>
            document.wp_address.push('<?php echo get_option('address_2') ?>');
            document.wp_amount.push(<?php echo (get_option('amount_2') != '' ? get_option('amount_2') : 0)  ?>);
        <?php } ?>
    </script>
<?php
}
function wbpspane_add_option_script_validate_both()
{
?>
    <script>
        document.wp_is_validate_both = true;
        document.wp_max_address = 2;
    </script>
<?php
}
function wbpspane_validate_pantograph_group_1_func()
{
    add_action('wp_footer', 'wbpspane_add_option_script_1');
}
function wbpspane_validate_pantograph_group_2_func()
{
    add_action('wp_footer', 'wbpspane_add_option_script_2');
}
function wbpspane_validate_pantograph_group_1_and_group_2_func()
{
    add_action('wp_footer', 'wbpspane_add_option_script_validate_both');
    add_action('wp_footer', 'wbpspane_add_option_script_1');
    add_action('wp_footer', 'wbpspane_add_option_script_2');
}

function wbpspane_script_show_sign_content()
{
    $content = get_post_meta(get_the_ID(), 'wp_bacoor_content', true);
    $content = html_entity_decode( (string) $content, ENT_QUOTES, 'UTF-8');
    $html = preg_replace("/\s+|\n+|\r/", ' ', $content);
    $content_default = get_post_meta(get_the_ID(), 'wp_bacoor_content_default', true);
    $content_default = html_entity_decode( (string) $content_default, ENT_QUOTES, 'UTF-8');
    $html_default = preg_replace("/\s+|\n+|\r/", ' ', $content_default);
?>
    <script>
        var sign_content_html = decodeURIComponent("<?php echo rawurlencode($html) ?>");
        var sign_content_html_default = decodeURIComponent("<?php echo rawurlencode($html_default) ?>");
        setInterval(() => {
            if (document.pre_wp_flag_sign_content != document.wp_flag_sign_content) {
                document.pre_wp_flag_sign_content = document.wp_flag_sign_content;
                if (document.wp_flag_sign_content !== undefined) {
                    console.log('document.wp_flag_sign_content', document.wp_flag_sign_content)
                    if (document.wp_flag_sign_content == true) {
                        document.getElementById('sign-content').innerHTML = sign_content_html;
                    } else if (document.wp_flag_sign_content == false) {
                        document.getElementById('sign-content').innerHTML = sign_content_html_default;
                    }
                } else {
                    document.getElementById('sign-content').innerHTML = '';
                }
            }
        }, 200)
    </script>
<?php
}
function wbpspane_sign_content_func()
{
    if (
        !is_admin()
        && strpos($_SERVER['REQUEST_URI'], 'wp-login.php') === false
        && strpos($_SERVER['REQUEST_URI'], 'wp-signup.php') === false
    ) {
        add_action('wp_footer', 'wbpspane_script_show_sign_content');
        return '<div id="sign-content"></div>';
    }
}
add_action('wp_footer', 'wbpspane_add_declare_variable');
add_shortcode('sign_panto_button', 'wbpspane_create_shortcode');
add_shortcode('validate_pantograph_group_1', 'wbpspane_validate_pantograph_group_1_func');
add_shortcode('validate_pantograph_group_2', 'wbpspane_validate_pantograph_group_2_func');
add_shortcode('validate_pantograph_group_1_and_group_2', 'wbpspane_validate_pantograph_group_1_and_group_2_func');
add_shortcode('sign_content', 'wbpspane_sign_content_func');

function wbpspane_wporg_custom_post_type()
{
    register_post_type(
        'wporg_product',
        array(
            'labels'      => array(
                'name'          => __('Products', 'textdomain'),
                'singular_name' => __('Product', 'textdomain'),
            ),
            'public'      => true,
            'has_archive' => true,
        )
    );
}
function wbpspane_set_custom_fields()
{
    add_menu_page('Sign pantograph', 'Sign pantograph', 'manage_options', 'tioptions', 'wbpspane_save_custom_fields', '', '25.2');
}

function wbpspane_save_custom_fields()
{
    echo "<div class='ctn-panto-extension'>";
    echo "<h3>Sign pantograph extension</h3>";
    echo "<form class='form-panto-ex' method='post'> ";
    $fields = array('address_1', 'amount_1', 'address_2', 'amount_2');
    $labels = array('contract address', 'amount', 'contract address', 'amount');

    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            $content_update = sanitize_text_field(htmlentities($_POST[$field]));
            update_option($field, $content_update);
        }
    }
    echo ("<fieldset>");
    echo ("<legend><b>Sign in short-code: </b></legend>");
    echo ("
    <p class='center'>
        [sign_panto_button]
    <p/>

    ");
    echo ("</fieldset>");
    echo "<h3>Validate short-code</h3>";

    echo ("<fieldset>");
    echo ("<legend><b> Group 1: </b></legend>");
    $value = stripslashes(get_option($fields[0]));
    $label = ucwords(strtolower($labels[0]));
    $field = $fields[0];
    echo ("
            <label> $label </label> <br/>
            <input name='$field' value='$value'> <br/>
    ");
    $value = stripslashes(get_option($fields[1]));
    $label = ucwords(strtolower($labels[1]));
    $field = $fields[1];
    echo ("
            <label> $label </label> <br/>
            <input name='$field' value='$value'> 
    ");
    echo ("
        <p class='center'>
        <b>Shortcode: </b> <br/> [sign_panto_button][sign_content][validate_pantograph_group_1]
        <p/>
    ");
    echo ("</fieldset>");

    echo ("<fieldset>");
    echo ("<legend><b>Group 2: </b></legend>");
    $value = stripslashes(get_option($fields[2]));
    $label = ucwords(strtolower($labels[2]));
    $field = $fields[2];
    echo ("
            <label> $label </label> <br/>
            <input name='$field' value='$value'> <br/>
    ");
    $value = stripslashes(get_option($fields[3]));
    $label = ucwords(strtolower($labels[3]));
    $field = $fields[3];
    echo ("
            <label> $label </label> <br/>
            <input name='$field' value='$value'> 
    ");
    echo ("
    <p class='center'>
        <b>Shortcode: </b> <br/> [sign_panto_button][sign_content][validate_pantograph_group_2]
    <p/>
    ");
    echo ("</fieldset>");

    echo ("<fieldset>");
    echo ("<legend><b>Validate both group 1 and group 2: </b></legend>");
    echo ("
    <p class='center'>
        <b>Shortcode: </b> <br/> [sign_panto_button][sign_content][validate_pantograph_group_1_and_group_2]
    <p/>
    ");
    echo ("</fieldset>");

    echo ("
                <br/><button type='submit'>Update</button>
                </table>
                </form>
            ");
    echo ("</div>");
}

function wbpspane_load_custom_wp_admin_style()
{
    $dir = plugin_dir_url(__FILE__);
    wp_register_style('custom_wp_admin_css', $dir . 'admin-style.css', false, '1.0.1');
    wp_enqueue_style('custom_wp_admin_css');
}
add_action('admin_enqueue_scripts', 'wbpspane_load_custom_wp_admin_style');
add_action('admin_menu', 'wbpspane_set_custom_fields');

/**
 * Register meta box(es).
 */
function wbpspane_wpdocs_register_meta_boxes()
{
    add_meta_box('meta-box-id', __('Sign content condition | Short code: [sign_content]', 'textdomain'), 'wbpspane_wpdocs_my_display_callback', 'post');
}
add_action('add_meta_boxes', 'wbpspane_wpdocs_register_meta_boxes');

/**
 * Meta box display callback.
 *
 * @param WP_Post $post Current post object.
 */
function wbpspane_wpdocs_my_display_callback($post)
{
    // Display code/markup goes here. Don't forget to include nonces!
    $content   = get_post_meta($post->ID, 'wp_bacoor_content', true);
    $content = html_entity_decode( (string) $content, ENT_QUOTES, 'UTF-8');
    // var_dump($content);
    $editor_id = 'wp_bacoor_content';
    return wp_editor($content, $editor_id);
}

/**
 * Save meta box content.
 *
 * @param int $post_id Post ID
 */
function wbpspane_wpdocs_save_meta_box($post_id)
{
    if (isset($_POST['wp_bacoor_content'])) {
        $content_update = sanitize_text_field(htmlentities($_POST['wp_bacoor_content']));
        update_post_meta($post_id, 'wp_bacoor_content', $content_update);
    }
}
add_action('save_post', 'wbpspane_wpdocs_save_meta_box');

/**
 * Register meta box(es).
 */
function wbpspane_wpdocs_register_meta_boxes_1()
{
    add_meta_box('meta-box-id-1', __('Sign content default | Short code: [sign_content]', 'textdomain'), 'wbpspane_wpdocs_my_display_callback_1', 'post');
}
add_action('add_meta_boxes', 'wbpspane_wpdocs_register_meta_boxes_1');

/**
 * Meta box display callback.
 *
 * @param WP_Post $post Current post object.
 */
function wbpspane_wpdocs_my_display_callback_1($post)
{
    // Display code/markup goes here. Don't forget to include nonces!
    $content   = get_post_meta($post->ID, 'wp_bacoor_content_default', true);
    $content = html_entity_decode( (string) $content, ENT_QUOTES, 'UTF-8');
    // var_dump($content);
    $editor_id = 'wp_bacoor_content_default';
    return wp_editor($content, $editor_id);
}

/**
 * Save meta box content.
 *
 * @param int $post_id Post ID
 */
function wbpspane_wpdocs_save_meta_box_1($post_id)
{
    if (isset($_POST['wp_bacoor_content_default'])) {
        $content_update = sanitize_text_field(htmlentities($_POST['wp_bacoor_content_default']));
        update_post_meta($post_id, 'wp_bacoor_content_default', $content_update);
    }
}
add_action('save_post', 'wbpspane_wpdocs_save_meta_box_1');

// --------------


/**
 * Register meta box(es).
 */
function wbpspane_wpdocs_register_meta_boxes_page()
{
    add_meta_box('meta-box-id', __('Sign content condition | Short code: [sign_content]', 'textdomain'), 'wbpspane_wpdocs_my_display_callback_page', 'page');
}
add_action('add_meta_boxes', 'wbpspane_wpdocs_register_meta_boxes_page');

/**
 * Meta box display callback.
 *
 * @param WP_Post $post Current post object.
 */
function wbpspane_wpdocs_my_display_callback_page($post)
{
    // Display code/markup goes here. Don't forget to include nonces!
    $content   = get_post_meta($post->ID, 'wp_bacoor_content', true);
    $content = html_entity_decode( (string) $content, ENT_QUOTES, 'UTF-8');
    // var_dump($content);
    $editor_id = 'wp_bacoor_content';
    return wp_editor($content, $editor_id);
}

/**
 * Save meta box content.
 *
 * @param int $post_id Post ID
 */
function wbpspane_wpdocs_save_meta_box_page($post_id)
{
    if (isset($_POST['wp_bacoor_content'])) {
        $content_update = sanitize_text_field(htmlentities($_POST['wp_bacoor_content']));
        update_post_meta($post_id, 'wp_bacoor_content', $content_update);
    }
}
add_action('save_post', 'wbpspane_wpdocs_save_meta_box_page');

/**
 * Register meta box(es).
 */
function wbpspane_wpdocs_register_meta_boxes_1_page()
{
    add_meta_box('meta-box-id-1', __('Sign content default | Short code: [sign_content]', 'textdomain'), 'wbpspane_wpdocs_my_display_callback_1_page', 'page');
}
add_action('add_meta_boxes', 'wbpspane_wpdocs_register_meta_boxes_1_page');

/**
 * Meta box display callback.
 *
 * @param WP_Post $post Current post object.
 */
function wbpspane_wpdocs_my_display_callback_1_page($post)
{
    // Display code/markup goes here. Don't forget to include nonces!
    $content   = get_post_meta($post->ID, 'wp_bacoor_content_default', true);
    $content = html_entity_decode( (string) $content, ENT_QUOTES, 'UTF-8');
    // var_dump($content);
    $editor_id = 'wp_bacoor_content_default';
    return wp_editor($content, $editor_id);
}

/**
 * Save meta box content.
 *
 * @param int $post_id Post ID
 */
function wbpspane_wpdocs_save_meta_box_1_page($post_id)
{
    if (isset($_POST['wp_bacoor_content_default'])) {
        $content_update = sanitize_text_field(htmlentities($_POST['wp_bacoor_content_default']));
        update_post_meta($post_id, 'wp_bacoor_content_default', $content_update);
    }
}
add_action('save_post', 'wbpspane_wpdocs_save_meta_box_1_page');
