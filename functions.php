<?php
/**
 * blogshop functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package blogshop
 */
if ( ! function_exists( 'blogshop_setup' ) ) :
/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
function blogshop_setup() {
	/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on blogshop, use a find and replace
		 * to change 'blogshop' to the name of your theme in all the template files.
		 */
	load_theme_textdomain( 'blogshop', get_template_directory() . '/languages' );
	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );
	/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
	add_theme_support( 'title-tag' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'blogshop-thumbnail-mobile', 350, 250, true );
	add_image_size( 'blogshop-list-thumbnail', 380, 320, true );
	add_image_size( 'blogshop-thumbnail-medium', 770, 350, true );
	add_image_size( 'blogshop-thumbnail-larger', 1170, 650, true );
	add_image_size( 'blogshop-latest-post-widget-thumb', 120, 120, true );
	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'main-menu' => esc_html__( 'Primary', 'blogshop' ),
			'footer-menu' => esc_html__( 'Footer Menu', 'blogshop' ),
		)
	);
	add_theme_support( 'woocommerce' );
	/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		)
	);
	add_theme_support( 
		'post-formats',
		array( 
			'aside',
			'chat',
			'gallery',
			'image',
			'link',
			'quote',
			'status',
			'video',
			'audio'
		)
	);
	// Set up the WordPress core custom background feature.
	add_theme_support('custom-background', apply_filters(
		'blogshop_custom_background_args',
		array(
			'default-color' => 'ffffff',
			'default-image' => '',
		)
	)
					 );
	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );
	// Add theme support for selective refresh for widgets.
	add_theme_support( 'editor-styles' );
	add_theme_support( 'wp-block-styles' );
	add_editor_style('css/bootstra.css');
	/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'blogshop_content_width', 640 );
}
endif;
add_action( 'after_setup_theme', 'blogshop_setup' );




/**
 * Register widgets
 */
require get_template_directory() . '/inc/register-widgets.php';
/**
 * Enqueue scripts
 */
require get_template_directory() . '/inc/enqueue-scripts.php';
/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';
/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';
/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';
/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';
/**
 * blogshop Comment Template.
 */
require get_template_directory() . '/inc/comment-template.php';

/**
 * blogshop sanitize functions.
 */
require get_template_directory() . '/inc/sanitize-functions.php';

/**
 * Checkout Fields
 */
require get_template_directory() . '/inc/checkout-fields.php';
/**
 * Recent Post Widget
 */
require get_template_directory() . '/inc/recent-post.php';
/**
 * TGM plugin Activation
 */
require get_template_directory() . '/inc/tgm/required-plugin.php';

if (class_exists('woocommerce')) {
	require get_template_directory() . '/inc/woocommerce-modification.php';
}
/**
 * Fix skip link focus in IE11.
 *
 * This does not enqueue the script because it is tiny and because it is only for IE11,
 * thus it does not warrant having an entire dedicated blocking script being loaded.
 *
 * @link https://git.io/vWdr2
 */ 
function blogshop_skip_link_focus_fix() {
	// The following is minified via `terser --compress --mangle -- js/skip-link-focus-fix.js`.
?>
<script>
	/(trident|msie)/i.test(navigator.userAgent)&&document.getElementById&&window.addEventListener&&window.addEventListener("hashchange",function(){var t,e=location.hash.substring(1);/^[A-z0-9_-]+$/.test(e)&&(t=document.getElementById(e))&&(/^(?:a|select|input|button|textarea)$/i.test(t.tagName)||(t.tabIndex=-1),t.focus())},!1);
</script>
<?php
}
add_action( 'wp_print_footer_scripts', 'blogshop_skip_link_focus_fix' );

/*update to pro link*/
require_once( trailingslashit( get_template_directory() ) . 'blogshoppro/class-customize.php' );


