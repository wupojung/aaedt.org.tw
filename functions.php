<?php
/**
 * AAEDT Theme functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package AAEDT
 */

if ( ! function_exists( 'new_aaedt_theme_setup' ) ) :
  /**
   * Sets up theme defaults and registers support for various WordPress features.
   */
  function new_aaedt_theme_setup() {
    // Let WordPress manage the document title.
    add_theme_support( 'title-tag' );

    // Enable support for Post Thumbnails on posts and pages.
    add_theme_support( 'post-thumbnails' );

    // Register navigation menus.
    register_nav_menus( array(
      'primary' => esc_html__( 'Primary Menu', 'new-aaedt-theme' ),
    ) );

    // Enable custom logo support.
    add_theme_support( 'custom-logo', array(
      'height'      => 60,
      'width'       => 200,
      'flex-height' => true,
      'flex-width'  => true,
    ) );

    // Switch default core markup for search form, comment form, and comments to output valid HTML5.
    add_theme_support( 'html5', array(
      'search-form',
      'comment-form',
      'comment-list',
      'gallery',
      'caption',
      'style',
      'script',
    ) );
  }
endif;
add_action( 'after_setup_theme', 'new_aaedt_theme_setup' );

/**
 * Add support for page excerpts and categories.
 */
function new_aaedt_theme_add_page_supports() {
  add_post_type_support( 'page', 'excerpt' );
  register_taxonomy_for_object_type( 'category', 'page' );

  register_taxonomy(
    'page_category',
    'page',
    array(
      'label'        => 'Page Categories',
      'hierarchical' => true,
      'show_ui'      => true,
      'show_in_rest' => true,
    )
  );
}
add_action( 'init', 'new_aaedt_theme_add_page_supports' );

/**
 * Enqueue scripts and styles.
 */
function new_aaedt_theme_scripts() {
  // Enqueue compiled style.css stylesheet
  wp_enqueue_style( 'new-aaedt-theme-style', get_stylesheet_uri(), array(), '1.0.0' );
}
add_action( 'wp_enqueue_scripts', 'new_aaedt_theme_scripts' );

/**
 * Custom breadcrumb function for new-aaedt-theme.
 * Follows: Homepage -> Category -> Current Page/Post.
 */
function new_aaedt_breadcrumb() {
  // Do not display breadcrumbs on front page or home page
  if ( is_front_page() || is_home() ) {
    return;
  }

  global $post;

  echo '<div class="breadcrumb">';

  // 1. Homepage link
  echo '<a href="' . esc_url( home_url( '/' ) ) . '" class="link">' . esc_html__( '首頁', 'new-aaedt-theme' ) . '</a>';

  $sep = '<span class="sep">/</span>';

  if ( is_single() ) {
    // 2. Category
    $categories = get_the_category();
    if ( ! empty( $categories ) ) {
      // Display the first category
      $category = $categories[0];
      echo $sep;
      echo '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" class="link">' . esc_html( $category->name ) . '</a>';
    }

    // 3. Current page (post)
    echo $sep;
    echo '<a href="#" class="link active">' . esc_html( get_the_title() ) . '</a>';

  } elseif ( is_page() ) {
    // Check if categories are assigned to the page (since theme registers category for page)
    $categories = get_the_terms( $post->ID, 'page_category' );
    if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) {
      $category = $categories[0];
      echo $sep;
      echo '<a href="' . esc_url( get_term_link( $category ) ) . '" class="link">' . esc_html( $category->name ) . '</a>';
    } else {
      // Show page parent hierarchy if no category is assigned
      if ( $post && $post->post_parent ) {
        $ancestors = array_reverse( get_post_ancestors( $post->ID ) );
        foreach ( $ancestors as $ancestor ) {
          echo $sep;
          echo '<a href="' . esc_url( get_permalink( $ancestor ) ) . '" class="link">' . esc_html( get_the_title( $ancestor ) ) . '</a>';
        }
      }
    }

    // Current page title
    echo $sep;
    echo '<a href="#" class="link active">' . esc_html( get_the_title() ) . '</a>';

  } elseif ( is_category() ) {
    // Show parent categories if any
    $current_category = get_queried_object();
    if ( $current_category && $current_category->parent ) {
      $parent_ids = array_reverse( get_ancestors( $current_category->term_id, 'category' ) );
      foreach ( $parent_ids as $parent_id ) {
        $parent_cat = get_category( $parent_id );
        if ( $parent_cat ) {
          echo $sep;
          echo '<a href="' . esc_url( get_category_link( $parent_cat->term_id ) ) . '" class="link">' . esc_html( $parent_cat->name ) . '</a>';
        }
      }
    }

    // Current category title
    echo $sep;
    echo '<a href="#" class="link active">' . esc_html( single_cat_title( '', false ) ) . '</a>';

  } elseif ( is_tag() ) {
    echo $sep;
    echo '<a href="#" class="link active">' . esc_html( single_tag_title( '', false ) ) . '</a>';

  } elseif ( is_day() ) {
    echo $sep;
    echo '<a href="#" class="link active">' . esc_html( get_the_time( get_option( 'date_format' ) ) ) . '</a>';

  } elseif ( is_month() ) {
    echo $sep;
    echo '<a href="#" class="link active">' . esc_html( get_the_time( 'F, Y' ) ) . '</a>';

  } elseif ( is_year() ) {
    echo $sep;
    echo '<a href="#" class="link active">' . esc_html( get_the_time( 'Y' ) ) . '</a>';

  } elseif ( is_search() ) {
    echo $sep;
    echo '<a href="#" class="link active">' . sprintf( esc_html__( '搜尋結果: %s', 'new-aaedt-theme' ), esc_html( get_search_query() ) ) . '</a>';

  } elseif ( is_author() ) {
    $author = get_queried_object();
    echo $sep;
    echo '<a href="#" class="link active">' . sprintf( esc_html__( '作者: %s', 'new-aaedt-theme' ), esc_html( $author->display_name ) ) . '</a>';

  } else {
    echo $sep;
    echo '<a href="#" class="link active">' . esc_html( get_the_title() ) . '</a>';
  }

  echo '</div>';
}

