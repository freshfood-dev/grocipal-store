<?php 

/*-----------------------------------------------------------------------------------*/
/* Groci Title
/*-----------------------------------------------------------------------------------*/

function groci_title( $atts, $content = null ) {
    extract( shortcode_atts(array(       
        "title"       => '',
        "subtitle"    => '',
        "type"    	  => '',
        "textalign"   => 'text-center',
    ), $atts) );
	
		$output  = '';
			
			$output  .= '<div class="section-title '.esc_attr($textalign).' mb-5">';
			$output  .= '<h2>'.esc_html($title).'</h2>';
			$output  .= '<p>'.$subtitle.'</p>';
			$output  .= '</div>';
		
  		return $output;
}

add_shortcode('title', 'groci_title');


/*-----------------------------------------------------------------------------------*/
/*	Groci Slider
/*-----------------------------------------------------------------------------------*/

function groci_slider( $atts, $content = null ) {
    extract( shortcode_atts(array(       
        "name"     => '',
        "position"     => '',
        "values"          => '',
        "icon_ion"      => '',	
        "image_url"          => '',
        "uniqueid"          => '',
        "contentm"          => '',
    ), $atts) );

		$output  = '';
		$values = (array) vc_param_group_parse_atts($values);

		foreach($values as $v){
			if(isset($v['link'])){
			$link = ( '||' === $v['link'] ) ? '' : $v['link'];
			$link = vc_build_link( $v['link'] );
			$a_href = $link['url'];
			$a_title = $link['title'];
			$a_target = $link['target'];
			}
			
			$image_urls = wp_get_attachment_url( $v['image_url'], 'full' );

			$output  .= '<div class="item">';
			if(isset($v['link'])){
			$output  .= '<a href="'.esc_url($a_href).'" target="'.esc_attr($a_target).'" title="'.esc_attr($a_title).'">';
			}
			$output  .= '<img class="img-fluid" src="'.esc_url($image_urls).'" alt="slide">';
			if(isset($v['link'])){
			$output  .= '</a>';
			}
			$output  .= '</div>';
		}

	
  		return '<section class="carousel-slider-main text-center"><div class="owl-carousel owl-carousel-slider">'.$output.'</div></section>';
}

add_shortcode('slider', 'groci_slider');


/*-----------------------------------------------------------------------------------*/
/*	Groci Category Carousel
/*-----------------------------------------------------------------------------------*/

function groci_category_carousel( $atts, $content = null ) {
    extract( shortcode_atts(array(       
		'exclude'       => 'all'
    ), $atts) );

	$output  = '';

	if($exclude == 'all'){
		$terms = get_terms( array(
			'taxonomy' => 'product_cat',
			'hide_empty' => false,
			'parent'    => 0,
		) );
	} else {
		$str = $exclude;
    	$arr = explode(',', $str);

		$terms = get_terms( array(
			'taxonomy' => 'product_cat',
			'hide_empty' => false,
			'parent'    => 0,
			'exclude'   => $arr,
		) );
	}
		
	foreach ( $terms as $term ) {
	    $thumbnail_id = get_woocommerce_term_meta( $term->term_id, 'thumbnail_id', true );
	    $image = wp_get_attachment_url( $thumbnail_id );
		
		if($image){
		$output .= '<div class="item">';
		$output .= '<div class="category-item">';
		$output .= '<a href="'.esc_url(get_term_link( $term )).'">';
		$output .= '<img class="img-fluid" src="'.esc_url($image).'" alt="">';
		$output .= '<h6>'.$term->name.'</h6>';
		$output .= '<p>'.$term->count.' '.esc_html__('Items','groci').'</p>';
		$output .= '</a>';
		$output .= '</div>';
		$output .= '</div>';
		}
	}
	
  	return '<div class="top-category klb-product-cat"><div class="owl-carousel owl-carousel-category">'.$output.'</div></div>';
}

add_shortcode('category_carousel', 'groci_category_carousel');



/*-----------------------------------------------------------------------------------*/
/*	Froday Latest Products Carousel
/*-----------------------------------------------------------------------------------*/

