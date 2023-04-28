<?php
/**
 * Functions.php
 *
 * @package  Theme_Customisations
 * @author   WooThemes
 * @since    1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
//---------------------------------------------------------------- Snippets bellow

 //-------------------- Custom Checkbox - Card size

 // Function to create data

add_action( 'woocommerce_product_options_general_product_data', 'cfwc_custom_checkbox' );
 
function cfwc_custom_checkbox(  ) {
  $terms = array('20', '15');

  if ( has_term( $terms, 'product_cat' )) {
    echo '<div class="options_group">'; 
    echo '<span style="padding-left: 10px">Tamanhos disponíveis: </span>';
    woocommerce_wp_checkbox( array(
    'id'          => '_cfwc_card_size_pp_checkbox',
    'value'       => get_post_meta( get_the_ID(), '_cfwc_card_size_pp_checkbox' )[0],
    'description' => __( 'Tamanho PP', 'woocommerce' ),
    ) );
      woocommerce_wp_checkbox( array(
        'id'          => '_cfwc_card_size_p_checkbox',
        'value'       => get_post_meta( get_the_ID(), '_cfwc_card_size_p_checkbox' )[0],
        'description' => __( 'Tamanho P', 'woocommerce' ),
      ) );
    woocommerce_wp_checkbox( array(
      'id'          => '_cfwc_card_size_m_checkbox',
      'value'       => get_post_meta( get_the_ID(), '_cfwc_card_size_m_checkbox' )[0],
      'description' => __( 'Tamanho M', 'woocommerce' ),
      ) );
      woocommerce_wp_checkbox( array(
      'id'          => '_cfwc_card_size_g_checkbox',
      'value'       => get_post_meta( get_the_ID(), '_cfwc_card_size_g_checkbox' )[0],
      'description' => __( 'Tamanho G', 'woocommerce' ),
      ) );
     echo '</div>';
  } 
  
}

//Function to save data
add_action( 'woocommerce_process_product_meta', 'cfwc_save_custom_checkbox', 10, 2 );

function cfwc_save_custom_checkbox( $id, $post ){
	update_post_meta( $id, '_cfwc_card_size_pp_checkbox', $_POST['_cfwc_card_size_pp_checkbox'] );
  update_post_meta( $id, '_cfwc_card_size_p_checkbox', $_POST['_cfwc_card_size_p_checkbox'] );
  update_post_meta( $id, '_cfwc_card_size_m_checkbox', $_POST['_cfwc_card_size_m_checkbox'] );
  update_post_meta( $id, '_cfwc_card_size_g_checkbox', $_POST['_cfwc_card_size_g_checkbox'] );
}

//Function to show on the front
add_action( 'woocommerce_before_add_to_cart_button', 'cfwc_show_custom_checkbox' );

function cfwc_show_custom_checkbox() {

  global $product;
  $showOption1 = $product->get_meta( '_cfwc_card_size_pp_checkbox' );
  $showOption2 = $product->get_meta( '_cfwc_card_size_p_checkbox' );
  $showOption3 = $product->get_meta( '_cfwc_card_size_m_checkbox' );
  $showOption4 = $product->get_meta( '_cfwc_card_size_g_checkbox' );

  if ($showOption1 == 'yes' or $showOption2 == 'yes' or $showOption3 == 'yes' or $showOption4 == 'yes') {
	echo '<span>Escolha o tamanho do seu cartão:</span>';
  }

  if ($showOption1 == 'yes') {
    echo  
    '<div>
      <input type="radio" 
             id="_cfwc_card_size_pp_checkbox" 
             name="_cfwc_card_size_checkbox" 
             value="Tamanho PP">
      <label for="_cfwc_card_size_pp_checkbox">
        <strong style="padding-left: 5px">Tamanho PP</strong>
      </label>
    </div>';
  }

  if ($showOption2 == 'yes') {
    echo  
    '<div>
      <input type="radio" 
             id="_cfwc_card_size_p_checkbox" 
             name="_cfwc_card_size_checkbox" 
             value="Tamanho P">
      <label for="_cfwc_card_size_p_checkbox">
        <strong style="padding-left: 5px">Tamanho P</strong>
      </label>
    </div>';
  }

  if ($showOption3 == 'yes') {
    echo  
    '<div>
      <input type="radio" 
             id="_cfwc_card_size_m_checkbox" 
             name="_cfwc_card_size_checkbox" 
             value="Tamanho M">
      <label for="_cfwc_card_size_m_checkbox">
        <strong style="padding-left: 5px">Tamanho M</strong>
      </label>
    </div>';
  }

  if ($showOption4 == 'yes') {
    echo  
    '<div>
      <input type="radio" 
             id="_cfwc_card_size_g_checkbox" 
             name="_cfwc_card_size_checkbox" 
             value="Tamanho G">
      <label for="_cfwc_card_size_g_checkbox">
        <strong style="padding-left: 5px">Tamanho G</strong>
      </label>
    </div>';
  }
  echo '<br>';
}
   
// Function to validate before add to cart by category
function cfwc_validate_custom_checkbox( $passed, $product_id, $quantity, $variation_id = null, $variations = null  ) {
// Set (multiple) categories
$categories = array ( '20', '15' );
// If passed & has_term
if ( $passed && has_term( $categories, 'product_cat', $product_id ) ) {
  // Field is empty
  if( empty( $_POST['_cfwc_card_size_checkbox'] ) ) {
      wc_add_notice( __( 'Por favor, selecione um tamanho de cartão', 'woocommerce' ), 'error' );
      $passed = false;
  }
}
return $passed;
   }
   add_filter( 'woocommerce_add_to_cart_validation', 'cfwc_validate_custom_checkbox', 10, 3 );

   
//Functions to add info to cart
function cfwc_add_custom_checkbox_data( $cart_item_data, $product_id, $variation_id, $quantity ) {
	if( $_POST['_cfwc_card_size_checkbox'] == 'Tamanho G' ) {
	// Add the item data
	$cart_item_data['_cfwc_card_size_checkbox'] = 'Tamanho G';
	} elseif ($_POST['_cfwc_card_size_checkbox'] == 'Tamanho P') {
    $cart_item_data['_cfwc_card_size_checkbox'] = 'Tamanho P';
  } elseif ($_POST['_cfwc_card_size_checkbox'] == 'Tamanho M') {
    $cart_item_data['_cfwc_card_size_checkbox'] = 'Tamanho M';
  } elseif ($_POST['_cfwc_card_size_checkbox'] == 'Tamanho PP') {
    $cart_item_data['_cfwc_card_size_checkbox'] = 'Tamanho PP';
  }
	return $cart_item_data;
   }
   add_filter( 'woocommerce_add_cart_item_data', 'cfwc_add_custom_checkbox_data', 10, 4 );

// Display the custom field value in the cart
function cfwc_cart_checkbox_name( $name, $cart_item, $cart_item_key ) {
	if( isset( $cart_item['_cfwc_card_size_checkbox'] ) ) {
	$name .= sprintf(
	'<p style="margin-top: 10px;">%s</p>',
	esc_html( $cart_item['_cfwc_card_size_checkbox'] )
	);
	}
	return $name;
   }
   add_filter( 'woocommerce_cart_item_name', 'cfwc_cart_checkbox_name', 10, 3 );

 //-------------------- End Custom Checkbox - Card size

 /*
//-------------------- Custom Checkbox - Envelope

 // Function to create data

add_action( 'woocommerce_product_options_general_product_data', 'cfwc_custom_checkbox_envelope_color' );
 
function cfwc_custom_checkbox_envelope_color(  ) {
  $terms = array('20', '15');

  if ( has_term( $terms, 'product_cat' )) {
    echo '<div class="options_group">'; 
    echo '<span style="padding-left: 10px">Cores disponíveis: </span>';
    woocommerce_wp_checkbox( array(
    'id'          => '_cfwc_envelope_white_checkbox',
    'value'       => get_post_meta( get_the_ID(), '_cfwc_card_size_pp_checkbox' )[0],
    'description' => __( 'Tamanho PP', 'woocommerce' ),
    ) );
      woocommerce_wp_checkbox( array(
        'id'          => '_cfwc_card_size_p_checkbox',
        'value'       => get_post_meta( get_the_ID(), '_cfwc_card_size_p_checkbox' )[0],
        'description' => __( 'Tamanho P', 'woocommerce' ),
      ) );
    woocommerce_wp_checkbox( array(
      'id'          => '_cfwc_card_size_m_checkbox',
      'value'       => get_post_meta( get_the_ID(), '_cfwc_card_size_m_checkbox' )[0],
      'description' => __( 'Tamanho M', 'woocommerce' ),
      ) );
      woocommerce_wp_checkbox( array(
      'id'          => '_cfwc_card_size_g_checkbox',
      'value'       => get_post_meta( get_the_ID(), '_cfwc_card_size_g_checkbox' )[0],
      'description' => __( 'Tamanho G', 'woocommerce' ),
      ) );
     echo '</div>';
  } 
  
}

//Function to save data
add_action( 'woocommerce_process_product_meta', 'cfwc_save_custom_checkbox', 10, 2 );

function cfwc_save_custom_checkbox( $id, $post ){
	update_post_meta( $id, '_cfwc_card_size_pp_checkbox', $_POST['_cfwc_card_size_pp_checkbox'] );
  update_post_meta( $id, '_cfwc_card_size_p_checkbox', $_POST['_cfwc_card_size_p_checkbox'] );
  update_post_meta( $id, '_cfwc_card_size_m_checkbox', $_POST['_cfwc_card_size_m_checkbox'] );
  update_post_meta( $id, '_cfwc_card_size_g_checkbox', $_POST['_cfwc_card_size_g_checkbox'] );
}

//Function to show on the front
add_action( 'woocommerce_before_add_to_cart_button', 'cfwc_show_custom_checkbox' );

function cfwc_show_custom_checkbox() {

  global $product;
  $showOption1 = $product->get_meta( '_cfwc_card_size_pp_checkbox' );
  $showOption2 = $product->get_meta( '_cfwc_card_size_p_checkbox' );
  $showOption3 = $product->get_meta( '_cfwc_card_size_m_checkbox' );
  $showOption4 = $product->get_meta( '_cfwc_card_size_g_checkbox' );

  if ($showOption1 == 'yes' or $showOption2 == 'yes' or $showOption3 == 'yes' or $showOption4 == 'yes') {
	echo '<span>Escolha o tamanho do seu cartão:</span>';
  }

  if ($showOption1 == 'yes') {
    echo  
    '<div>
      <input type="radio" 
             id="_cfwc_card_size_pp_checkbox" 
             name="_cfwc_card_size_checkbox" 
             value="Tamanho PP">
      <label for="_cfwc_card_size_pp_checkbox">
        <strong style="padding-left: 5px">Tamanho PP</strong>
      </label>
    </div>';
  }

  if ($showOption2 == 'yes') {
    echo  
    '<div>
      <input type="radio" 
             id="_cfwc_card_size_p_checkbox" 
             name="_cfwc_card_size_checkbox" 
             value="Tamanho P">
      <label for="_cfwc_card_size_p_checkbox">
        <strong style="padding-left: 5px">Tamanho P</strong>
      </label>
    </div>';
  }

  if ($showOption3 == 'yes') {
    echo  
    '<div>
      <input type="radio" 
             id="_cfwc_card_size_m_checkbox" 
             name="_cfwc_card_size_checkbox" 
             value="Tamanho M">
      <label for="_cfwc_card_size_m_checkbox">
        <strong style="padding-left: 5px">Tamanho M</strong>
      </label>
    </div>';
  }

  if ($showOption4 == 'yes') {
    echo  
    '<div>
      <input type="radio" 
             id="_cfwc_card_size_g_checkbox" 
             name="_cfwc_card_size_checkbox" 
             value="Tamanho G">
      <label for="_cfwc_card_size_g_checkbox">
        <strong style="padding-left: 5px">Tamanho G</strong>
      </label>
    </div>';
  }
  echo '<br>';
}
   
// Function to validate before add to cart by category
function cfwc_validate_custom_checkbox( $passed, $product_id, $quantity, $variation_id = null, $variations = null  ) {
// Set (multiple) categories
$categories = array ( '20', '15' );
// If passed & has_term
if ( $passed && has_term( $categories, 'product_cat', $product_id ) ) {
  // Field is empty
  if( empty( $_POST['_cfwc_card_size_checkbox'] ) ) {
      wc_add_notice( __( 'Por favor, selecione um tamanho de cartão', 'woocommerce' ), 'error' );
      $passed = false;
  }
}
return $passed;
   }
   add_filter( 'woocommerce_add_to_cart_validation', 'cfwc_validate_custom_checkbox', 10, 3 );

   
//Functions to add info to cart
function cfwc_add_custom_checkbox_data( $cart_item_data, $product_id, $variation_id, $quantity ) {
	if( $_POST['_cfwc_card_size_checkbox'] == 'Tamanho G' ) {
	// Add the item data
	$cart_item_data['_cfwc_card_size_checkbox'] = 'Tamanho G';
	} elseif ($_POST['_cfwc_card_size_checkbox'] == 'Tamanho P') {
    $cart_item_data['_cfwc_card_size_checkbox'] = 'Tamanho P';
  } elseif ($_POST['_cfwc_card_size_checkbox'] == 'Tamanho M') {
    $cart_item_data['_cfwc_card_size_checkbox'] = 'Tamanho M';
  } elseif ($_POST['_cfwc_card_size_checkbox'] == 'Tamanho PP') {
    $cart_item_data['_cfwc_card_size_checkbox'] = 'Tamanho PP';
  }
	return $cart_item_data;
   }
   add_filter( 'woocommerce_add_cart_item_data', 'cfwc_add_custom_checkbox_data', 10, 4 );

// Display the custom field value in the cart
function cfwc_cart_checkbox_name( $name, $cart_item, $cart_item_key ) {
	if( isset( $cart_item['_cfwc_card_size_checkbox'] ) ) {
	$name .= sprintf(
	'<p style="margin-top: 10px;">%s</p>',
	esc_html( $cart_item['_cfwc_card_size_checkbox'] )
	);
	}
	return $name;
   }
   add_filter( 'woocommerce_cart_item_name', 'cfwc_cart_checkbox_name', 10, 3 );

 //-------------------- End Custom Checkbox - Envelope

*/
 
 //-------------------- Product Custom Field -- Name to print

