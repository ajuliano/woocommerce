<?php
/**
 * Product attributes
 *
 * Used by list_attributes() in the products class
 */

global $woocommerce;

$alt = 1;
$attributes = $product->get_attributes();

if ( empty( $attributes ) && ( ! $product->enable_dimensions_display() || ( ! $product->has_dimensions() && ! $product->has_weight() ) ) ) return;
?>
<table class="shop_attributes">
			
	<?php if ( $product->enable_dimensions_display() ) : ?>	
		
		<?php if ( $product->has_weight() ) : $alt = $alt * -1; ?>
		
			<tr class="<?php if ( $alt == 1 ) echo 'alt'; ?>">
				<th><?php _e('Weight', 'woocommerce') ?></th>
				<td><?php echo $product->get_weight() . ' ' . get_option('woocommerce_weight_unit'); ?></td>
			</tr>
		
		<?php endif; ?>
		
		<?php if ($product->has_dimensions()) : $alt = $alt * -1; ?>
		
			<tr class="<?php if ( $alt == 1 ) echo 'alt'; ?>">
				<th><?php _e('Dimensions', 'woocommerce') ?></th>
				<td><?php echo $product->get_dimensions(); ?></td>
			</tr>		
		
		<?php endif; ?>
		
	<?php endif; ?>
			
	<?php foreach ($attributes as $attribute) : 
		
		if ( ! isset( $attribute['is_visible'] ) || ! $attribute['is_visible'] ) continue;
		if ( $attribute['is_taxonomy'] && ! taxonomy_exists( $attribute['name'] ) ) continue;
		
		$alt = $alt * -1; 
		?>
			
		<tr class="<?php if ( $alt == 1 ) echo 'alt'; ?>">
			<th><?php echo $woocommerce->attribute_label( $attribute['name'] ); ?></th>
			<td><?php
				if ( $attribute['is_taxonomy'] ) {

					echo implode( ', ', woocommerce_get_product_terms( $product->id, $attribute['name'], 'names' ) );
					
				} else {
				
					// Convert pipes to commas
					$value = explode( '|', $attribute['value'] );
					$value = implode( ', ', $value );
					echo wpautop( wptexturize( $value ) );
					
				}
			?></td>
		</tr>
				
	<?php endforeach; ?>
	
</table>