function block_common_user_in_destach_category(){
	$user = wp_get_current_user();
	$user_id = get_current_user_id();
	//echo $user_id;
	$allowed_roles = array('editor', 'administrator', 'atacadista');
	$aproved = get_field('cadastro_aprovado', 'user_'. $user_id );
	if( is_product_category( array( 27 ) ) ) {
		if(!array_intersect($allowed_roles, $user->roles ) || ($aproved === false)){
?><script>
	swal({
		title: "Opss...",
		text: "Essa área do site é visível apenas para os usuários atacadistas que tiveram o perfil aprovado pela Artlex.",
		buttons: {
			// 						cancel: "Voltar Para o Site",
			request: {
				text: "Não tenho cadastro",
				value: "request",
			},
			login: {
				text: "Já sou cadastrado",
				value: "login",
			}
		},
	})
		.then((value) => {
		switch (value) {
			case "request":
				swal("Você será redirecionado para a página de cadastro");
				window.location.href = "https://artlex.com.br/registrar-atacadista/";
				break;
			case "login":
				window.location.href = "https://artlex.com.br/registrar-atacadista/";
				break;
			default:

		}
	});
</script><?php

		} if(array_intersect($allowed_roles, $user->roles ) || ($aproved === false)){
		    ?><script>
            	swal({
            		title: "Opss...",
            		text: "Seu perfil atacadista ainda está em análise. Em breve teremos novidades",
            		buttons: {
            			// 						cancel: "Voltar Para o Site",
            			request: {
            				text: "Voltar para Home",
            				value: "request",
            			}
            		},
            	})
            		.then((value) => {
            		switch (value) {
            			case "request":
            				swal("Você será redirecionado para a página de cadastro");
            				window.location.href = "https://artlex.com.br/";
            				break;
            			case "login":
            				window.location.href = "https://artlex.com.br/";
            				break;
            			default:
            
            		}
            	});
            </script><?php
		}
	} else if(!array_intersect($allowed_roles, $user->roles ) || ($aproved === false)){
		?>
			<style>
				li.product.type-product.status-publish.product_cat-atacado.has-post-thumbnail.purchasable.product-type-simple{
					display:none!important;
				}
			</style>
		<?php
	}
}

add_action('woocommerce_before_shop_loop', 'block_common_user_in_destach_category', 1);
function add_custom_scripts_atacadista_project(){
	?><script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script><?php
}
add_action('wp_head', 'add_custom_scripts_atacadista_project');


