<?php
/**
 * The template for displaying archive pages.
 * Template Name: 文章列表頁
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package AAEDT
 */

get_header();
?>

      <?php
      // Setup dynamic query target depending on the context
      global $wp_query;
      $query_to_use = $wp_query;
      $resolved_page_cat_ids = array();

      if ( is_page() ) {
        $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
        $args = array(
          'post_type'      => 'post',
          'posts_per_page' => get_option( 'posts_per_page', 6 ),
          'paged'          => $paged,
        );
        
        // Method 1: Check standard categories assigned to the page
        $page_cat_ids = wp_get_post_categories( get_the_ID() );
        if ( ! empty( $page_cat_ids ) && ! is_wp_error( $page_cat_ids ) ) {
          $resolved_page_cat_ids = array_merge( $resolved_page_cat_ids, $page_cat_ids );
        }
        
        // Method 2: Check custom page_category taxonomy (match by slug)
        $page_cat_terms = get_the_terms( get_the_ID(), 'page_category' );
        if ( ! empty( $page_cat_terms ) && ! is_wp_error( $page_cat_terms ) ) {
          foreach ( $page_cat_terms as $term ) {
            $matching_cat = get_category_by_slug( $term->slug );
            if ( $matching_cat ) {
              $resolved_page_cat_ids[] = $matching_cat->term_id;
            }
          }
        }
        
        // Method 3: Check if page slug matches a category slug
        $page_slug = get_post_field( 'post_name', get_the_ID() );
        if ( ! empty( $page_slug ) ) {
          $matching_cat = get_category_by_slug( $page_slug );
          if ( $matching_cat ) {
            $resolved_page_cat_ids[] = $matching_cat->term_id;
          }
          
          // Also check partial slug matches (e.g. 'campaign_overview' -> 'campaign')
          if ( strpos( $page_slug, '_' ) !== false ) {
            $parts = explode( '_', $page_slug );
            $matching_cat = get_category_by_slug( $parts[0] );
            if ( $matching_cat ) {
              $resolved_page_cat_ids[] = $matching_cat->term_id;
            }
          }
        }
        
        $resolved_page_cat_ids = array_unique( $resolved_page_cat_ids );
        
        if ( ! empty( $resolved_page_cat_ids ) ) {
          $args['category__in'] = $resolved_page_cat_ids;
        }
        
        $query_to_use = new WP_Query( $args );
      }
      ?>

      <main class="main" id="main-content">
        <section class="content-section is-dark arc-bottom content-section-hero">
          <div class="section_1280px">
            <div class="page-header">
              <?php if ( function_exists( 'new_aaedt_breadcrumb' ) ) { new_aaedt_breadcrumb(); } ?>
              
              <?php
              $archive_title = '';
              $archive_desc  = '';

              if ( is_page() ) {
                $archive_title = get_the_title();
                $archive_desc  = get_the_content();
              } else {
                if ( is_category() || is_tag() || is_tax() ) {
                  $archive_title = single_term_title( '', false );
                } else if ( is_post_type_archive() ) {
                  $archive_title = post_type_archive_title( '', false );
                } else {
                  $archive_title = get_the_archive_title();
                }
                $archive_desc = get_the_archive_description();
              }
              ?>
              <div class="title-group">
                <h1 class="main-title"><?php echo esc_html( $archive_title ); ?></h1>
                <div class="title-line-bg"></div>
              </div>

              <div class="intro-group">
                <?php if ( ! empty( $archive_desc ) ) : ?>
                  <div class="intro-text">
                    <?php echo wp_kses_post( $archive_desc ); ?>
                  </div>
                <?php else : ?>
                  <h2 class="sub-title">讓可及，從理念走進真實生活</h2>
                  <p class="intro-text">
                    可及，不只是一種設計原則，更是一連串需要被實踐、被記錄、被分享的行動。
                  </p>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </section>

        <div class="section_1280px pt_pb_60px">
          <div class="section_1040px mobile_padding_left_right_20px gap_40px mobile_gap_20px">
            <section class="content-section">
              <div class="page-header">
                <div class="title-group">
                  <h2 class="main-title">文章內容</h2>
                  <div class="title-line-bg"></div>
                </div>

                <div class="intro-group">
                  <?php
                  $current_object = get_queried_object();
                  $sub_categories = array();
                  $all_url = '';
                  $current_term_id = 0;
                  $parent_id = 0;

                  if ( $current_object && ( is_category() || is_tax() || is_tag() ) ) {
                    $current_term_id = $current_object->term_id;
                    $taxonomy = $current_object->taxonomy;
                    
                    // If hierarchical, get parent to list all sibling sub-categories
                    if ( is_taxonomy_hierarchical( $taxonomy ) ) {
                      $parent_id = $current_object->parent ? $current_object->parent : $current_object->term_id;
                      
                      $sub_categories = get_terms( array(
                        'taxonomy'   => $taxonomy,
                        'parent'     => $parent_id,
                        'hide_empty' => false,
                      ) );
                      
                      $parent_term = get_term( $parent_id, $taxonomy );
                      $all_url = $parent_term && ! is_wp_error( $parent_term ) ? get_term_link( $parent_term ) : '';
                    }
                  } elseif ( is_page() ) {
                    // Get categories of the current page to find their child categories
                    if ( ! empty( $resolved_page_cat_ids ) ) {
                      $parent_id = $resolved_page_cat_ids[0];
                      $sub_categories = get_terms( array(
                        'taxonomy'   => 'category',
                        'parent'     => $parent_id,
                        'hide_empty' => false,
                      ) );
                      $parent_term = get_term( $parent_id, 'category' );
                      $all_url = $parent_term && ! is_wp_error( $parent_term ) ? get_term_link( $parent_term ) : '';
                      $current_term_id = $parent_id; // Active tab: "All"
                    }
                  }
                  ?>
                  <!-- <h1 class="sub-title">$resolved_page_cat_ids: <?php var_dump( $resolved_page_cat_ids ); ?></h1>
                  <h1 class="sub-title">$sub_categories: <?php var_dump( $sub_categories ); ?></h1> -->
                  <?php if ( ! empty( $sub_categories ) && ! is_wp_error( $sub_categories ) ) : ?>
                    <div class="category-warp">
                      <div class="category-group">
                        <h3>文章類別</h3>
                        <div class="category-content" id="filter-category">
                          <a href="<?php echo esc_url( $all_url ); ?>" class="tag<?php echo ( $current_term_id === $parent_id ) ? ' active' : ''; ?>">全部</a>
                          <?php foreach ( $sub_categories as $sub_cat ) : ?>
                            <a href="<?php echo esc_url( get_term_link( $sub_cat ) ); ?>" class="tag<?php echo ( $current_term_id === $sub_cat->term_id ) ? ' active' : ''; ?>">
                              <?php echo esc_html( $sub_cat->name ); ?>
                            </a>
                          <?php endforeach; ?>
                        </div>
                      </div>
                    </div>
                  <?php endif; ?>

                  <ul class="card-grid" id="card-grid">
                    <?php if ( $query_to_use->have_posts() ) : ?>
                      <?php while ( $query_to_use->have_posts() ) : $query_to_use->the_post(); ?>
                        <li class="card-meeting">
                          <div class="card-meeting-image">
                            <?php if ( has_post_thumbnail() ) : ?>
                              <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail( 'medium_large' ); ?>
                              </a>
                            <?php else : ?>
                              <a href="<?php the_permalink(); ?>">
                                <img src="<?php echo esc_url( get_theme_file_uri( 'public/img/article-img.png' ) ); ?>" alt="" />
                              </a>
                            <?php endif; ?>
                          </div>
                          <div class="card-meeting-describe">
                            <div class="card-meeting-tag-wrap">
                              <span class="tag">
                                <?php
                                $categories = get_the_category();
                                if ( ! empty( $categories ) ) {
                                  echo esc_html( $categories[0]->name );
                                } else {
                                  echo esc_html__( '文章', 'new-aaedt-theme' );
                                }
                                ?>
                              </span>
                            </div>
                            <div class="card-meeting-content-wrap">
                              <time datetime="<?php echo get_the_date( 'c' ); ?>" class="card-meeting-date">
                                <?php echo get_the_date( 'Y.m.d' ); ?>
                              </time>
                              <h3 class="card-meeting-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                              </h3>
                            </div>
                          </div>
                        </li>
                      <?php endwhile; ?>
                      <?php wp_reset_postdata(); ?>
                    <?php else : ?>
                      <li class="card-empty" style="list-style: none; text-align: center; width: 100%; padding: 40px 0; color: #837b74;">
                        <?php esc_html_e( '目前沒有找到相關文章。', 'new-aaedt-theme' ); ?>
                      </li>
                    <?php endif; ?>
                  </ul>
                </div>
              </div>
            </section>

            <?php
            $total_pages = $query_to_use->max_num_pages;
            $current_page = max( 1, get_query_var( 'paged' ) );

            if ( $total_pages > 1 ) :
              ?>
              <nav class="pagination" id="pagination" aria-label="分頁導覽">
                <?php
                $prev_url = get_pagenum_link( $current_page - 1 );
                $prev_svg = '<svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7 1L1 7L7 13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>';
                if ( $current_page > 1 ) {
                  echo '<a href="' . esc_url( $prev_url ) . '" class="pagination-btn arrow">' . $prev_svg . '</a>';
                } else {
                  echo '<button class="pagination-btn arrow" disabled>' . $prev_svg . '</button>';
                }

                for ( $i = 1; $i <= $total_pages; $i++ ) {
                  if ( $i === $current_page ) {
                    echo '<button class="pagination-btn active" aria-current="page">' . $i . '</button>';
                  } else {
                    echo '<a href="' . esc_url( get_pagenum_link( $i ) ) . '" class="pagination-btn">' . $i . '</a>';
                  }
                }

                $next_url = get_pagenum_link( $current_page + 1 );
                $next_svg = '<svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1 1L7 7L1 13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>';
                if ( $current_page < $total_pages ) {
                  echo '<a href="' . esc_url( $next_url ) . '" class="pagination-btn arrow">' . $next_svg . '</a>';
                } else {
                  echo '<button class="pagination-btn arrow" disabled>' . $next_svg . '</button>';
                }
                ?>
              </nav>
            <?php endif; ?>
          </div>
        </div>
      </main>

<?php
get_footer();
