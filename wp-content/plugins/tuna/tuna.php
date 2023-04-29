<?php

/**
* Plugin Name: Produtos Tuna
* Description: Adiciona dois tipos de produtos: cartoes simples e cartoes personalizados
* Author: Ana Amelia Mendes Galvao
* Author URI: https://github.com/ameliagalvao
* Version: 1.0
*/

defined( 'ABSPATH' ) or exit;

//--------------------- Create new product type ---------------------
function tuna_register_custom_card_product_type() {
class WC_Product_Custom_Card extends WC_Product_Simple {

public function __construct( $product ) {
$this->product_type = 'custom_card';
parent::__construct( $product );
}
public function get_type() {
    return 'custom_card';
}
}
}
add_action( 'init', 'tuna_register_custom_card_product_type' );
//-------------------------------------------------------------

//--------------------- Add new product type to the product type selector ---------------------
add_filter( 'product_type_selector', 'tuna_add_custom_card_product_type' );
function tuna_add_custom_card_product_type( $types ){
$types[ 'custom_card' ] = __( 'Cartão Personalizado', 'custom_card_product' );
return $types; 
}
//-------------------------------------------------------------

//--------------------- Add general tab (prices) ---------------------
function tuna_add_price_and_inventory_custom_js() {

	if ( 'product' != get_post_type() ) :
		return;
	endif;

	?><script type='text/javascript'>
		jQuery( document ).ready( function() {
            // Price
			jQuery('.product_data_tabs .general_tab').addClass('show_if_custom_card').show();
            jQuery('#general_product_data .pricing').addClass('show_if_custom_card').show();
            //for Inventory tab
            // Inventory
            jQuery('.inventory_options').addClass('show_if_custom_card').show();
            jQuery('#inventory_product_data ._manage_stock_field').addClass('show_if_custom_card').show();
            jQuery('#inventory_product_data ._sold_individually_field').parent().addClass('show_if_custom_card').show();
            jQuery('#inventory_product_data ._sold_individually_field').addClass('show_if_custom_card').show();
		});

	</script><?php

}
add_action( 'admin_footer', 'tuna_add_price_and_inventory_custom_js' );
//-------------------------------------------------------------

//--------------------- Edit tabs from product data ---------------------
add_filter( 'woocommerce_product_data_tabs', 'tuna_custom_card_product_tab' );
function tuna_custom_card_product_tab( $tabs) {

unset($tabs['attribute']); // remove attribute tab
unset($tabs['advanced']); // remove advanced tab

// Add tab size
$tabs['size_tab'] = array(
'label' => __( 'Tamanhos**', 'custom_card_size' ),
'target' => 'custom_card_size_options',
'class' => 'show_if_custom_card',
);

// Add tab paletas
$tabs['paletas_tab'] = array(
    'label' => __( 'Paletas**', 'custom_card_paletas' ),
    'target' => 'custom_card_paletas_options',
    'class' => 'show_if_custom_card',
    );

// Add tab envelopes
$tabs['envelope_tab'] = array(
    'label' => __( 'Envelopes**', 'custom_card_envelopes' ),
    'target' => 'custom_card_envelopes_options',
    'class' => 'show_if_custom_card',
    );
return $tabs;
}
//-------------------------------------------------------------

//--------------------- Set content for palletes tab ---------------------
add_action( 'woocommerce_product_data_panels', 'tuna_custom_card_options_paletas_tab_content' );

function tuna_custom_card_options_paletas_tab_content() {
?><div id='custom_card_paletas_options' class='panel woocommerce_options_panel'><?php
?><div class='options_group'>
<div style="padding: 10px">
<p style="font-weight:700;">Paleta 1</p>
</div>
</div>
</div><?php
}
//-------------------------------------------------------------

//--------------------- Set content for sizes tab ---------------------
add_action( 'woocommerce_product_data_panels', 'tuna_custom_card_options_palettes_tab_content' );