/**
 * Register breadcrumb shortcode.
 * Usage: [breadcrumb]
 */
function new_aaedt_breadcrumb_shortcode() {
  ob_start();
  new_aaedt_breadcrumb();
  return ob_get_clean();
}
add_shortcode( 'breadcrumb', 'new_aaedt_breadcrumb_shortcode' );

/**
 * Reusable helper to render shortcode title warnings.
 */
function new_aaedt_shortcode_title_warning( $shortcode_name, $default_placeholder ) {
  return '<span class="shortcode-warning" style="display:inline-block; padding: 5px 10px; background:#f2dede; border:1px solid #ebccd1; color:#a94442; border-radius:4px; font-size:14px; font-weight:normal; margin-bottom:10px;">' . sprintf( __( '【系統提示：此區塊標題為空。請在編輯器中加入 %1$s 屬性，例如：%2$s】', 'new-aaedt-theme' ), '<code>title</code>', '<code>[' . $shortcode_name . ' title="' . $default_placeholder . '"]</code>' ) . '</span>';
}

/**
 * Shortcode for "為什麼需要環境改善？" (Section 1)
 * Usage: [section_1 title="..." desc_1="..." items="item1|item2" desc_2="..." img="..." img_id="..."]
 */
function new_aaedt_why_improvement_shortcode( $atts ) {
  // Retrieve custom image uploaded via Meta Box
  $meta_img_id = get_post_meta( get_the_ID(), '_new_aaedt_section_1', true );
  $meta_img_url = $meta_img_id ? wp_get_attachment_image_url( $meta_img_id, 'full' ) : '';

  $atts = shortcode_atts( array(
    'title'  => '為什麼需要環境改善？',
    'desc_1' => '多數環境障礙其實不是使用者造成，而是在設計或施工階段「無意間」產生。',
    'items'  => '入口僅差 3 公分的高差，就可能讓輪椅與娃娃車無法通過|人行道突起、斜坡過陡，使長者行走困難|公共空間的轉彎半徑太小，造成推行輔具不便|廁所設備位置不當，讓使用者無法安全使用',
    'desc_2' => '改善並不是「為特定族群妥協」，而是讓空間回到最初的目的──讓人能使用。',
    'img'    => 'https://c.animaapp.com/mkudp988xLWCmu/img/-----2025-09-23-21-09-13-1.png',
    'img_id' => '',
  ), $atts );

  // Determine final image URL
  $img_url = '';
  if ( ! empty( $atts['img_id'] ) ) {
    $img_url = wp_get_attachment_image_url( $atts['img_id'], 'full' );
  }
  if ( empty( $img_url ) ) {
    $img_url = ! empty( $meta_img_url ) ? $meta_img_url : $atts['img'];
  }

  ob_start();
  ?>
  <div class="section_1280px pt_pb_60px">
    <div class="section_1040px mobile_padding_left_right_20px">
      <section class="content-section">
        <div class="page-header">
          <div class="title-group">
            <?php if ( ! empty( $atts['title'] ) ) : ?>
              <h2 class="main-title"><?php echo esc_html( $atts['title'] ); ?></h2>
            <?php else : ?>
              <?php echo new_aaedt_shortcode_title_warning( 'section_1', '為什麼需要環境改善？' ); ?>
            <?php endif; ?>
            <div class="title-line-bg"></div>
          </div>
          <div class="intro-group --split mobile_gap_20px">
            <div class="intro-content mobile_margin_bottom_20px">
              <?php if ( ! empty( $atts['desc_1'] ) ) : ?>
                <p><?php echo esc_html( $atts['desc_1'] ); ?></p>
              <?php endif; ?>
              
              <?php if ( ! empty( $atts['items'] ) ) : ?>
                <p><?php _e( '例如：', 'new-aaedt-theme' ); ?></p>
                <ul class="intro-list">
                  <?php
                  $items_list = explode( '|', $atts['items'] );
                  foreach ( $items_list as $item ) {
                    if ( empty( trim( $item ) ) ) continue;
                    echo '<li>' . esc_html( trim( $item ) ) . '</li>';
                  }
                  ?>
                </ul>
              <?php endif; ?>

              <?php if ( ! empty( $atts['desc_2'] ) ) : ?>
                <p><?php echo esc_html( $atts['desc_2'] ); ?></p>
              <?php endif; ?>
            </div>
            <div class="intro-image">
              <img src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( $atts['title'] ); ?>" />
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
  <?php
  return ob_get_clean();
}
add_shortcode( 'section_1', 'new_aaedt_why_improvement_shortcode' );

/**
 * -----------------------------------------------------------------------------
 * Helpers & Shared Layout Engine for Shortcodes
 * -----------------------------------------------------------------------------
 */

/**
 * Shared Image Resolver Helper for shortcodes
 */