function wooc_extra_register_fields() {

	global $post;

	if( $post->ID == 978) { 
?>

<p class="form-row form-row-first">
	<label for="reg_billing_first_name"><?php _e( 'First name', 'woocommerce' ); ?><span class="required">*</span></label>
	<input type="text" class="input-text" name="billing_first_name" id="reg_billing_first_name" value="<?php if ( ! empty( $_POST['billing_first_name'] ) ) esc_attr_e( $_POST['billing_first_name'] ); ?>" />
</p>
<p class="form-row form-row-last">
	<label for="reg_billing_last_name"><?php _e( 'Last name', 'woocommerce' ); ?><span class="required">*</span></label>
	<input type="text" class="input-text" name="billing_last_name" id="reg_billing_last_name" value="<?php if ( ! empty( $_POST['billing_last_name'] ) ) esc_attr_e( $_POST['billing_last_name'] ); ?>" />
</p>
<p class="form-row form-row-wide">
	<label for="billing_cpf"><?php _e( 'CPF', 'woocommerce' ); ?><span class=""></span></label>
	<input type="text" class="input-text" name="billing_cpf" id="billing_cpf" value="<?php if ( ! empty( $_POST['billing_cpf'] ) ) esc_attr_e( $_POST['billing_cpf'] ); ?>" />
</p>

<p class="form-row form-row-wide">
	<label for="billing_cellphone"><?php _e( 'Celular(Whatsapp)', 'woocommerce' ); ?><span class="required">*</span></label>
	<input type="text" class="input-text" name="billing_cellphone" id="billing_cellphone" value="<?php esc_attr_e( $_POST['billing_cellphone'] ); ?>" />
</p>
<p class="form-row form-row-wide">
	<label for="reg_billing_phone"><?php _e( 'Phone', 'woocommerce' ); ?><span class="required">*</span></label>
	<input type="text" class="input-text" name="billing_phone" id="reg_billing_phone" value="<?php esc_attr_e( $_POST['billing_phone'] ); ?>" />
</p>

<p class="form-row form-row-wide">
	<label for="billing_address_1"><?php _e( 'Endereço', 'woocommerce' ); ?><span class="required">*</span></label>
	<input type="text" class="input-text" name="billing_address_1" id="billing_address_1" value="<?php esc_attr_e( $_POST['billing_address_1'] ); ?>" />
</p>
<p class="form-row form-row-wide">
	<label for="billing_number"><?php _e( 'Número', 'woocommerce' ); ?><span class="required">*</span></label>
	<input type="text" class="input-text" name="billing_number" id="billing_number" value="<?php esc_attr_e( $_POST['billing_number'] ); ?>" />
</p>
<p class="form-row form-row-wide">
	<label for="billing_number"><?php _e( 'Complemento', 'woocommerce' ); ?><span class="required">*</span></label>
	<input type="text" class="input-text" name="billing_address_2" id="billing_address_2" value="<?php esc_attr_e( $_POST['billing_address_2'] ); ?>" />
</p>
<p class="form-row form-row-wide">
	<label for="billing_neighborhood"><?php _e( 'Bairro', 'woocommerce' ); ?><span class="required">*</span></label>
	<input type="text" class="input-text" name="billing_neighborhood" id="billing_neighborhood" value="<?php esc_attr_e( $_POST['billing_neighborhood'] ); ?>" />
</p>
<p class="form-row form-row-wide">
	<label for="billing_city"><?php _e( 'Cidade', 'woocommerce' ); ?><span class="required">*</span></label>
	<input type="text" class="input-text" name="billing_city" id="billing_city" value="<?php esc_attr_e( $_POST['billing_city'] ); ?>" />
</p>
<p class="form-row form-row-wide">
	<label for="billing_state"><?php _e( 'Estado', 'woocommerce' ); ?><span class="required">*</span></label>
	<input type="text" class="input-text" name="billing_state" id="billing_state" value="<?php esc_attr_e( $_POST['billing_state'] ); ?>" />
</p>
<p class="form-row form-row-wide">
	<label for="billing_postcode"><?php _e( 'CEP', 'woocommerce' ); ?><span class="required">*</span></label>
	<input type="text" class="input-text" name="billing_postcode" id="billing_postcode" value="<?php esc_attr_e( $_POST['billing_postcode'] ); ?>" />
</p>

<p class="form-row form-row-wide">
	<label for="reg_nome_fantasia"><?php _e( 'Nome Fantasia', 'woocommerce' ); ?><span class="required">*</span></label>
	<input type="text" class="input-text" name="nome_fantasia" id="reg_nome_fantasia" value="<?php esc_attr_e( $_POST['nome_fantasia'] ); ?>" />
</p>
<p class="form-row form-row-wide">
	<label for="reg_razao_social"><?php _e( 'Razão Social', 'woocommerce' ); ?><span class="required">*</span></label>
	<input type="text" class="input-text" name="razao_social" id="reg_razao_social" value="<?php esc_attr_e( $_POST['razao_social'] ); ?>" />
</p>
<p class="form-row form-row-wide">
	<label for="reg_cnpj"><?php _e( 'CNPJ', 'woocommerce' ); ?><span class="required">*</span></label>
	<input type="text" class="input-text" name="cnpj" id="reg_cnpj" value="<?php esc_attr_e( $_POST['cnpj'] ); ?>" />
</p>
<p class="form-row form-row-wide">
	<label for="reg_inscricao_estadual"><?php _e( 'Inscrição Estadual', 'woocommerce' ); ?><span class="required">*</span></label>
	<input type="text" class="input-text" name="inscricao_estadual" id="reg_inscricao_estadual" value="<?php esc_attr_e( $_POST['inscricao_estadual'] ); ?>" />
	<small>Deixe em branco caso seja isento</small>
</p>
<input name="formAtacado" value="true" type="hidden">

<div class="clear"></div>

<script>
	jQuery(document).ready(function(){
		jQuery('input#reg_billing_phone').mask('(00) 0000-0000');
		jQuery('input#billing_cellphone').mask('(00) 00000-0000');
		jQuery('input#reg_inscricao_estadual').mask('0000000000000000000000000');
		jQuery('input#billing_number').mask('0000000');
		
		jQuery('input#billing_postcode').mask('00.000-000');
		jQuery('input#billing_cpf').mask('000.000.000-00');
		jQuery('input#reg_cnpj').mask('00.000.000/0000-00');
	});
</script>

<?php
						  }
}
add_action( 'woocommerce_register_form_start', 'wooc_extra_register_fields' );

