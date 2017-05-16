<?php
/**
 * Plugin Name: Portfolio
 * Plugin URI:        http://codebanyan.com/product/mim-portfolio
 * Description:       Portfolio Plugin for WordPress
 * Version:           1.0.0
 * Author:            Al Imran Akash
 * Author URI:        http://im.medhabi.com
 * Text Domain:       portfolio
 * Domain Path:       /languages
 */
/**
* 
*/
if ( !class_exists( MIM_PORTFOLIO ) ) :

	class MIM_PORTFOLIO {
		
		function __construct()
		{
			self::define();
			self::inc();
			self::hooks();
		}

		public function define() {
			define( 'MIM_PORTFOLIO', __FILE__ );
		}

		public function inc() {
			require_once dirname( MIM_PORTFOLIO ) . '/inc/cpt.php';
			require_once dirname( MIM_PORTFOLIO ) . '/vendor/admin/mim-portfolio-settings.php';
		}

		public function hooks() {
			add_action( 'after_setup_theme', array( $this, 'setup' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ), 99 );
			add_shortcode( 'portfolio', array( $this, 'mim_portfolio' ) );
		}

		public function setup() {
			load_theme_textdomain( 'portfolio', get_template_directory() . '/languages' );
		}

		public function enqueue_scripts() {
			wp_enqueue_style( 'awesome-style', plugins_url( '/assets/css/font-awesome.min.css', MIM_PORTFOLIO ) );
			wp_enqueue_style( 'magnific-style', plugins_url( '/assets/css/magnific-popup.css', MIM_PORTFOLIO ) );
			wp_enqueue_style( 'mim-style', plugins_url( '/assets/css/mim-portfolio.css', MIM_PORTFOLIO ) );

			$background = mdc_get_option( 'background', 'mim_portfolio', 'transparent' );
			$color = mdc_get_option( 'color', 'mim_portfolio', 'transparent' );
			$btnbg = mdc_get_option( 'btnbg', 'mim_portfolio', 'transparent' );
			$activebtn = mdc_get_option( 'activebtn', 'mim_portfolio', 'transparent' );
			$fontsize = mdc_get_option( 'fontsize', 'mim_portfolio', '30' ) . 'px';
			$btnfontsize = mdc_get_option( 'btnfontsize', 'mim_portfolio', '16' ) . 'px';
			$btntransform = mdc_get_option( 'btntransform', 'mim_portfolio' );
			$textposition = mdc_get_option( 'textposition', 'mim_portfolio' );
			$btnposition = mdc_get_option( 'btnposition', 'mim_portfolio' );
			$rownumber = mdc_get_option( 'rownumber', 'mim_portfolio' );
			$custom_css = "
				#mim-portfolio{ background: $background; text-align: $textposition }
				#mim-portfolio .mim-portfolio h2{ color: $color; font-size: $fontsize }
				.mim-button{ background: $btnbg; font-size: $btnfontsize; text-transform: $btntransform }
				.mim-button:active, .mim-button.is-checked{ background-color: $activebtn }
				.mim-portfolio .mim-button-group .mim-button:hover{ background: $activebtn }
				.mim-button-group{ text-align: $btnposition }
				.element-item{ width: $rownumber }
			";
			wp_add_inline_style( 'mim-style', $custom_css );



			wp_enqueue_script( 'jquery' );
			wp_enqueue_script( 'mim-isotope', plugins_url( '/assets/js/isotope.min.js', MIM_PORTFOLIO ), array(), '1.0', true );
			wp_enqueue_script( 'mim-script', plugins_url( '/assets/js/mim-script.js', MIM_PORTFOLIO ), array(), '1.0', true );
			wp_enqueue_script( 'magnific-script', plugins_url( '/assets/js/jquery.magnific-popup.min.js', MIM_PORTFOLIO ), array(), '1.0', true );
		}

		function mim_portfolio( $atts, $content ) {
			$atts = shortcode_atts( array(
				'' => ''
			), $atts );
			ob_start(); ?>

			<section id="mim-portfolio">
				<div class="mim-portfolio">
					<?php 
						$title = mdc_get_option( 'title', 'mim_portfolio' );
						$description = mdc_get_option( 'description', 'mim_portfolio' );
					?>
					<h2><?php echo $title; ?></h2>
					<p><?php echo $description; ?></p>
					<div id="filters" class="mim-button-group">  
						<button class="mim-button is-checked" data-filter="*">show all</button>
					  	<?php 
						  	$taxonomies = array( 'portfolio-ctg' );
						  	$args = array( 'hide_empty'	=> false, );
						  	$terms = get_terms( $taxonomies, $args ); 
						  	foreach ( $terms as $term ) {
						  		echo '<button class="mim-button" data-filter=".'. $term->slug .'">'. $term->name .'</button>';
						  	}
					  	?>
					</div>

					<div class="grid">
						<?php 
						$args = array(
							'post_type'			=>	'portfolio',
							'posts_per_page'	=>	-1,
							'order'				=>	'ASC'
						);
						$portfolio = new WP_Query( $args );
						while( $portfolio->have_posts() ) : $portfolio->the_post(); 
						$post_terms = get_the_terms( get_the_id(), 'portfolio-ctg' );
						foreach ( $post_terms as $post_term ) {
							$mim_term = $post_term->slug;
						}
						?>
					  	<div class="element-item transition <?php echo $mim_term; ?> " data-category="transition">
							<?php 
							$portfoliostyle = mdc_get_option( 'portfoliostyle', 'mim_portfolio' );
							
								switch ( $portfoliostyle ) {
									case 'style1':
										?>
											<div class="ih-item square effect3 bottom_to_top">
									    		<a class="test-popup-link" href="#">
										        	<div class="img">
										        		<?php the_post_thumbnail(); ?>
										        	</div>
											        <div class="info">
											          <h3><?php the_title(); ?></h3>
											          <?php the_content(); ?>
											    	</div>
											    </a>
										    </div>
										<?php
									break;

									case 'style2':
										?>
											<div class="ih-item square colored effect13 bottom_to_top">
												<a href="#">
									        		<div class="img">
									        			<?php the_post_thumbnail(); ?>
									        		</div>
									        		<div class="info">
											          	<h3><?php the_title(); ?></h3>
											          	<?php the_content(); ?>
									        		</div>
									        	</a>
									        </div>
										<?php
									break;

									case 'style3':
										?>
											<div class="ih-item square colored effect8 scale_down">
												<a href="#">
									        		<div class="img">
									        			<?php the_post_thumbnail(); ?>
									        		</div>
									        		<div class="info">
											          	<h3><?php the_title(); ?></h3>
											          	<?php the_content(); ?>
									        		</div>
									        	</a>
									        </div>
										<?php
									break;

									case 'style4':
										?>
											<div class="ih-item square colored effect5 right_to_left">
												<a href="#">
									        		<div class="img">
									        			<?php the_post_thumbnail(); ?>
									        		</div>
									        		<div class="info">
											          	<h3><?php the_title(); ?></h3>
											          	<?php the_content(); ?>
									        		</div>
									        	</a>
									        </div>
										<?php
									break;

									case 'style5':
										?>
											<div class="ih-item square colored effect10 left_to_right">
												<a href="#">
									        		<div class="img">
									        			<?php the_post_thumbnail(); ?>
									        		</div>
									        		<div class="info">
											          	<h3><?php the_title(); ?></h3>
											          	<?php the_content(); ?>
									        		</div>
									        	</a>
									        </div>
										<?php
									break;

									case 'style6':
										?>	
											<div class="folio-item wow fadeInLeftBig animated" data-wow-duration="1000ms" data-wow-delay="400ms" style="animation-duration: 1000ms; animation-name: fadeInLeftBig; animation-delay: 400ms; visibility: visible;">
									            <div class="folio-image">
									              <?php the_post_thumbnail(); ?>
									            </div>
									            <div class="overlay">
									              <div class="overlay-content">
									                <div class="overlay-text">
									                  <div class="folio-info">
									                    <h3><?php the_title(); ?></h3>
									                    <?php the_content(); ?>
									                  </div>
									                  <div class="folio-overview">
									                    <span class="folio-link"><a class="folio-read-more" href="#"><i class="fa fa-link"></i></a></span>
									                    <span class="folio-expand"><a class="image-link" href="<?php the_post_thumbnail_url(); ?>"><i class="fa fa-search-plus"></i></a></span>
									                  </div>
									                </div>
									              </div>
									            </div>
									          </div>
										<?php
									break;
									
									default:
										?>
											<div class="ih-item square effect3 bottom_to_top">
									    		<a href="#">
										        	<div class="img">
										        		<?php the_post_thumbnail(); ?>
										        	</div>
											        <div class="info">
											          <h3><?php the_title(); ?></h3>
											          <?php the_content(); ?>
											    	</div>
											    </a>
										    </div>
										<?php
									break;
								}
							?>

					  	</div>
					  <?php endwhile; ?>
					</div>
				</div>
			</section>


			<?php return ob_get_clean(); 
		}
	}
endif;
new MIM_PORTFOLIO;