if ( ! function_exists( 'new_aaedt_resolve_image_url' ) ) {
  function new_aaedt_resolve_image_url( $atts, $default_url = '' ) {
    if ( ! empty( $atts['img_id'] ) ) {
      $url = wp_get_attachment_image_url( $atts['img_id'], 'full' );
      if ( $url ) return $url;
    }
    if ( ! empty( $atts['meta_key'] ) ) {
      $meta_id = get_post_meta( get_the_ID(), '_new_aaedt_' . $atts['meta_key'], true );
      if ( $meta_id ) {
        $url = wp_get_attachment_image_url( $meta_id, 'full' );
        if ( $url ) return $url;
      }
    }
    return ! empty( $atts['img'] ) ? $atts['img'] : $default_url;
  }
}

/**
 * Pipe-Delimited List Helper
 */
if ( ! function_exists( 'new_aaedt_render_pipe_list' ) ) {
  function new_aaedt_render_pipe_list( $items_str, $ul_class = 'intro-list' ) {
    if ( empty( trim( $items_str ) ) ) return '';
    $items = array_filter( array_map( 'trim', explode( '|', $items_str ) ) );
    if ( empty( $items ) ) return '';

    $lis = implode( '', array_map( function( $item ) {
      return sprintf( '<li>%s</li>', esc_html( $item ) );
    }, $items ) );

    return sprintf( '<ul class="%s">%s</ul>', esc_attr( $ul_class ), $lis );
  }
}

/**
 * Standardized Section Container Renderer Helper
 */
if ( ! function_exists( 'new_aaedt_render_section_wrapper' ) ) {
  function new_aaedt_render_section_wrapper( $atts, $content_html, $options = array() ) {
    $options = wp_parse_args( $options, array(
      'section_class'  => 'content-section',
      'has_outer_div'  => false,
      'shortcode_name' => '',
      'default_title'  => '',
    ) );

    $title = ! empty( $atts['title'] ) ? esc_html( trim( $atts['title'] ) ) : '';

    $header_html = '';
    if ( ! empty( $title ) ) {
      $header_html = sprintf(
        '<div class="page-header">
          <div class="title-group">
            <h2 class="main-title">%s</h2>
            <div class="title-line-bg"></div>
          </div>
        </div>',
        $title
      );
    }

    if ( $options['has_outer_div'] ) {
      return sprintf(
        '<div class="section_1280px pt_pb_60px"><div class="section_1040px mobile_padding_left_right_20px"><section class="%s">%s%s</section></div></div>',
        esc_attr( $options['section_class'] ),
        $header_html,
        $content_html
      );
    }

    return sprintf(
      '<section class="%s"><div class="section_1280px"><div class="section_1040px mobile_padding_left_right_20px">%s%s<div class="spacer-48"></div></div></div></section>',
      esc_attr( $options['section_class'] ),
      $header_html,
      $content_html
    );
  }
}

/**
 * -----------------------------------------------------------------------------
 * Master Flexible Section & Component Shortcodes
 * -----------------------------------------------------------------------------
 */

/**
 * 1. Master Section Container Shortcode: [aaedt_section]
 * Options:
 *   title: Section title
 *   bg: "gray" / "dark" (dark background) | "light" / "none"
 *   arc: "top" | "bottom" | "both" | "none"
 */
function new_aaedt_unified_section_shortcode( $atts, $content = null ) {
  $atts = shortcode_atts( array(
    'title' => '',
    'bg'    => 'light', // 'gray' or 'light'
    'arc'   => 'none',  // 'top', 'bottom', 'both', 'none'
    'class' => '',
  ), $atts );

  // Construct section CSS classes
  $classes = array( 'content-section' );

  if ( in_array( $atts['bg'], array( 'gray', 'dark' ), true ) ) {
    $classes[] = 'is-dark';
  }

  if ( in_array( $atts['arc'], array( 'top', 'both' ), true ) ) {
    $classes[] = 'arc-top';
  }
  if ( in_array( $atts['arc'], array( 'bottom', 'both' ), true ) ) {
    $classes[] = 'arc-bottom';
  }

  if ( ! empty( $atts['class'] ) ) {
    $classes[] = esc_attr( $atts['class'] );
  }

  $classes_str = implode( ' ', $classes );

  return new_aaedt_render_section_wrapper(
    $atts,
    do_shortcode( $content ),
    array(
      'section_class'  => $classes_str,
      'has_outer_div'  => false,
      'shortcode_name' => 'aaedt_section',
      'default_title'  => '',
    )
  );
}
add_shortcode( 'aaedt_section', 'new_aaedt_unified_section_shortcode' );

/**
 * Helper to wrap content inside left/right column structure.
 * Checks if content is an <img> tag or contains text, or uses explicit type="text|image" attribute.
 * If text -> class="intro-content mobile_margin_bottom_20px"
 * If image -> class="intro-image"
 */
function new_aaedt_render_column_box( $atts, $content, $col_position = 'left' ) {
  $atts = shortcode_atts( array(
    'type'  => '', // 'text' or 'image'
    'class' => '',
  ), $atts );

  if ( empty( trim( $content ) ) ) {
    return array( 'html' => '', 'is_image' => false );
  }

  $parsed_content = do_shortcode( $content );

  // Determine if this block is an image or text
  $is_image = false;

  if ( in_array( strtolower( $atts['type'] ), array( 'image', 'img' ), true ) ) {
    $is_image = true;
  } elseif ( 'text' === strtolower( $atts['type'] ) ) {
    $is_image = false;
  } else {
    // Auto-detect if content is an <img> tag or anchor wrapped <img> tag
    $is_image = preg_match( '/^\s*(<p>\s*)?<a[^>]*>\s*<img[^>]+>\s*<\/a>(\s*<\/p>)?\s*$/i', trim( $parsed_content ) ) || preg_match( '/^\s*(<p>\s*)?<img[^>]+>(\s*<\/p>)?\s*$/i', trim( $parsed_content ) );
  }

  if ( $is_image ) {
    // Clean paragraph wrappers around img tag if present
    $img_tag = preg_replace( '/^<p>\s*(.*?)\s*<\/p>$/i', '$1', trim( $parsed_content ) );
    $extra_class = ! empty( $atts['class'] ) ? ' ' . esc_attr( $atts['class'] ) : '';
    return array(
      'html'     => sprintf( '<div class="intro-image%s">%s</div>', $extra_class, $img_tag ),
      'is_image' => true,
    );
  }

  $extra_class = ! empty( $atts['class'] ) ? ' ' . esc_attr( $atts['class'] ) : '';
  return array(
    'html'     => sprintf( '<div class="intro-content mobile_margin_bottom_20px%s">%s</div>', $extra_class, $parsed_content ),
    'is_image' => false,
  );
}