function tuna_custom_card_options_palettes_tab_content() {
?><div id='custom_card_size_options' class='panel woocommerce_options_panel'><?php
?><div class='options_group'><?php
echo '<span style="padding-left: 10px">Tamanhos disponíveis: </span>';
    woocommerce_wp_checkbox( array(
    'id'          => '_tuna_card_size_pp_checkbox',
    'label' => __( 'Tamanho PP', 'woocommerce' ),
    ) );
      woocommerce_wp_checkbox( array(
        'id'          => '_tuna_card_size_p_checkbox',
        'label' => __( 'Tamanho P', 'woocommerce' ),
      ) );
    woocommerce_wp_checkbox( array(
      'id'          => '_tuna_card_size_m_checkbox',
      'label' => __( 'Tamanho M', 'woocommerce' ),
      ) );
      woocommerce_wp_checkbox( array(
      'id'          => '_tuna_card_size_g_checkbox',
      'label' => __( 'Tamanho G', 'woocommerce' ),
      ) );
?></div>
</div><?php
}
//-------------------------------------------------------------

//--------------------- Set content for envelopes tab ---------------------
add_action( 'woocommerce_product_data_panels', 'tuna_custom_card_options_envelopes_tab_content' );

function tuna_custom_card_options_envelopes_tab_content() {
?><div id='custom_card_envelopes_options' class='panel woocommerce_options_panel'><?php
?><div class='options_group'>
<div style="padding: 10px">
<p style="font-weight:700;">Paleta 1</p>
<?php 
// Cor 1
 woocommerce_wp_text_input(array(
  'id'          => '_palette_1_color_1',
  'label'       => __('Cor 1', 'woocommerce'),
  'placeholder' => '',
  'description' => __('Escolha a cor que sera exibida para o usuario', 'woocommerce'),
  'type'        => 'color',
));
// Cor 2
woocommerce_wp_text_input(array(
  'id'          => '_palette_1_color_2',
  'label'       => __('Cor 2', 'woocommerce'),
  'placeholder' => '',
  'description' => __('Escolha a cor que sera exibida para o usuario', 'woocommerce'),
  'type'        => 'color',
));
// Cor 3
woocommerce_wp_text_input(array(
  'id'          => '_palette_1_color_3',
  'label'       => __('Cor 3', 'woocommerce'),
  'placeholder' => '',
  'description' => __('Escolha a cor que sera exibida para o usuario', 'woocommerce'),
  'type'        => 'color',
));
?>
<div style="border-bottom: 1px solid lightgray;"></div>
<p style="font-weight:700;">Paleta 2</p>
<?php 
// Cor 1
 woocommerce_wp_text_input(array(
  'id'          => '_palette_2_color_1',
  'label'       => __('Cor 1', 'woocommerce'),
  'placeholder' => '',
  'description' => __('Escolha a cor que sera exibida para o usuario', 'woocommerce'),
  'type'        => 'color',
));
// Cor 2
woocommerce_wp_text_input(array(
  'id'          => '_palette_2_color_2',
  'label'       => __('Cor 2', 'woocommerce'),
  'placeholder' => '',
  'description' => __('Escolha a cor que sera exibida para o usuario', 'woocommerce'),
  'type'        => 'color',
));
// Cor 3
woocommerce_wp_text_input(array(
  'id'          => '_palette_2_color_3',
  'label'       => __('Cor 3', 'woocommerce'),
  'placeholder' => '',
  'description' => __('Escolha a cor que sera exibida para o usuario', 'woocommerce'),
  'type'        => 'color',
));
?>
<div style="border-bottom: 1px solid lightgray;"></div>
<p style="font-weight:700;">Paleta 3</p>
<?php 
// Cor 1
 woocommerce_wp_text_input(array(
  'id'          => '_palette_3_color_1',
  'label'       => __('Cor 1', 'woocommerce'),
  'placeholder' => '',
  'description' => __('Escolha a cor que sera exibida para o usuario', 'woocommerce'),
  'type'        => 'color',
));
// Cor 2
woocommerce_wp_text_input(array(
  'id'          => '_palette_3_color_2',
  'label'       => __('Cor 2', 'woocommerce'),
  'placeholder' => '',
  'description' => __('Escolha a cor que sera exibida para o usuario', 'woocommerce'),
  'type'        => 'color',
));
// Cor 3
woocommerce_wp_text_input(array(
  'id'          => '_palette_3_color_3',
  'label'       => __('Cor 3', 'woocommerce'),
  'placeholder' => '',
  'description' => __('Escolha a cor que sera exibida para o usuario', 'woocommerce'),
  'type'        => 'color',
));
?>
</div>
</div>
</div><?php
}
//-------------------------------------------------------------