// Function to display
function cfwc_create_custom_field() {
  $terms = array('20');

  if ( has_term( $terms, 'product_cat' )) {
    echo '<div class="options_group">'; 
    woocommerce_wp_checkbox( array(
      'id'          => '_cfwc_seu_nome_aqui_checkbox',
      'value'       => get_post_meta( get_the_ID(), '_cfwc_seu_nome_aqui_checkbox' )[0],
      'label' => __( 'Marque para exibir o campo "Seu nome aqui"', 'woocommerce' ),
      ) );
     echo '</div>';
  }
}

   add_action( 'woocommerce_product_options_general_product_data', 'cfwc_create_custom_field' );

//Function to save data
add_action( 'woocommerce_process_product_meta', 'cfwc_save_checkbox_seu_nome_aqui', 10, 2 );

function cfwc_save_checkbox_seu_nome_aqui( $id, $post ){
  update_post_meta( $id, '_cfwc_seu_nome_aqui_checkbox', $_POST['_cfwc_seu_nome_aqui_checkbox'] );
}

//Function to show on the front
add_action( 'woocommerce_before_add_to_cart_button', 'cfwc_show_checkbox_seu_nome_aqui' );

function cfwc_show_checkbox_seu_nome_aqui() {

  global $product;
  $showOption1 = $product->get_meta( '_cfwc_seu_nome_aqui_checkbox' );

  if ($showOption1 == 'yes') {
    printf(
    '<div style="margin-bottom: 20px;">
	<label for="_cfwc_seu_nome_aqui_text_input">Seu nome aqui:</label>
	<input type="text" id="_cfwc_seu_nome_aqui_text_input" name="_cfwc_seu_nome_aqui_text_input" value="">
    </div>',
	esc_html( $title )
	);
  }
}