/**
 * 2a. Master Text/Split Block Container Shortcode: [text_block]
 * Usage: [text_block][left_content]...[/left_content][right_content]...[/right_content][/text_block]
 */
function new_aaedt_text_block_shortcode( $atts, $content = null ) {
  $atts = shortcode_atts( array(
    'class' => '',
  ), $atts );

  $inner_html = do_shortcode( $content );
  $inner_html = str_replace( array( 'data-col-type="left-image"', 'data-col-type="left-text"', 'data-col-type="right-image"', 'data-col-type="right-text"' ), '', $inner_html );

  return sprintf(
    '<div class="intro-group --split mobile_gap_20px %s">%s</div>',
    esc_attr( trim( $atts['class'] ) ),
    $inner_html
  );
}
add_shortcode( 'text_block', 'new_aaedt_text_block_shortcode' );
add_shortcode( 'split_block', 'new_aaedt_text_block_shortcode' );

/**
 * 2b. Left Column Shortcode: [left_content]
 */
function new_aaedt_left_content_shortcode( $atts, $content = null ) {
  $res = new_aaedt_render_column_box( $atts, $content, 'left' );
  $marker = $res['is_image'] ? 'data-col-type="left-image"' : 'data-col-type="left-text"';
  return str_replace( '<div class="intro-', '<div ' . $marker . ' class="intro-', $res['html'] );
}
add_shortcode( 'left_content', 'new_aaedt_left_content_shortcode' );

/**
 * 2c. Right Column Shortcode: [right_content]
 */
function new_aaedt_right_content_shortcode( $atts, $content = null ) {
  $res = new_aaedt_render_column_box( $atts, $content, 'right' );
  $marker = $res['is_image'] ? 'data-col-type="right-image"' : 'data-col-type="right-text"';
  return str_replace( '<div class="intro-', '<div ' . $marker . ' class="intro-', $res['html'] );
}
add_shortcode( 'right_content', 'new_aaedt_right_content_shortcode' );

/**
 * 2d. Helper List Shortcode: [list title="..."]item1|item2[/list]
 */
function new_aaedt_list_shortcode( $atts, $content = null ) {
  $atts = shortcode_atts( array(
    'title' => '',
  ), $atts );

  $title_html = ! empty( $atts['title'] ) ? sprintf( '<p class="intro-text">%s</p>', esc_html( $atts['title'] ) ) : '';
  $list_html  = new_aaedt_render_pipe_list( $content );

  return $title_html . $list_html;
}
add_shortcode( 'list', 'new_aaedt_list_shortcode' );

/**
 * 2e. Subtitle Shortcode: [h3]text[/h3]
 * Automatically outputs <h3 class="sub-title">text</h3>
 */
function new_aaedt_h3_subtitle_shortcode( $atts, $content = null ) {
  $atts = shortcode_atts( array(
    'class' => 'sub-title',
  ), $atts );

  if ( empty( trim( $content ) ) ) {
    return '';
  }

  $class_name = ( 'sub-title' === $atts['class'] ) ? 'sub-title' : 'sub-title ' . esc_attr( $atts['class'] );

  return sprintf(
    '<h3 class="%s">%s</h3>',
    esc_attr( $class_name ),
    wp_kses_post( trim( $content ) )
  );
}
add_shortcode( 'h3', 'new_aaedt_h3_subtitle_shortcode' );

/**
 * 3. Progress Steps Wrapper Shortcode: [process_steps]
 */
function new_aaedt_process_steps_container_shortcode( $atts, $content = null ) {
  return sprintf(
    '<div class="intro-group pt_pb_30px"><ol class="process-steps">%s</ol></div>',
    do_shortcode( $content )
  );
}
add_shortcode( 'process_steps', 'new_aaedt_process_steps_container_shortcode' );

/**
 * 4. Step Item Shortcode: [step]
 */
function new_aaedt_step_item_shortcode( $atts, $content = null ) {
  $atts = shortcode_atts( array(
    'num'   => '1',
    'title' => '',
  ), $atts );

  $title_html = ! empty( $atts['title'] ) ? sprintf( '<h3>%s</h3>', esc_html( $atts['title'] ) ) : '';
  $desc_html  = ! empty( $content ) ? sprintf( '<p>%s</p>', wp_kses_post( trim( $content ) ) ) : '';

  return sprintf(
    '<li>
      <div class="step-line" aria-hidden="true"></div>
      <div class="step-number" aria-hidden="true">%s</div>
      <div class="step-content">%s%s</div>
    </li>',
    esc_html( $atts['num'] ),
    $title_html,
    $desc_html
  );
}
add_shortcode( 'step', 'new_aaedt_step_item_shortcode' );