//--------------------- Function to save data ---------------------
add_action( 'woocommerce_process_product_meta', 'tuna_save_custom_size_checkbox',  10, 2 );

function tuna_save_custom_size_checkbox( $id, $post ){
  // Save custom color field - Paleta 1
  $custom_color = isset($_POST['_palette_1_color_1']) ? sanitize_text_field($_POST['_palette_1_color_1']) : '';
  update_post_meta( $id, '_palette_1_color_1', $custom_color );
  $custom_color = isset($_POST['_palette_1_color_2']) ? sanitize_text_field($_POST['_palette_1_color_2']) : '';
  update_post_meta( $id, '_palette_1_color_2', $custom_color );
  $custom_color = isset($_POST['_palette_1_color_3']) ? sanitize_text_field($_POST['_palette_1_color_3']) : '';
  update_post_meta( $id, '_palette_1_color_3', $custom_color );

  // Save custom color field - Paleta 2
  $custom_color = isset($_POST['_palette_2_color_1']) ? sanitize_text_field($_POST['_palette_2_color_1']) : '';
  update_post_meta( $id, '_palette_2_color_1', $custom_color );
  $custom_color = isset($_POST['_palette_2_color_2']) ? sanitize_text_field($_POST['_palette_2_color_2']) : '';
  update_post_meta( $id, '_palette_2_color_2', $custom_color );
  $custom_color = isset($_POST['_palette_2_color_3']) ? sanitize_text_field($_POST['_palette_2_color_3']) : '';
  update_post_meta( $id, '_palette_2_color_3', $custom_color );

  // Save custom color field - Paleta 3
  $custom_color = isset($_POST['_palette_3_color_1']) ? sanitize_text_field($_POST['_palette_3_color_1']) : '';
  update_post_meta( $id, '_palette_3_color_1', $custom_color );
  $custom_color = isset($_POST['_palette_3_color_2']) ? sanitize_text_field($_POST['_palette_3_color_2']) : '';
  update_post_meta( $id, '_palette_3_color_2', $custom_color );
  $custom_color = isset($_POST['_palette_3_color_3']) ? sanitize_text_field($_POST['_palette_3_color_3']) : '';
  update_post_meta( $id, '_palette_3_color_3', $custom_color );

  // Save checkboxes
  update_post_meta( $id, '_tuna_card_size_pp_checkbox', sanitize_text_field($_POST['_tuna_card_size_pp_checkbox']));
  update_post_meta( $id, '_tuna_card_size_p_checkbox', sanitize_text_field($_POST['_tuna_card_size_p_checkbox'] ));
  update_post_meta( $id, '_tuna_card_size_m_checkbox', sanitize_text_field($_POST['_tuna_card_size_m_checkbox'] ));
  update_post_meta( $id, '_tuna_card_size_g_checkbox', sanitize_text_field($_POST['_tuna_card_size_g_checkbox'] ));
}
//-------------------------------------------------------------

//--------------------- Function to show on the front ---------------------
add_action( 'woocommerce_before_add_to_cart_button', 'tuna_show_custom_card_size_radio' );