function groci_latest_products_carousel($atts){
	extract(shortcode_atts(array(
        'build_query'     => '',
        'type'                  => '',
        'link'                  => '',
        'title'                 => '',
        'title_strong'          => '',
        'titlestrong_bg'          => '#007bff',
    ), $atts));
    
	global $post,$wp_query,$product,$woocommerce;
	
	$output = '';
	$outhead = '';
	$percentage = '';

	list($args) = vc_build_loop_query($build_query);
    if(is_front_page()){
	$args['paged'] = (get_query_var('page')) ? get_query_var('page') : 1;
    } else { 
	$args['paged'] = (get_query_var('paged')) ? get_query_var('paged') : 1;
    }
	$args['post_type'] = 'product';
	query_posts( $args );
	
	$link = ( '||' === $link ) ? '' : $link;
	$link = vc_build_link( $link );
	$a_href = $link['url'];
	$a_title = $link['title'];
	$a_target = $link['target'];
	
	$outhead .= '<div class="section-header">';
	$outhead .= '<h5 class="heading-design-h5">'.esc_html($title);
	if($title_strong){
	$outhead .= ' <span class="badge badge-primary" style="background-color: '.esc_attr($titlestrong_bg).'">'.esc_html($title_strong).'</span>';
	}
	if($a_title){
	$outhead .= '<a class="float-right text-secondary" href="'.esc_url($a_href).'" title="'.esc_attr($a_title).'" target="'.esc_attr($a_target).'">'.esc_html($a_title).'</a>';
	}
	$outhead .= '</h5>';
	$outhead .= '</div>';

	if( have_posts() ) : while ( have_posts() ) : the_post();
		$product = new WC_Product(get_the_ID());
		
		$id = get_the_ID();

		$att=get_post_thumbnail_id();
		$image_src = wp_get_attachment_image_src( $att, 'full' );
		$image_src = $image_src[0];
	    $cart_url = wc_get_cart_url();
		$price = $product->get_price_html();
		$weight = $product->get_weight();
		$stock_status = $product->get_stock_status();
 		$stock_text = $product->get_availability();

		$rating = wc_get_rating_html($product->get_average_rating());

		if( $product->is_on_sale() ) {
			$percentage .= '<span class="badge badge-success">';			
			$percentage .= ceil(100 - ($product->get_sale_price() / $product->get_regular_price()) * 100);			
			$percentage .= '%</span>';			
		}
		
			$output .= '<div class="item">';
			$output .= '<div class="product">';

			$output .= '<div class="product-header">';
			if($product->get_sale_price()){
			$output .= $percentage;
			}

			$output .= '<a href="'.get_permalink().'"><img class="img-fluid" src="'.esc_url($image_src).'" alt="'.get_the_title().'"></a>';
			if($stock_status == 'instock'){
			$output .= '<span class="veg text-success mdi mdi-circle"></span>';
			} else {
			$output .= '<span class="non-veg text-danger mdi mdi-circle"></span>';
			}
			$output .= '</div>';
			$output .= '<div class="product-body">';
			$output .= '<a href="'.get_permalink().'"><h5>'.get_the_title().'</h5></a>';
			if($stock_status == 'instock'){
			$output .= '<h6><strong><span class="mdi mdi-approval text-success"></span> '.$stock_text['availability'].'</strong>';
			} else {
			$output .= '<h6><strong><span class="mdi mdi-approval"></span> '.$stock_text['availability'].'</strong>';
			}
			if($weight){
			$output .= ' - '.$weight.' '.get_option('woocommerce_weight_unit');
			}
			$output .= '</h6></div>';
			$output .= '<div class="product-footer">';
			$output .= '<p class="offer-price mb-0">'.$price.'</p>';
			$output .= groci_sanitize_data(groci_add_to_cart_button());
			$output .= '</div>';

			$output .= '</div>';
			$output .= '</div>';
		
	   endwhile;
	   wp_reset_query();
	endif;
	

	return '<section class="product-items-slider section-padding">'.$outhead.'<div class="owl-carousel owl-carousel-featured">'.$output.'</div></section>';

}
add_shortcode('latest_products_carousel', 'groci_latest_products_carousel');


/*-----------------------------------------------------------------------------------*/
/*	Groci Icon Box
/*-----------------------------------------------------------------------------------*/

function groci_icon_box( $atts, $content = null ) {
    extract( shortcode_atts(array(       
		"title"        		  => '',
        "contentm"            => '',
        "icon_fontawesome"    => '',	
        "icon_openiconic"     => '',	
        "icon_typicons"       => '',	
        "icon_entypo"    	  => '',	
        "icon_linecons"       => '',	
        "icon_monosocial"     => '',	
        "icon_materialdesign" => '',	
        "type"    			  => '',
        "type_box"    			  => '',
    ), $atts) );
	
		vc_icon_element_fonts_enqueue( $type ); 
		
		$output         = '';
		if($type_box == 'type_2'){
		$output .= '<div class="klbiconbox">';	
		$output .= '<div class="mt-4 mb-4"><i class="text-success mdi '.esc_attr($icon_fontawesome) . esc_attr($icon_openiconic) . esc_attr($icon_typicons) . esc_attr($icon_entypo) . esc_attr($icon_linecons) . esc_attr($icon_monosocial) . esc_attr($icon_materialdesign) .' mdi-48px"></i></div>';
		$output .= '<h5 class="mb-3 text-secondary">'.esc_html($title).'</h5>';
		$output .= '<p>'.$contentm.'</p>';
		$output .= '</div>';
		} else {
		$output .= '<div class="feature-box">';
		$output .= '<i class="mdi '.esc_attr($icon_fontawesome) . esc_attr($icon_openiconic) . esc_attr($icon_typicons) . esc_attr($icon_entypo) . esc_attr($icon_linecons) . esc_attr($icon_monosocial) . esc_attr($icon_materialdesign) .'"></i>';
		$output .= '<h6>'.esc_html($title).'</h6>';
		$output .= '<p>'.$contentm.'</p>';
		$output .= '</div>';
		}

  		return $output;
}