/**
 * -----------------------------------------------------------------------------
 * Backwards-Compatible Legacy Shortcodes (section_2, service_item, process_flow)
 * -----------------------------------------------------------------------------
 */

/**
 * Shortcode wrapper for "服務項目" (Section 2)
 * Usage: [section_2 title="..."][service_item title="..." img="..." items="..."]...[/service_item][/section_2]
 */
function new_aaedt_services_shortcode( $atts, $content = null ) {
  $atts = shortcode_atts( array(
    'title' => '服務項目',
  ), $atts );
  
  if ( empty( $content ) ) {
    $content = '[service_item meta_key="section_2" title="一、居家可及性改善" items="居家動線評估與風險檢視|出入口、浴室、廚房、臥室的可及性改善建議|高差、照明、地面材質、防跌設計|居家輔具配置建議（非販售，僅提供專業建議）" outro="讓每個家，都能陪伴家人安全地老化，也能滿足暫時性與長期性的行動需求。"]以「家」為核心，協助行動不便者、長者、孕婦、兒童與一般家庭打造安全便利的生活動線。[/service_item]';
    $content .= '[service_item meta_key="section_3" title="二、戶外空間改善（街道、公園、校園、社區…）" items="人行動線與通行性評估|高差、坡道、無障礙介面改善策略|公園與街道家具配置建議|社區與校園的可及性整體改善規劃" outro="一個更友善的城市，從改善一條路開始。" image_first="true"]從動線到使用者行為，以專業觀點協助公共空間變得更友善。[/service_item]';
    $content .= '[service_item meta_key="section_4" title="三、建築與室內空間改善" items="入口、動線與走廊改善建議|電梯、樓梯、休息區等使用性評估|室內公共區域（接待區、廁所、餐廳等）可及性提升|材质、配置與設備的改善方案" outro="讓建築不僅符合規範，更符合「人」的使用需求。"]以全齡、全人、全使用者為出發點，協助空間從細節重新被思考。[/service_item]';
  }

  return new_aaedt_render_section_wrapper(
    $atts,
    do_shortcode( $content ),
    array(
      'section_class'  => 'content-section is-dark arc-top arc-bottom mb_60px mobile_margin_top_40px mobile_margin_bottom_40px',
      'shortcode_name' => 'section_2',
      'default_title'  => '服務項目',
    )
  );
}
add_shortcode( 'section_2', 'new_aaedt_services_shortcode' );

/**
 * Child shortcode for a single service item inside [section_2]
 */
function new_aaedt_service_item_shortcode( $atts, $content = null ) {
  $atts = shortcode_atts( array(
    'title'       => '',
    'img'         => 'https://c.animaapp.com/mkudp988xLWCmu/img/-----2025-09-23-21-09-13-1.png',
    'img_id'      => '',
    'meta_key'    => '',
    'items'       => '',
    'outro'       => '',
    'image_first' => 'false',
  ), $atts );

  $swap = ( 'true' === $atts['image_first'] ) ? 'true' : 'false';

  return new_aaedt_flexible_split_block_shortcode(
    array_merge( $atts, array( 'swap' => $swap ) ),
    $content
  );
}
add_shortcode( 'service_item', 'new_aaedt_service_item_shortcode' );

/**
 * Shortcode for "服務流程" (Section 3)
 */
function new_aaedt_service_flow_shortcode( $atts, $content = null ) {
  $atts = shortcode_atts( array(
    'title' => '服務流程',
  ), $atts );
  
  if ( empty( $content ) ) {
    $content = '[step num="1" title="初步諮詢"]了解場域需求、使用者狀態與改善目標。[/step]';
    $content .= '[step num="2" title="現場評估"]協會專業人員到場檢視動線、障礙與風險。[/step]';
    $content .= '[step num="3" title="可及性分析報告"]提供問題點分析、改善方案與建議。[/step]';
    $content .= '[step num="4" title="設計階段諮詢（選配）"]配合建築師、設計團隊進行細部改善規劃。[/step]';
    $content .= '[step num="5" title="完工後檢視（選配）"]協助確認施工成果符合可及性需求。[/step]';
  }

  $flow_content = sprintf( '<div class="intro-group"><ol class="process-steps">%s</ol></div>', do_shortcode( $content ) );

  return new_aaedt_render_section_wrapper(
    $atts,
    $flow_content,
    array(
      'section_class'  => 'content-section',
      'has_outer_div'  => true,
      'shortcode_name' => 'process_flow',
      'default_title'  => '服務流程',
    )
  );
}
add_shortcode( 'process_flow', 'new_aaedt_service_flow_shortcode' );

/**
 * Shortcode for "打造可及環境，不需要很複雜" (Section 4)
 * Usage: [section_4 title="..." img="..." img_id="..."]Content[/section_4]
 */