function tuna_show_custom_card_size_radio() {
  // Seletor da Paleta de cores da estampa
  echo '<div style="margin-bottom: 20px;">
	<label for="_tuna_selected_color_pallete">Escolha as cores da sua estampa:</label>
	<select type="text" id="_tuna_selected_color_pallete" name="_tuna_selected_color_pallete" value="">
  <option value="1">Paleta 1</option>
  <option value="2">Paleta 2</option>
  <option value="3">Paleta 3</option>
  </select>
    </div>';

// Radio buttons dos tamanhos
  global $product;
  $showOption1 = $product->get_meta( '_tuna_card_size_pp_checkbox' );
  $showOption2 = $product->get_meta( '_tuna_card_size_p_checkbox' );
  $showOption3 = $product->get_meta( '_tuna_card_size_m_checkbox' );
  $showOption4 = $product->get_meta( '_tuna_card_size_g_checkbox' );

  if ($showOption1 == 'yes' or $showOption2 == 'yes' or $showOption3 == 'yes' or $showOption4 == 'yes') {
	echo '<span>Escolha o tamanho do seu cartão:</span>';
  }

  if ($showOption1 == 'yes') {
    echo  
    '<div>
      <input type="radio" 
             id="_tuna_card_size_pp_checkbox" 
             name="_tuna_card_size_checkbox" 
             value="Tamanho PP">
      <label for="_tuna_card_size_pp_checkbox">
        <strong style="padding-left: 5px">Tamanho PP</strong>
      </label>
    </div>';
  }

  if ($showOption2 == 'yes') {
    echo  
    '<div>
      <input type="radio" 
             id="_tuna_card_size_p_checkbox" 
             name="_tuna_card_size_checkbox" 
             value="Tamanho P">
      <label for="_tuna_card_size_p_checkbox">
        <strong style="padding-left: 5px">Tamanho P</strong>
      </label>
    </div>';
  }

  if ($showOption3 == 'yes') {
    echo  
    '<div>
      <input type="radio" 
             id="_tuna_card_size_m_checkbox" 
             name="_tuna_card_size_checkbox" 
             value="Tamanho M">
      <label for="_tuna_card_size_m_checkbox">
        <strong style="padding-left: 5px">Tamanho M</strong>
      </label>
    </div>';
  }

  if ($showOption4 == 'yes') {
    echo  
    '<div>
      <input type="radio" 
             id="_tuna_card_size_g_checkbox" 
             name="_tuna_card_size_checkbox" 
             value="Tamanho G">
      <label for="_tuna_card_size_g_checkbox">
        <strong style="padding-left: 5px">Tamanho G</strong>
      </label>
    </div>';
  }
  // Cores dos envelopes
  echo '<div style="margin-top: 20px;">
	<span>Escolha a cor do seu envelope:</span>
    </div>';
  //Seu nome aqui input text field
  printf(
    '<div style="margin-bottom: 30px; margin-top: 20px;">
	<label for="_tuna_seu_nome_aqui_text_input">Seu nome aqui:</label>
	<input type="text" id="_tuna_seu_nome_aqui_text_input" name="_tuna_seu_nome_aqui_text_input" value="">
    </div>'
	);
}
//-------------------------------------------------------------

//--------------------- Function to validate before add to cart ---------------------
function tuna_validate_before_cart( $passed, $product_id, $quantity, $variation_id = null, $variations = null  ) {
    $product = wc_get_product( $product_id );
    if ( $passed && $product->is_type('custom_card') ) {
      // Field is empty
      if( empty( sanitize_text_field($_POST['_tuna_card_size_checkbox'] )) || empty( sanitize_text_field($_POST['_tuna_seu_nome_aqui_text_input'] )) ) {
          wc_add_notice( __( 'Por favor, selecione um tamanho de cartão e informe um nome', 'woocommerce' ), 'error' );
          $passed = false;
      }
    }
    return $passed;
       }
       add_filter( 'woocommerce_add_to_cart_validation', 'tuna_validate_before_cart', 10, 3 );
//-------------------------------------------------------------

