<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package AAEDT
 */

get_header();
?>
<!-- DEBUG: Post Type = <?php echo get_post_type(); ?> | Template = single.php -->

<main class="main" id="main-content">
  <?php
  while ( have_posts() ) :
    the_post();

    // Get categories for breadcrumbs and labels
    $categories = get_the_category();
    $category_title = ! empty( $categories ) ? $categories[0]->name : esc_html__( '推廣文章', 'new-aaedt-theme' );
    
    // Create categories list for metadata
    $cat_list = array();
    foreach ( $categories as $category ) {
      $cat_list[] = esc_html( $category->name );
    }
    $category_string = implode( '・', $cat_list );

    // Back link (Defaults to category link, or fallback to home page)
    $back_url = ! empty( $categories ) ? get_category_link( $categories[0]->term_id ) : home_url( '/' );
    ?>
    
    <section class="content-section is-dark arc-bottom content-section-hero">
      <div class="section_1280px">
        <div class="page-header">
          <?php if ( function_exists( 'new_aaedt_breadcrumb' ) ) { new_aaedt_breadcrumb(); } ?>
          <div class="title-group">
            <h2 class="main-title"><?php echo esc_html( $category_title ); ?></h2>
            <div class="title-line-bg"></div>
          </div>
        </div>
      </div>
    </section>

    <div class="section_1280px pt_pb_60px">
      <div class="section_1040px mobile_padding_left_right_20px gap_40px mobile_gap_20px">
        <div class="back-area">
          <a href="<?php echo esc_url( $back_url ); ?>" class="back-group">
            <img class="back-img" src="<?php echo esc_url( get_theme_file_uri( 'public/img/meetings_detail/back_icon.svg' ) ); ?>" alt="" />
            <div>回上一頁</div>
          </a>
        </div>
        <section class="content-section">
          <div class="page-header">
            <div class="intro-group">
              <article id="post-<?php the_ID(); ?>" <?php post_class( 'minutes-article' ); ?>>
                <h1 class="title"><?php the_title(); ?></h1>
                
                <section class="minutes-section">
                  <h2 class="sr-only">文章基本資訊</h2>
                  <dl class="info-list">
                    <div class="item">
                      <dt>發布日期</dt>
                      <dd>：<?php echo get_the_date( 'Y.m.d' ); ?></dd>
                    </div>
                    <?php if ( ! empty( $category_string ) ) : ?>
                      <div class="item">
                        <dt>文章類別</dt>
                        <dd>：<?php echo esc_html( $category_string ); ?></dd>
                      </div>
                    <?php endif; ?>
                    <div class="item">
                      <dt>作者</dt>
                      <dd>：<?php the_author(); ?></dd>
                    </div>
                  </dl>
                </section>

                <div class="spacer-48"></div>

                <section class="minutes-section">
                  <h2 class="title">文章內容</h2>
                  <div class="content">
                    <?php the_content(); ?>
                  </div>
                </section>

                <?php
                // Fetch attachments selected via ACF Relationship Field (Method 2)
                $attachments_field = function_exists( 'get_field' ) ? get_field( 'attachments' ) : null;
                if ( empty( $attachments_field ) ) {
                  $attachments_field = function_exists( 'get_field' ) ? get_field( 'related_attachments' ) : null;
                }

                $attachments = array();
                $attached_images = array();

                if ( ! empty( $attachments_field ) ) {
                  foreach ( $attachments_field as $item ) {
                    // Normalize to item ID (ACF Relationship field returns either Post Object or ID)
                    $item_id = is_object( $item ) ? $item->ID : (is_numeric( $item ) ? $item : null);
                    if ( ! $item_id ) continue;
                    
                    $mime_type = get_post_mime_type( $item_id );
                    if ( strpos( $mime_type, 'image/' ) === 0 ) {
                      // It's an image
                      $attached_images[] = array(
                        'url' => wp_get_attachment_url( $item_id ),
                        'alt' => get_post_meta( $item_id, '_wp_attachment_image_alt', true ),
                      );
                    } else {
                      // It's a document/file download
                      $attachments[] = array(
                        'url'   => wp_get_attachment_url( $item_id ),
                        'title' => get_the_title( $item_id ),
                      );
                    }
                  }
                }

                // Fallback: If no ACF relationship field is selected, query standard post-parent attachments (Option 1 fallback)
                if ( empty( $attachments ) && empty( $attached_images ) ) {
                  $wp_attachments = get_posts( array(
                    'post_type'      => 'attachment',
                    'posts_per_page' => -1,
                    'post_parent'    => get_the_ID(),
                    'exclude'        => get_post_thumbnail_id(), // Exclude featured image
                  ) );

                  if ( ! empty( $wp_attachments ) ) {
                    foreach ( $wp_attachments as $attachment ) {
                      $mime_type = get_post_mime_type( $attachment->ID );
                      if ( strpos( $mime_type, 'image/' ) === 0 ) {
                        $attached_images[] = array(
                          'url' => wp_get_attachment_url( $attachment->ID ),
                          'alt' => get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
                        );
                      } else {
                        $attachments[] = array(
                          'url'   => wp_get_attachment_url( $attachment->ID ),
                          'title' => get_the_title( $attachment->ID ),
                        );
                      }
                    }
                  }
                }
                
                if ( ! empty( $attachments ) ) :
                ?>
                  <div class="spacer-48"></div>

                  <section class="minutes-section">
                    <h2 class="title">相關附件</h2>
                    <div class="content">
                      <ul class="download-list">
                        <?php foreach ( $attachments as $file_item ) :
                          $file_url = $file_item['url'];
                          $file_name = $file_item['title'];
                          
                          if ( empty( $file_name ) ) {
                            $file_name = basename( $file_url );
                          }
                          ?>
                            <li>
                              <span class="file-name"><?php echo esc_html( $file_name ); ?></span>
                              <a
                                href="<?php echo esc_url( $file_url ); ?>"
                                download
                                class="btn-download"
                                aria-label="下載：<?php echo esc_attr( $file_name ); ?>"
                              >
                                檔案下載
                                <img src="<?php echo esc_url( get_theme_file_uri( 'public/img/certification/download_icon.svg' ) ); ?>" alt="" aria-hidden="true" style="width:1.4rem;height:1.4rem;" />
                              </a>
                            </li>
                        <?php endforeach; ?>
                      </ul>
                    </div>
                  </section>
                <?php endif; ?>

                <?php
                // Attempt to fetch ACF photos if defined.
                // We'll support ACF gallery/repeater fields 'photos' or 'article_photos'
                $photos = function_exists( 'get_field' ) ? get_field( 'photos' ) : null;
                if ( empty( $photos ) ) {
                  $photos = function_exists( 'get_field' ) ? get_field( 'article_photos' ) : null;
                }
                
                // Fallback to post-attached images if ACF photo fields are empty
                if ( empty( $photos ) && ! empty( $attached_images ) ) {
                  $photos = $attached_images;
                }
                
                if ( ! empty( $photos ) ) :
                ?>
                  <div class="spacer-48"></div>

                  <section class="minutes-section">
                    <h2 class="title">文章照片</h2>
                    <div class="content padding_top_12px">
                      <div class="photo-grid">
                        <?php foreach ( $photos as $photo_item ) :
                          $photo_url = '';
                          $photo_alt = '';
                          
                          if ( is_array( $photo_item ) ) {
                            $photo_url = isset( $photo_item['url'] ) ? $photo_item['url'] : '';
                            $photo_alt = isset( $photo_item['alt'] ) && ! empty( $photo_item['alt'] ) ? $photo_item['alt'] : get_the_title();
                          } elseif ( is_numeric( $photo_item ) ) {
                            $photo_url = wp_get_attachment_image_url( $photo_item, 'full' );
                            $photo_alt = get_post_meta( $photo_item, '_wp_attachment_image_alt', true );
                          } elseif ( is_string( $photo_item ) ) {
                            $photo_url = $photo_item;
                          }
                          
                          if ( ! empty( $photo_url ) ) :
                          ?>
                            <div class="photo-item">
                              <img src="<?php echo esc_url( $photo_url ); ?>" alt="<?php echo esc_attr( $photo_alt ); ?>" />
                            </div>
                          <?php endif; ?>
                        <?php endforeach; ?>
                      </div>
                    </div>
                  </section>
                <?php endif; ?>
              </article>
            </div>
          </div>
        </section>
      </div>
    </div>
    <?php
  endwhile; // End of the loop.
  ?>
</main>

<?php
get_footer();