function new_aaedt_improvement_outro_shortcode( $atts, $content = null ) {
  // Retrieve custom image uploaded via Meta Box
  $meta_img_id = get_post_meta( get_the_ID(), '_new_aaedt_section_5', true );
  $meta_img_url = $meta_img_id ? wp_get_attachment_image_url( $meta_img_id, 'full' ) : '';

  $atts = shortcode_atts( array(
    'title'  => '打造可及環境，不需要很複雜',
    'img'    => 'https://c.animaapp.com/mkudp988xLWCmu/img/-----2025-09-23-21-09-13-1.png',
    'img_id' => '',
  ), $atts );

  // Determine final image URL
  $img_url = '';
  if ( ! empty( $atts['img_id'] ) ) {
    $img_url = wp_get_attachment_image_url( $atts['img_id'], 'full' );
  }
  if ( empty( $img_url ) ) {
    $img_url = ! empty( $meta_img_url ) ? $meta_img_url : $atts['img'];
  }

  if ( empty( $content ) ) {
    $content = '有時只需要調整一公分的高差、改變一個方向、重新選擇一種材質，就能讓空間從「難以使用」變成「人人可用」。<br />如果你正在規劃改善家居、社區、校園或建築空間，我們很樂意與你一起討論。<br />讓可及，不長是理想，而是每天都能被感受到的便利。';
  }

  ob_start();
  ?>
  <section class="content-section is-dark arc-top mb_0">
    <div class="section_1280px pt_pb_60px">
      <div class="section_1040px mobile_padding_left_right_20px">
        <div class="page-header">
          <div class="intro-group --split">
            <div class="intro-content mobile_margin_bottom_20px">
              <?php if ( ! empty( $atts['title'] ) ) : ?>
                <h3 class="sub-title"><?php echo esc_html( $atts['title'] ); ?></h3>
              <?php else : ?>
                <?php echo new_aaedt_shortcode_title_warning( 'section_4', '打造可及環境，不需要很複雜' ); ?>
              <?php endif; ?>
              <p>
                <?php echo wp_kses_post( $content ); ?>
              </p>
            </div>
            <div class="intro-image">
              <img src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( $atts['title'] ); ?>" />
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <?php
  return ob_get_clean();
}
add_shortcode( 'section_4', 'new_aaedt_improvement_outro_shortcode' );

/**
 * Register Custom Meta Box for Page Image Selectors
 */
function new_aaedt_info_page_meta_boxes() {
  global $post;
  if ( ! $post ) {
    return;
  }
  
  // Show meta box on all pages
  add_meta_box(
    'new_aaedt_info_images_meta',
    __( '頁面區塊圖片設定 (Media Picker)', 'new-aaedt-theme' ),
    'new_aaedt_render_info_images_meta_box',
    'page',
    'normal',
    'high'
  );
}
add_action( 'add_meta_boxes', 'new_aaedt_info_page_meta_boxes' );

/**
 * Render the Meta Box fields
 */
function new_aaedt_render_info_images_meta_box( $post ) {
  // Add nonce for security
  wp_nonce_field( 'new_aaedt_save_info_images', 'new_aaedt_info_images_nonce' );

  // Retrieve existing meta values (image attachment IDs)
  $section_1 = get_post_meta( $post->ID, '_new_aaedt_section_1', true );
  $section_2 = get_post_meta( $post->ID, '_new_aaedt_section_2', true );
  $section_3 = get_post_meta( $post->ID, '_new_aaedt_section_3', true );
  $section_4 = get_post_meta( $post->ID, '_new_aaedt_section_4', true );
  $section_5 = get_post_meta( $post->ID, '_new_aaedt_section_5', true );

  $fields = array(
    'section_1' => array( 'label' => __( '區塊圖片 1 (Block 1 Image)', 'new-aaedt-theme' ), 'value' => $section_1 ),
    'section_2' => array( 'label' => __( '區塊圖片 2 (Block 2 Image)', 'new-aaedt-theme' ), 'value' => $section_2 ),
    'section_3' => array( 'label' => __( '區塊圖片 3 (Block 3 Image)', 'new-aaedt-theme' ), 'value' => $section_3 ),
    'section_4' => array( 'label' => __( '區塊圖片 4 (Block 4 Image)', 'new-aaedt-theme' ), 'value' => $section_4 ),
    'section_5' => array( 'label' => __( '區塊圖片 5 (Block 5 Image)', 'new-aaedt-theme' ), 'value' => $section_5 ),
  );

  echo '<table class="form-table">';
  foreach ( $fields as $key => $field ) {
    $img_url = $field['value'] ? wp_get_attachment_image_url( $field['value'], 'medium' ) : '';
    ?>
    <tr style="border-bottom: 1px solid #eee;">
      <th scope="row" style="width: 250px;"><label style="font-weight: 600;"><?php echo esc_html( $field['label'] ); ?></label></th>
      <td>
        <div class="new-aaedt-meta-image-wrapper" id="wrapper-<?php echo esc_attr( $key ); ?>">
          <div class="preview-area" style="margin-bottom: 10px;">
            <?php if ( $img_url ) : ?>
              <img src="<?php echo esc_url( $img_url ); ?>" style="max-width: 200px; height: auto; border: 1px solid #ccc; display: block;" />
            <?php else : ?>
              <span style="color: #999; font-style: italic;"><?php _e( '尚未選擇圖片', 'new-aaedt-theme' ); ?></span>
            <?php endif; ?>
          </div>
          <input type="hidden" name="<?php echo esc_attr( $key ); ?>" id="<?php echo esc_attr( $key ); ?>" value="<?php echo esc_attr( $field['value'] ); ?>" />
          <button type="button" class="button new-aaedt-upload-btn" data-field="<?php echo esc_attr( $key ); ?>"><?php _e( '選擇/上傳圖片 (Select Image)', 'new-aaedt-theme' ); ?></button>
          <button type="button" class="button new-aaedt-remove-btn" data-field="<?php echo esc_attr( $key ); ?>" style="margin-left: 5px; color: #b32d2e; border-color: #b32d2e; <?php echo $field['value'] ? '' : 'display:none;'; ?>"><?php _e( '移除圖片', 'new-aaedt-theme' ); ?></button>
        </div>
      </td>
    </tr>
    <?php
  }
  echo '</table>';

  // Inline JavaScript for media uploader handling
  ?>
  <script>
  jQuery(document).ready(function($){
    $('.new-aaedt-upload-btn').click(function(e) {
      e.preventDefault();
      var button = $(this);
      var fieldId = button.data('field');
      var wrapper = $('#wrapper-' + fieldId);
      
      var custom_uploader = wp.media({
        title: '<?php _e( '選擇或上傳圖片', 'new-aaedt-theme' ); ?>',
        button: { text: '<?php _e( '使用此圖片', 'new-aaedt-theme' ); ?>' },
        multiple: false
      }).on('select', function() {
        var attachment = custom_uploader.state().get('selection').first().toJSON();
        wrapper.find('input[type="hidden"]').val(attachment.id);
        
        var imgHtml = '<img src="' + (attachment.sizes.medium ? attachment.sizes.medium.url : attachment.url) + '" style="max-width: 200px; height: auto; border: 1px solid #ccc; display: block;" />';
        wrapper.find('.preview-area').html(imgHtml);
        wrapper.find('.new-aaedt-remove-btn').show();
      }).open();
    });

    $('.new-aaedt-remove-btn').click(function(e) {
      e.preventDefault();
      var button = $(this);
      var fieldId = button.data('field');
      var wrapper = $('#wrapper-' + fieldId);
      
      wrapper.find('input[type="hidden"]').val('');
      wrapper.find('.preview-area').html('<span style="color: #999; font-style: italic;"><?php _e( '尚未選擇圖片', 'new-aaedt-theme' ); ?></span>');
      button.hide();
    });
  });
  </script>
  <?php
}

