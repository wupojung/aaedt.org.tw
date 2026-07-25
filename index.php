<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package AAEDT
 */

get_header();
?>

<main class="main index_main mobile_gap_40px" id="main-content">
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
</main>

<?php
get_footer();
?>