function wooc_validate_extra_register_fields( $username, $email, $validation_errors ) {
	if(isset($_POST['formAtacado'])){
		if ( isset( $_POST['billing_first_name'] ) && empty( $_POST['billing_first_name'] ) ) {
			$validation_errors->add( 'billing_first_name_error', __( '<strong>Error</strong>: Nome é obrigatório', 'woocommerce' ) );
		}
		if ( isset( $_POST['billing_cellphone'] ) && empty( $_POST['billing_cellphone'] ) ) {
			$validation_errors->add( 'billing_cellphone', __( '<strong>Error</strong>: Celular é obrigatório', 'woocommerce' ) );
		}
		if ( isset( $_POST['billing_phone'] ) && empty( $_POST['billing_phone'] ) ) {
			$validation_errors->add( 'billing_phone', __( '<strong>Error</strong>: Telefone é obrigatório', 'woocommerce' ) );
		}
		if ( isset( $_POST['billing_cpf'] ) && empty( $_POST['billing_cpf'] ) ) {
			//$validation_errors->add( 'billing_cpf', __( '<strong>Error</strong>: CPF é obrigatório', 'woocommerce' ) );
		}
		if ( isset( $_POST['billing_last_name'] ) && empty( $_POST['billing_last_name'] ) ) {
			$validation_errors->add( 'billing_last_name_error', __( '<strong>Error</strong>: Sobrenome é obrigatório', 'woocommerce' ) );
		}
		if ( isset( $_POST['nome_fantasia'] ) && empty( $_POST['nome_fantasia'] ) ) {
			$validation_errors->add( 'nome_fantasia', __( '<strong>Erro:</strong>: Nome Fantasia é obrigatório', 'woocommerce' ) );
		}
		if ( isset( $_POST['razao_social'] ) && empty( $_POST['razao_social'] ) ) {
			$validation_errors->add( 'razao_social', __( '<strong>Erro:</strong>: Razão Social é obrigatório', 'woocommerce' ) );
		}
		if ( isset( $_POST['cnpj'] ) && empty( $_POST['cnpj'] ) ) {
			$validation_errors->add( 'cnpj', __( '<strong>Erro:</strong>: CNPJ é obrigatório', 'woocommerce' ) );
		}
		if ( isset( $_POST['billing_address_1'] ) && empty( $_POST['billing_address_1'] ) ) {
			$validation_errors->add( 'billing_address_1', __( '<strong>Erro:</strong>: Endereço é obrigatório', 'woocommerce' ) );
		}
		if ( isset( $_POST['billing_neighborhood'] ) && empty( $_POST['billing_neighborhood'] ) ) {
			$validation_errors->add( 'billing_address_2', __( '<strong>Erro:</strong>: Bairro é obrigatório', 'woocommerce' ) );
		}
		if ( isset( $_POST['billing_city'] ) && empty( $_POST['billing_city'] ) ) {
			$validation_errors->add( 'billing_city', __( '<strong>Erro:</strong>: Cidade é obrigatório', 'woocommerce' ) );
		}
		if ( isset( $_POST['billing_postcode'] ) && empty( $_POST['billing_postcode'] ) ) {
			$validation_errors->add( 'billing_postcode', __( '<strong>Erro:</strong>: CEP é obrigatório', 'woocommerce' ) );
		}
		if ( isset( $_POST['billing_state'] ) && empty( $_POST['billing_state'] ) ) {
			$validation_errors->add( 'billing_state', __( '<strong>Erro:</strong>: Estado é obrigatório', 'woocommerce' ) );
		}
	}

	return $validation_errors;
}
add_action( 'woocommerce_register_post', 'wooc_validate_extra_register_fields', 10, 3 );