// Function to validate before add to cart by category
function cfwc_validate_custom_text_input( $passed, $product_id, $quantity, $variation_id = null, $variations = null  ) {
  // Set (multiple) categories
  $categories = array ( '20' );
  // If passed & has_term
  if ( $passed && has_term( $categories, 'product_cat', $product_id ) ) {
    // Field is empty
    if( empty( $_POST['_cfwc_seu_nome_aqui_text_input'] ) ) {
        wc_add_notice( __( 'Por favor, informe seu nome', 'woocommerce' ), 'error' );
        $passed = false;
    }
  }
  return $passed;
     }
     add_filter( 'woocommerce_add_to_cart_validation', 'cfwc_validate_custom_text_input', 10, 3 );

// Add the text field as item data to the cart object
function cfwc_add_custom_text_input_data( $cart_item_data, $product_id, $variation_id, $quantity ) {
	if( ! empty( $_POST['_cfwc_seu_nome_aqui_text_input'] ) ) {
	// Add the item data
	$cart_item_data['title_field'] = $_POST['_cfwc_seu_nome_aqui_text_input'];
	}
	return $cart_item_data;
   }
   add_filter( 'woocommerce_add_cart_item_data', 'cfwc_add_custom_text_input_data', 10, 4 );

// Display the custom field value in the cart
function cfwc_cart_text_input_name( $name, $cart_item, $cart_item_key ) {
	if( isset( $cart_item['title_field'] ) ) {
	$name .= sprintf(
	'<p>%s</p>',
	esc_html( $cart_item['title_field'] )
	);
	}
	return $name;
   }
   add_filter( 'woocommerce_cart_item_name', 'cfwc_cart_text_input_name', 10, 3 );

 //-------------------- End Product Custom Field -- Name to print