/**
 * Save Meta Box Values
 */
function new_aaedt_save_info_images_meta( $post_id ) {
  // Check security nonce
  if ( ! isset( $_POST['new_aaedt_info_images_nonce'] ) || ! wp_verify_nonce( $_POST['new_aaedt_info_images_nonce'], 'new_aaedt_save_info_images' ) ) {
    return;
  }

  // Avoid autosave
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
    return;
  }

  // Check user permissions
  if ( isset( $_POST['post_type'] ) && 'page' === $_POST['post_type'] ) {
    if ( ! current_user_can( 'edit_page', $post_id ) ) {
      return;
    }
  } else {
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
      return;
    }
  }

  $fields = array( 'section_1', 'section_2', 'section_3', 'section_4', 'section_5' );
  foreach ( $fields as $field ) {
    if ( isset( $_POST[ $field ] ) ) {
      update_post_meta( $post_id, '_new_aaedt_' . $field, sanitize_text_field( $_POST[ $field ] ) );
    }
  }
}
add_action( 'save_post', 'new_aaedt_save_info_images_meta' );

/**
 * Enqueue Media Scripts in Admin Panel
 */
function new_aaedt_enqueue_admin_media( $hook ) {
  global $post;
  if ( ( 'post.php' === $hook || 'post-new.php' === $hook ) && $post && 'page' === $post->post_type ) {
    $template = get_post_meta( $post->ID, '_wp_page_template', true );
    if ( 't_informational.php' === $template ) {
      wp_enqueue_media();
    }
  }
}
add_action( 'admin_enqueue_scripts', 'new_aaedt_enqueue_admin_media' );

/**
 * Remove default paragraph wrapper filters from the_content
 * Note: Commented out to restore paragraph and line-break structure created in WP Admin.
 */
// remove_filter( 'the_content', 'wpautop' );

/**
 * Custom Nav Menu Walker to output AAEDT accessible dropdown structures
 */
class New_Aaedt_Nav_Walker extends Walker_Nav_Menu {
  // Start Level (for sub-menu ul)
  public function start_lvl( &$output, $depth = 0, $args = null ) {
    $indent = str_repeat( "\t", $depth );
    $output .= "\n$indent<ul class=\"nav-dropdown\">\n";
  }

  // Start Element
  public function start_el( &$output, $data_object, $depth = 0, $args = null, $current_object_id = 0 ) {
    $menu_item = $data_object;
    $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

    $classes = empty( $menu_item->classes ) ? array() : (array) $menu_item->classes;
    
    // Add "nav" class only at top level (depth 0)
    if ( $depth === 0 ) {
      $classes[] = 'nav';
    }

    $class_names = implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $menu_item, $args, $depth ) );
    $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

    $output .= $indent . '<li' . $class_names . '>';

    $atts = array();
    $atts['target'] = ! empty( $menu_item->target )     ? $menu_item->target     : '';
    $atts['rel']    = ! empty( $menu_item->xfn )        ? $menu_item->xfn        : '';
    $atts['href']   = ! empty( $menu_item->url )        ? $menu_item->url        : '';

    $atts = apply_filters( 'nav_menu_link_attributes', $atts, $menu_item, $args, $depth );

    $attributes = '';
    foreach ( $atts as $attr => $value ) {
      if ( ! empty( $value ) ) {
        $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
        $attributes .= ' ' . $attr . '="' . $value . '"';
      }
    }

    $title = apply_filters( 'the_title', $menu_item->title, $menu_item->ID );

    // Check if this menu item has children (for rendering the dropdown button trigger)
    $has_children = in_array( 'menu-item-has-children', $classes ) || ( isset( $args->walker->has_children ) && $args->walker->has_children );

    if ( $depth === 0 && $has_children ) {
      $item_output = $args->before;
      $item_output .= '<button class="nav-dropdown-button" aria-expanded="false">';
      $item_output .= $args->link_before . $title . $args->link_after;
      $item_output .= '<span class="icon-arrow" aria-hidden="true"></span>';
      $item_output .= '</button>';
      $item_output .= $args->after;
    } else {
      $link_class = ( $depth > 0 ) ? 'nav-dropdown-item' : 'nav-link';
      $item_output = $args->before;
      $item_output .= '<a class="' . esc_attr( $link_class ) . '"' . $attributes . '>';
      $item_output .= $args->link_before . $title . $args->link_after;
      $item_output .= '</a>';
      $item_output .= $args->after;
    }

    $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $menu_item, $depth, $args );
  }
}