add_shortcode('icon_box', 'groci_icon_box');

/*-----------------------------------------------------------------------------------*/
/*	Groci Team Box
/*-----------------------------------------------------------------------------------*/

function groci_team_box($atts){
	extract(shortcode_atts(array(
        "image_url"   => '',
        "name"     	  => '',
        "contentm"    => '',
        "position"    => '',
    ), $atts));
    
		$out = '';
		
		$image_urls = wp_get_attachment_url( $image_url, 'full' );

		$out .= '<div class="team-card text-center">';
		$out .= '<img class="img-fluid mb-4" src="'.esc_url($image_urls).'" alt="'.esc_html($name).'">';
		$out .= '<p class="mb-4">'.esc_html($contentm).'</p>';
		$out .= '<h6 class="mb-0 text-success">'.esc_html($name).'</h6>';
		$out .= '<small>'.esc_html($position).'</small>';
		$out .= '</div>';
		
	return  $out;

}
add_shortcode('team_box', 'groci_team_box');

/*-----------------------------------------------------------------------------------*/
/*  groci Map Container
/*-----------------------------------------------------------------------------------*/

function groci_map_container( $atts, $content = null ) {	
$css = '';
 	extract(shortcode_atts(array(
       	'latitude'      => '51.5209564',
       	'longitude' => '0.157134',
        'zoom'      => '10',
        'css' => '',
        'height' => '450',	
        'mapimage' => '',	
    ), $atts)); 
	$image_urls = wp_get_attachment_url( $mapimage, 'full' );	
    wp_enqueue_script('googlemap');
?>

<script type="text/javascript">
jQuery(document).ready(function() {
function initialize() {
    var latlng = new google.maps.LatLng(<?php echo esc_attr($latitude); ?>,<?php echo esc_attr($longitude); ?>);
    var myOptions = {
        zoom: <?php echo esc_attr($zoom); ?>,
        center: latlng,
        scrollwheel: false,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };

    var map = new google.maps.Map(document.getElementById("map"),
            myOptions);

  var marker = new google.maps.Marker({
    position: {lat: <?php echo esc_attr($latitude); ?>, lng: <?php echo esc_attr($longitude); ?>},
    map: map
  });
}
google.maps.event.addDomListener(window, "load", initialize);
});
</script>

<?php 
            $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), $atts );

	        $output = '';
			
            $output .= '<div class="card">
                     <div class="card-body"><div class="contact-map '.esc_attr( $css_class ).'">
                <div id="map" class="google-map" style="height:'.esc_attr($height).'px;"></div>
            </div></div></div>';

   return $output;

}

add_shortcode('map_container', 'groci_map_container');


/*-----------------------------------------------------------------------------------*/
/*	Groci Contact Details
/*-----------------------------------------------------------------------------------*/

function groci_contact_details( $atts, $content = null ) {
    extract( shortcode_atts(array(       
        "values"          => '',
        "social"          => '',
        "social_title"          => '',
        "link"          => '',
        "title"          => '',
        "contentm"          => '',
        "widget_title"          => '',
        "icon_materialdesign"          => '',
        "icon_materialdesign_social"          => '',
    ), $atts) );

		$output  = '';
		$values = (array) vc_param_group_parse_atts($values);
		$social = (array) vc_param_group_parse_atts($social);

		$output  .= '<h3 class="mt-1 mb-5">'.esc_html($widget_title).'</h3>';
		foreach($values as $v){
			$output  .= '<h6 class="text-dark"><i class="mdi '.esc_attr($v['icon_materialdesign']).'"></i> '.esc_html($v['title']).'</h6>';
			$output  .= '<p>'.$v['contentm'].'</p>';
		}

		$output  .= '<div class="footer-social"><span>'.esc_html($social_title).'</span>';
		foreach($social as $s){
			if(isset($s['link'])){
			$link = ( '||' === $s['link'] ) ? '' : $s['link'];
			$link = vc_build_link( $s['link'] );
			$a_href = $link['url'];
			$a_title = $link['title'];
			$a_target = $link['target'];
			
			$output  .= '<a href="'.esc_url($a_href).'" target="'.esc_attr($a_target).'" title="'.esc_attr($a_title).'"><i class="mdi '.esc_attr($s['icon_materialdesign_social']).'"></i></a> ';
			}
		}
		$output  .= '</div>';
	
  		return '<div class="klb-contact">'.$output.'</div>';
}

add_shortcode('contact_details', 'groci_contact_details');

/*-----------------------------------------------------------------------------------*/
/*	Groci Br
/*-----------------------------------------------------------------------------------*/

function groci_br() {
   return '<br />';
}

add_shortcode('br', 'groci_br');