function woocom_save_extra_register_fields($customer_id) {
	if (isset($_POST['nome_fantasia'])) {
		$user = new WP_User( $customer_id );
		$user->remove_role( 'customer' ); 
		$user->add_role( 'atacadista' );
	}
	update_field('nome_fantasia', 'nome', 'user_'.$customer_id);
	update_field('nome_fantasia', $_POST['nome_fantasia'], 'user_'.$customer_id);
	update_field('razao_social', $_POST['razao_social'], 'user_'.$customer_id);
	update_field('cnpj', $_POST['cnpj'], 'user_'.$customer_id);
	if(strlen($_POST['inscricao_estadual']) > 1){
		update_field('isento_inscricao_estadual', 0, 'user_'.$customer_id);
	} else {
		update_field('isento_inscricao_estadual', 1, 'user_'.$customer_id);
	}
	update_field('inscricao_estadual', $_POST['inscricao_estadual'], 'user_'.$customer_id);

	if ( isset( $_POST['billing_phone'] ) ) {
		// Phone input filed which is used in WooCommerce
		update_user_meta( $customer_id, 'billing_phone', sanitize_text_field( $_POST['billing_phone'] ) );
	}
	if ( isset( $_POST['billing_first_name'] ) ) {
		//First name field which is by default
		update_user_meta( $customer_id, 'first_name', sanitize_text_field( $_POST['billing_first_name'] ) );
		// First name field which is used in WooCommerce
		update_user_meta( $customer_id, 'billing_first_name', sanitize_text_field( $_POST['billing_first_name'] ) );
	}
	if ( isset( $_POST['billing_last_name'] ) ) {
		// Last name field which is by default
		update_user_meta( $customer_id, 'last_name', sanitize_text_field( $_POST['billing_last_name'] ) );
		// Last name field which is used in WooCommerce
		update_user_meta( $customer_id, 'billing_last_name', sanitize_text_field( $_POST['billing_last_name'] ) );
	}
	if ( isset( $_POST['billing_address_1'] ) ) {
		update_user_meta( $customer_id, 'billing_address_1', sanitize_text_field( $_POST['billing_address_1'] ) );
		update_user_meta( $customer_id, 'billing_neighborhood', sanitize_text_field( $_POST['billing_neighborhood'] ) );
		update_user_meta( $customer_id, 'billing_phone', sanitize_text_field( $_POST['billing_phone'] ) );
		update_user_meta( $customer_id, 'billing_cellphone', sanitize_text_field( $_POST['billing_cellphone'] ) );
		update_user_meta( $customer_id, 'billing_city', sanitize_text_field( $_POST['billing_city'] ) );
		update_user_meta( $customer_id, 'billing_postcode', sanitize_text_field( $_POST['billing_postcode'] ) );
		update_user_meta( $customer_id, 'billing_number', sanitize_text_field( $_POST['billing_number'] ) );
		update_user_meta( $customer_id, 'billing_cpf', sanitize_text_field( $_POST['billing_cpf'] ) );
		update_user_meta( $customer_id, 'billing_state', sanitize_text_field( $_POST['billing_state'] ) );
	}


	/*
	if (isset($_POST['billing_last_name'])) {
		update_user_meta($customer_id, 'billing_last_name', sanitize_text_field($_POST['billing_last_name']));
	}
	*/
}
add_action('woocommerce_created_customer', 'woocom_save_extra_register_fields');

function filter_gateaways(){
	$user = wp_get_current_user();
	$user_id = get_current_user_id();
	$min_value = get_field('valor_minimo', 'user_'.$user_id);
	$max_value = get_field('valor_minimo', 'user_'.$user_id);


	if((WC()->cart->cart_contents_total < $min_value) || (WC()->cart->cart_contents_total > $max_value)){
?>
<style>
	li.wc_payment_method.payment_method_other_payment{
		display: none!important;
	}
</style>

<script></script>

<?php
	}
}
// add_action('wp_head', 'filter_gateaways');

function change_text_gateaways(){
	
	$user_id = get_current_user_id();
	$tempo_para_pagamento = get_field('tempo_para_pagamento', 'user_'.$user_id);
	
	?>
		<script>
			jQuery(document).ready(function(){
				var time_payment_user = "<?php echo $tempo_para_pagamento; ?>";
				console.log(time_payment_user);
				var my = jQuery(".payment_box.payment_method_other_payment p.form-row.form-row-wide").html();
				console.log(my);
				jQuery(".payment_box.payment_method_other_payment label").html("some value");
				jQuery(".payment_box.payment_method_other_payment label").val("Pagamento Parcelado em " + time_payment_user);
			});
		</script>
	<?php
}

add_action('wp_footer', 'change_text_gateaways');

function masks_checkout(){
?>
<script>
	jQuery(document).ready(function(){
		jQuery(‘span.date, input.date’).mask(’00/00/0000′);
	})
</script>
<?php
}

//add_action('wp_footer', 'masks_checkout');

function redirect_visitor(){
	if ( is_page( 'checkout' ) || is_checkout() ) {
		if ( !is_user_logged_in()) {
			wp_redirect('https://artlex.com.br/cadastrar-email-antes-da-conta/');
			return home_url('/cadastrar-email-antes-da-conta/');
		}
	}
}
add_action('template_redirect','redirect_visitor');

function Finput_register_email(){

?>
<style>
	.u-column1.col-1{
		display: none!important;
	}
</style>

<?php
	echo do_shortcode('[woocommerce_my_account]');
}
add_shortcode('input_register_email','Finput_register_email');