/**
 * Register "合作夥伴" (Partners) Custom Post Type
 */
function new_aaedt_register_partners_cpt() {
  $labels = array(
    'name'                  => _x( '合作夥伴', 'Post Type General Name', 'new-aaedt-theme' ),
    'singular_name'         => _x( '合作夥伴', 'Post Type Singular Name', 'new-aaedt-theme' ),
    'menu_name'             => __( '合作夥伴', 'new-aaedt-theme' ),
    'name_admin_bar'        => __( '合作夥伴', 'new-aaedt-theme' ),
    'archives'              => __( '合作夥伴封存', 'new-aaedt-theme' ),
    'attributes'            => __( '合作夥伴屬性', 'new-aaedt-theme' ),
    'parent_item_colon'     => __( '父級合作夥伴：', 'new-aaedt-theme' ),
    'all_items'             => __( '所有合作夥伴', 'new-aaedt-theme' ),
    'add_new_item'          => __( '新增合作夥伴', 'new-aaedt-theme' ),
    'add_new'               => __( '新增', 'new-aaedt-theme' ),
    'new_item'              => __( '新合作夥伴', 'new-aaedt-theme' ),
    'edit_item'             => __( '編輯合作夥伴', 'new-aaedt-theme' ),
    'update_item'           => __( '更新合作夥伴', 'new-aaedt-theme' ),
    'view_item'             => __( '檢視合作夥伴', 'new-aaedt-theme' ),
    'view_items'            => __( '檢視所有合作夥伴', 'new-aaedt-theme' ),
    'search_items'          => __( '搜尋合作夥伴', 'new-aaedt-theme' ),
    'not_found'             => __( '找不到合作夥伴', 'new-aaedt-theme' ),
    'not_found_in_trash'    => __( '垃圾桶中找不到合作夥伴', 'new-aaedt-theme' ),
    'featured_image'        => __( '精選圖片', 'new-aaedt-theme' ),
    'set_featured_image'    => __( '設定精選圖片', 'new-aaedt-theme' ),
    'remove_featured_image' => __( '移除精選圖片', 'new-aaedt-theme' ),
    'use_featured_image'    => __( '設為精選圖片', 'new-aaedt-theme' ),
    'insert_into_item'      => __( '插入至合作夥伴', 'new-aaedt-theme' ),
    'uploaded_to_this_item' => __( '上傳至此合作夥伴', 'new-aaedt-theme' ),
    'items_list'            => __( '合作夥伴清單', 'new-aaedt-theme' ),
    'items_list_navigation' => __( '合作夥伴清單導覽', 'new-aaedt-theme' ),
    'filter_items_list'     => __( '篩選合作夥伴清單', 'new-aaedt-theme' ),
  );

  $args = array(
    'label'                 => __( '合作夥伴', 'new-aaedt-theme' ),
    'description'           => __( '合作夥伴組織或企業介紹', 'new-aaedt-theme' ),
    'labels'                => $labels,
    'supports'              => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ),
    'hierarchical'          => false,
    'public'                => true,
    'show_ui'               => true,
    'show_in_menu'          => true,
    'menu_position'         => 25,
    'menu_icon'             => 'dashicons-groups', // Icon showing group of people
    'show_in_nav_menus'     => true,
    'can_export'            => true,
    'has_archive'           => true,
    'exclude_from_search'   => false,
    'publicly_queryable'    => true,
    'capability_type'       => 'post',
    'show_in_rest'          => true, // Supports Gutenberg block editor
  );

  register_post_type( 'partners', $args );
  flush_rewrite_rules();
}
add_action( 'init', 'new_aaedt_register_partners_cpt', 0 );

/**
 * Enable SVG Uploads in WordPress Media Library
 */
function new_aaedt_enable_svg_uploads( $mimes ) {
  $mimes['svg']  = 'image/svg+xml';
  $mimes['svgz'] = 'image/svg+xml';
  return $mimes;
}
add_filter( 'upload_mimes', 'new_aaedt_enable_svg_uploads' );

/**
 * Fix SVG upload validation check issues in WordPress 4.7.1+
 */
function new_aaedt_check_svg_filetype( $data, $file, $filename, $mimes ) {
  $filetype = wp_check_filetype( $filename, $mimes );
  $ext      = $filetype['ext'];
  $type     = $filetype['type'];
  
  if ( in_array( $ext, array( 'svg', 'svgz' ) ) ) {
    $data['ext']  = $ext;
    $data['type'] = $type;
  }
  
  return $data;
}
add_filter( 'wp_check_filetype_and_ext', 'new_aaedt_check_svg_filetype', 10, 4 );

/**
 * Sanitize uploaded filenames to prevent UTF-8 filename errors on Windows/XAMPP servers
 */
function new_aaedt_sanitize_windows_upload_filenames( $filename ) {
  $info = pathinfo( $filename );
  $ext  = empty( $info['extension'] ) ? '' : '.' . $info['extension'];
  $name = $info['filename'];

  // Check if filename contains non-ASCII characters (e.g., Chinese characters)
  if ( preg_match( '/[^\x20-\x7E]/', $name ) ) {
    // Generate a unique md5 hash based on the name + time
    $name = md5( $name . time() );
  }

  return $name . $ext;
}
add_filter( 'sanitize_file_name', 'new_aaedt_sanitize_windows_upload_filenames', 10 );





