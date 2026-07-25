<?php
/**
 * The template for displaying single partner posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package AAEDT
 */

get_header();
?>
<!-- DEBUG: Post Type = <?php echo get_post_type(); ?> | Template = single-partners.php -->


<main class="main" id="main-content">
  <?php
  while ( have_posts() ) :
    the_post();
    ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class( 'content-section' ); ?>>
      <div class="section_1280px">
        <div class="section_1040px gap_20px mobile_padding_left_right_20px">
          <header class="page-header">
            <?php if ( function_exists( 'new_aaedt_breadcrumb' ) ) { new_aaedt_breadcrumb(); } ?>
            <h1 class="main-title"><?php the_title(); ?></h1>
          </header>

          <div class="post-content partner-profile-content">
            <?php if ( has_post_thumbnail() ) : ?>
              <div class="partner-logo-wrapper" style="margin-bottom: 30px; text-align: center;">
                <img src="<?php echo esc_url( get_the_post_thumbnail_url( get_the_ID(), 'full' ) ); ?>" class="partner-logo" style="max-width: 250px; height: auto; border: 1px solid #eee; padding: 10px; background: #fff;" alt="<?php the_title_attribute(); ?>" />
              </div>
            <?php endif; ?>

            <div class="partner-description">
              <?php the_content(); ?>
            </div>
          </div>
        </div>
      </div>
    </article>
    <?php
  endwhile; // End of the loop.
  ?>
</main>

<?php
get_footer();