function custom_registration_redirect() {
	if(WC()->cart->cart_contents_count > 0){	
		wp_redirect('https://artlex.com.br/cadastrar-email-antes-da-conta/');
	}
}
// add_action('woocommerce_registration_redirect', 'custom_registration_redirect', 2);


// Customizar Colunas Usuário Atacadista
function linked_url() {
	add_menu_page( 'linked_url', 'Usuários Atacadistas', 'read', 'users.php?role=atacadista', '', 'dashicons-admin-users', 3 );
	add_menu_page( 'linked_url', 'Pedidos Atacadistas', 'read', 'edit.php?post_status=wc-atacadista-aprova&post_type=shop_order', '', 'dashicons-screenoptions', 4 );
}
add_action( 'admin_menu', 'linked_url' );

function add_users_columns( $columns ) {
	$columns['atacadista'] = __( 'Atacadista' );
	return $columns;
}
add_filter( 'manage_users_columns', 'add_users_columns' );

function filter_users_columns ($val, $column, $user_id ) {
	switch ( $column ) {
		case 'atacadista':
			$cadastro_aprovado = get_field('cadastro_aprovado', 'user_'.$user_id);
			$value;
			if($cadastro_aprovado == true){
				$value = "Aprovado";
			} else {
				$value = "Recusado";
			}
			return $value;
	}
	return $val;
}
add_filter( 'manage_users_custom_column', 'filter_users_columns', 10, 3);

function my_sortable_user_atacadista_column( $columns ) {
	$columns['atacadista'] = 'atacadista';
	return $columns;
}
add_filter( 'manage_users_sortable_columns', 'my_sortable_user_atacadista_column' );


function exclude_category($query) {
	if ( $query->is_front_page ) {
		$category_ID1 = get_cat_id('atacado');
		$category_ID2 = get_cat_id('atacado');
		$query->set('cat',"-$category_ID1 -$category_ID2");
	} return $query;
} 
add_filter('pre_get_posts', 'exclude_category');

function analise_atacadista(){
	$user_id = get_current_user_id();
	$allowed_roles = array('editor', 'administrator', 'atacadista');
	$aproved = get_field('cadastro_aprovado', 'user_'. $user_id );
	if(!array_intersect($allowed_roles, $user->roles ) || ($aproved === false)){
		// 		
		// 			

		$min_value = get_field('valor_minimo', 'user_'. $user_id );
		$max_value = get_field('valor_maximo', 'user_'. $user_id );
		$time_payment = get_field('tempo_para_pagamento', 'user_'. $user_id );

		foreach($time_payment as $time){
			$message_payment .= $time.", ";
		}

?><hr><?php 
		if($aproved){
?>
<h3 style="color:red">Seu perfil atacadista está aprovado!!</h3>
<span style="color:red">
	Seus valores aprovados para a compra são:<br>
	Valor Mínimo: R$<?php echo $min_value ?>,00;<br>
	Valor Máximo: R$<?php echo $max_value ?>,00.
</span><br>
<span style="color:red">Seu pagamento poderá ser parcelado em <?php echo $message_payment; ?></span>
<?php
					} else {
?>
<h3 style="color:red">Seu perfil atacadista ainda está em análise</h3>
<span  style="color:red">Em breve teremos novidades</span>
<?php
		}
	}

}

add_action('woocommerce_account_content', 'analise_atacadista');

function customize_order_atacadista(){
	global $order, $post;
    if( ! is_a($order, 'WC_Order') ) {
        $order_id = $post->ID;
    } else {
        $order_id = $order->id;
    }
    // Get the user ID
    $user_id = get_post_meta($order_id, '_customer_user', true);
	
	$name_enterprise = get_field('nome_fantasia', 'user_'. $user_id );
	$name_social = get_field('razao_social', 'user_'. $user_id );
	$cnpj = get_field('cnpj', 'user_'. $user_id );
	$ie = get_field('inscricao_estadual', 'user_'. $user_id );
	$time = get_field('tempo_para_pagamento', 'user_'. $user_id );
?>

	<p><b>Nome Fantasia: </b><?php echo $name_enterprise; ?><br>
	<b>Razão Social: </b><?php echo $name_social; ?><br>
	<b>CNPJ: </b><?php echo $cnpj; ?><br>
	<b>Inscrição Estadual: </b><?php echo $ie; ?><br>
	<b>Tempo para faturamento: </b><?php echo $time; ?></p>

	<?php
}
add_action('woocommerce_admin_order_data_after_billing_address', 'customize_order_atacadista', 5);