//--------------------- Show button Add to cart ---------------------
if (! function_exists( 'woocommerce_custom_card_add_to_cart' ) ) {

    /**
    * Output the simple product add to cart area.
    *
    * @subpackage Product
    */
  
    function tuna_custom_card_add_to_cart() {
      wc_get_template( 'single-product/add-to-cart/simple.php' );
    }
  
    add_action('woocommerce_custom_card_add_to_cart',  'tuna_custom_card_add_to_cart');
  }
//-------------------------------------------------------------

  //--------------------- Functions to add input name and sizes to cart ---------------------
function tuna_add_custom_size_data( $cart_item_data, $product_id, $variation_id, $quantity ) {
	if( sanitize_text_field($_POST['_tuna_card_size_checkbox'] == 'Tamanho G' )) {
	// Add the item data
	$cart_item_data['_tuna_card_size_checkbox'] = 'Tamanho G';
	} elseif (sanitize_text_field($_POST['_tuna_card_size_checkbox'] == 'Tamanho P')) {
    $cart_item_data['_tuna_card_size_checkbox'] = 'Tamanho P';
  } elseif (sanitize_text_field($_POST['_tuna_card_size_checkbox'] == 'Tamanho M')) {
    $cart_item_data['_tuna_card_size_checkbox'] = 'Tamanho M';
  } elseif (sanitize_text_field($_POST['_tuna_card_size_checkbox'] == 'Tamanho PP')) {
    $cart_item_data['_tuna_card_size_checkbox'] = 'Tamanho PP';
  }
	return $cart_item_data;
   }
   add_filter( 'woocommerce_add_cart_item_data', 'tuna_add_custom_size_data', 10, 4 );

   function tuna_add_custom_name_input_data( $cart_item_data, $product_id, $variation_id, $quantity ) {
	if( ! empty( sanitize_text_field($_POST['_tuna_seu_nome_aqui_text_input'] )) ) {
	// Add the item data
	$cart_item_data['_tuna_seu_nome_aqui_text_input'] = sanitize_text_field($_POST['_tuna_seu_nome_aqui_text_input']);
	}
	return $cart_item_data;
   }
   add_filter( 'woocommerce_add_cart_item_data', 'tuna_add_custom_name_input_data', 10, 4 );
//-------------------------------------------------------------

//--------------------- Function to display the custom input value in the cart ---------------------
function tuna_cart_checkbox_name( $name, $cart_item, $cart_item_key ) {
	if( isset( $cart_item['_tuna_card_size_checkbox'] ) ) {
	$name .= sprintf(
	'<p style="margin-top: 10px;">%s</p>',
	esc_html( $cart_item['_tuna_card_size_checkbox'] )
	);
	}
	return $name;
   }
   add_filter( 'woocommerce_cart_item_name', 'tuna_cart_checkbox_name', 10, 3 );

   function tuna_cart_custom_name_input( $name, $cart_item, $cart_item_key ) {
	if( isset( $cart_item['_tuna_seu_nome_aqui_text_input'] ) ) {
	$name .= sprintf(
	'<p>%s</p>',
	esc_html( $cart_item['_tuna_seu_nome_aqui_text_input'] )
	);
	}
	return $name;
   }
   add_filter( 'woocommerce_cart_item_name', 'tuna_cart_custom_name_input', 10, 3 );
//-------------------------------------------------------------

//--------------------- Function to display the custom input value in the cart ---------------------
function tuna_add_custom_data_to_order( $item, $cart_item_key, $values, $order ) {
    foreach( $item as $cart_item_key=>$values ) {
    if( isset( $values['_tuna_seu_nome_aqui_text_input'] )) {
    $item->add_meta_data( __( 'Nome', '_tuna_seu_nome_aqui_text_input' ), $values['_tuna_seu_nome_aqui_text_input'], true );
    }
    if (isset( $values['_tuna_card_size_checkbox'] ) ) {
        $item->add_meta_data( __( 'Tamanho', '_tuna_card_size_checkbox' ), $values['_tuna_card_size_checkbox'], true );
    }
    }
   }
   add_action( 'woocommerce_checkout_create_order_line_item', 'tuna_add_custom_data_to_order', 10, 4 );
//-------------------------------------------------------------