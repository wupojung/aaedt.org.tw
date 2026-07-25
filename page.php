<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package AAEDT
 */

get_header();
?>

<main class="main" id="main-content">
  <?php
  while ( have_posts() ) :
    the_post();
    
    // Display page content here
    ?>
    <section class="content-section">
      <div class="section_1280px">
        <div class="section_1040px gap_20px mobile_padding_left_right_20px">
          <header class="page-header">
            <?php if ( function_exists( 'new_aaedt_breadcrumb' ) ) { new_aaedt_breadcrumb(); } ?>
            <div class="title-group">
              <h1 class="main-title"><?php the_title(); ?></h1>
              <div class="title-line-bg"></div>
            </div>
          </header>

          <div class="page-content">
            <?php the_content(); ?>
          </div>
        </div>
      </div>
    </section>
    <?php

  endwhile; // End of the loop.
  ?>
</main>

<?php
get_footer();
