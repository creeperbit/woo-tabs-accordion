<?php

defined('ABSPATH') || exit;

if ( ! empty( $product_tabs ) ) : ?>
  <div id="woot2a-accordion-container" class="woot2a-accordion-container theme-two woocommerce-tabs wc-tabs-wrapper">
    <?php foreach ( $product_tabs as $key => $product_tab ) : ?>
      <<?php echo $title_tag; ?> class="accordion-title <?php echo esc_attr( $key ); ?>_tab">
        <?php echo apply_filters( 'woocommerce_product_' . $key . '_tab_title', esc_html( $product_tab['title'] ), $key ); ?>
      </<?php echo $title_tag; ?>>
      <div id="woot2a-tab-<?php echo esc_attr( $key ); ?>" class="woot2a-tab">
        <?php call_user_func( $product_tab['callback'], $key, $product_tab ); ?>
      </div>
    <?php endforeach; ?>

    <?php do_action( 'woocommerce_product_after_tabs' ); ?>
  </div>
<?php endif; ?>