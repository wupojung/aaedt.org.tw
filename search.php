<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package AAEDT
 */

get_header();
?>

<main class="main" id="main-content">
  <div class="section_1280px">
    <div class="section_1040px gap_20px mobile_padding_left_right_20px">
      
      <?php if ( have_posts() ) : ?>
        
        <header class="page-header">
          <h1 class="main-title">
            <?php
            /* translators: %s: search query. */
            printf( esc_html__( '搜尋結果: %s', 'new-aaedt-theme' ), '<span>' . get_search_query() . '</span>' );
            ?>
          </h1>
        </header>

        <div class="search-results-list">
          <?php
          // Start the Loop.
          while ( have_posts() ) :
            the_post();
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class( 'search-item' ); ?>>
              <h2><a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_title(); ?></a></h2>
              <div class="entry-meta"><?php the_date(); ?></div>
              <?php the_excerpt(); ?>
            </article>
            <?php
          endwhile;

          the_posts_navigation();
          ?>
        </div>

      <?php else : ?>
        <header class="page-header">
          <h1 class="main-title"><?php esc_html_e( '沒有找到符合的結果', 'new-aaedt-theme' ); ?></h1>
        </header>
        <p><?php esc_html_e( '請嘗試使用其他關鍵字重新搜尋。', 'new-aaedt-theme' ); ?></p>
        <?php get_search_form(); ?>
      <?php endif; ?>

    </div>
  </div>
</main>

<?php
get_footer();
