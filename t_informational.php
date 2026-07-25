<?php
/**
 * Template Name: 信息頁
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package AAEDT
 */

get_header();
?>

<!-- <main class="main index_main mobile_gap_40px" id="main-content">
  <div class="section_1280px">
    <div class="section_1040px gap_20px mobile_padding_left_right_20px">
      
      <?php if ( have_posts() ) : ?>
        
        <?php if ( is_home() && ! is_front_page() ) : ?>
          <header class="page-header">
            <h1 class="main-title"><?php single_post_title(); ?></h1>
          </header>
        <?php endif; ?>

        <?php
        // Start the Loop.
        while ( have_posts() ) :
          the_post();
          
          // Your post layout code or template part.
          the_title( '<h2><a href="' . esc_url( get_permalink() ) . '">', '</a></h2>' );
          the_excerpt();
          
        endwhile;

        the_posts_navigation();

      else :

        // If no content, include the "No posts found" template.
        echo '<p>' . esc_html__( '目前尚無內容。', 'new-aaedt-theme' ) . '</p>';

      endif;
      ?>

    </div>
  </div>
</main> -->

  <main class="main" id="main-content">
    <?php if ( have_posts() ) : ?>
    <section class="content-section is-dark arc-bottom content-section-hero">
      <div class="section_1280px">
        <div class="page-header">
          <?php if ( function_exists( 'new_aaedt_breadcrumb' ) ) { new_aaedt_breadcrumb(); } ?>
          <div class="title-group">
            <h2 class="main-title"><?php single_post_title(); ?></h2>
            <div class="title-line-bg"></div>
          </div>
          <div class="intro-group">
            <?php if ( function_exists( 'the_field' ) ):?>
            <h3 class="sub-title"><?php the_field( 'subtitle' ); ?></h3>
            <?php endif; ?>
            <p class="intro-text">
              <?php echo esc_html( get_the_excerpt() ); ?>
            </p>
          </div>
        </div>
      </div>
    </section>
    <?php echo do_shortcode( get_the_content() ); ?>  
    <?php //echo get_post_field( 'post_content', get_the_ID() ); ?>   
    <?php //echo do_shortcode( get_the_content() ); ?>
    <?php //the_content(); ?>

  <?php else : 

    // If no content, include the "No posts found" template.
    echo '<p>' . esc_html__( '目前尚無內容。', 'new-aaedt-theme' ) . '</p>';

  endif;
  ?>
</main>

<?php
get_footer();
?>