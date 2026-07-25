<?php
/**
 * Template Name: 主頁
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package AAEDT
 */

get_header();
?>
      <main class="main index_main mobile_gap_40px" id="main-content">
        <a
          href="#C"
          title="中央內容區塊"
          id="AC"
          accesskey="C"
          name="C"
          class="sr-only sr-only-focusable"
        >
          <span class="sr-only">中央內容區塊</span>
          <span aria-hidden="true">:::</span>
        </a>
        <h1 class="sr-only">首頁</h1>
        <section class="hero-section mobile_margin_bottom_40px">
          <!-- 這裡的 alt 要比較描述 (it needs to be more descriptive)，因為這有代表協會的相關的含意，更詳細可能要和立婷確認，其實 Copilot 現在可以給的 alt text 還滿好的 -->
          <div class="section_1280px">
            <div class="section_1040px gap_20px">
              <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                <?php
                // Retrieve ACF homepage-carousel group fields
                $carousel_images = array();
                if ( function_exists( 'get_field' ) ) {
                  $homepage_carousel = get_field( 'homepage-carousel' );
                  if ( $homepage_carousel ) {
                    for ( $i = 1; $i <= 4; $i++ ) {
                      $img_field = isset( $homepage_carousel[ 'image' . $i ] ) ? $homepage_carousel[ 'image' . $i ] : null;
                      if ( ! empty( $img_field ) ) {
                        $img_url  = '';
                        $img_alt  = '';
                        
                        // Handle different ACF Image field return formats (Array, ID, or URL)
                        if ( is_array( $img_field ) ) {
                          $img_url = isset( $img_field['url'] ) ? $img_field['url'] : '';
                          $img_alt = ! empty( $img_field['alt'] ) ? $img_field['alt'] : ( isset( $img_field['title'] ) ? $img_field['title'] : '' );
                        } elseif ( is_numeric( $img_field ) ) {
                          $img_url = wp_get_attachment_image_url( $img_field, 'full' );
                          $img_alt = get_post_meta( $img_field, '_wp_attachment_image_alt', true );
                        } elseif ( is_string( $img_field ) ) {
                          $img_url = $img_field;
                        }
                        
                        if ( ! empty( $img_url ) ) {
                          $carousel_images[] = array(
                            'url' => $img_url,
                            'alt' => $img_alt,
                          );
                        }
                      }
                    }
                  }
                }
                ?>
                <ol class="carousel-indicators">
                  <?php if ( ! empty( $carousel_images ) ) : ?>
                    <?php foreach ( $carousel_images as $index => $image ) : ?>
                      <li
                        data-target="#carouselExampleIndicators"
                        data-slide-to="<?php echo esc_attr( $index ); ?>"
                        class="<?php echo $index === 0 ? 'active' : ''; ?>"
                      ><span class="sr-only">輪播圖片<?php echo $index + 1; ?></span></li>
                    <?php endforeach; ?>
                  <?php else : ?>
                    <?php for ( $i = 0; $i < 8; $i++ ) : ?>
                      <li
                        data-target="#carouselExampleIndicators"
                        data-slide-to="<?php echo esc_attr( $i ); ?>"
                        class="<?php echo $i === 0 ? 'active' : ''; ?>"
                      ></li>
                    <?php endfor; ?>
                  <?php endif; ?>
                </ol>
                <div class="carousel-inner">
                  <?php if ( ! empty( $carousel_images ) ) : ?>
                    <?php foreach ( $carousel_images as $index => $image ) : ?>
                      <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                        <picture>
                          <img
                            class="d-block w-100"
                            src="<?php echo esc_url( $image['url'] ); ?>"
                            alt="<?php echo esc_attr( ! empty( $image['alt'] ) ? $image['alt'] : 'AAEDT 可及環境設計協會 Banner ' . ($index + 1) ); ?>"
                          />
                        </picture>
                      </div>
                    <?php endforeach; ?>
                  <?php else : ?>
                    <?php
                    // Fallback to static mockup banners using get_theme_file_uri
                    $fallback_banners = array(
                      array( 'desktop' => 'public/img/banner/Frame1.svg', 'mobile' => 'public/img/banner/mobile/Frame1.svg', 'alt' => 'AAEDT 可及環境設計協會 Banner 1' ),
                      array( 'desktop' => 'public/img/banner/Frame2.svg', 'mobile' => 'public/img/banner/mobile/Frame2.svg', 'alt' => 'AAEDT 可及環境設計協會 Banner 2' ),
                      array( 'desktop' => 'public/img/banner/Frame3.svg', 'mobile' => 'public/img/banner/mobile/Frame3.svg', 'alt' => 'AAEDT 可及環境設計協會 Banner 3' ),
                      array( 'desktop' => 'public/img/banner/Frame4.svg', 'mobile' => 'public/img/banner/mobile/Frame4.svg', 'alt' => 'AAEDT 可及環境設計協會 Banner 4' ),
                      array( 'desktop' => 'public/img/banner/Frame5.svg', 'mobile' => 'public/img/banner/mobile/Frame5.svg', 'alt' => 'AAEDT 可及環境設計協會 Banner 5' ),
                      array( 'desktop' => 'public/img/banner/Frame6.svg', 'mobile' => 'public/img/banner/mobile/Frame6.svg', 'alt' => 'AAEDT 可及環境設計協會 Banner 6' ),
                      array( 'desktop' => 'public/img/banner/Frame7.svg', 'mobile' => 'public/img/banner/mobile/Frame7.svg', 'alt' => 'AAEDT 可及環境設計協會 Banner 7' ),
                      array( 'desktop' => 'public/img/banner/Frame8.svg', 'mobile' => 'public/img/banner/mobile/Frame8.svg', 'alt' => 'AAEDT 可及環境設計協會 Banner 8' ),
                    );
                    foreach ( $fallback_banners as $index => $banner ) :
                      ?>
                      <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                        <picture>
                          <source
                            media="(max-width: 768px)"
                            srcset="<?php echo esc_url( get_theme_file_uri( $banner['mobile'] ) ); ?>"
                          />
                          <img
                            class="d-block w-100"
                            src="<?php echo esc_url( get_theme_file_uri( $banner['desktop'] ) ); ?>"
                            alt="<?php echo esc_attr( $banner['alt'] ); ?>"
                          />
                        </picture>
                      </div>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </div>
                <a
                  class="carousel-control-prev"
                  href="#carouselExampleIndicators"
                  role="button"
                  data-slide="prev"
                >
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="sr-only">上一張圖</span>
                </a>
                <a
                  class="carousel-control-next"
                  href="#carouselExampleIndicators"
                  role="button"
                  data-slide="next"
                >
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="sr-only">下一張圖</span>
                </a>
                <button class="carousel-control-play is-paused" id="carouselPlayBtn" aria-label="開始輪播">
                  <!-- pause icon（預設播放中，顯示暫停） -->
                  <svg class="icon-pause" width="14" height="16" viewBox="0 0 14 16" fill="none" aria-hidden="true">
                    <rect x="0" y="0" width="4" height="16" rx="1.5" fill="#534c46"/>
                    <rect x="10" y="0" width="4" height="16" rx="1.5" fill="#534c46"/>
                  </svg>
                  <!-- play icon（暫停中，顯示播放） -->
                  <svg class="icon-play" width="14" height="16" viewBox="0 0 14 16" fill="none" aria-hidden="true">
                    <path d="M1 1L13 8L1 15V1Z" fill="#534c46" stroke="#534c46" stroke-width="1.5" stroke-linejoin="round"/>
                  </svg>
                </button>
              </div>
              <!-- <img
                class="hero-img"
                src="img/hero/hero.svg"
                alt="可及協會在環境不要障礙的活動時的團體照，總共12位成員，每個人帶著笑容並拿著綠色盆栽一起提倡環境不要障礙。"
              /> -->
              <?php
              // Retrieve ACF three-cards group fields
              $cards_data = array();
              $default_cards = array(
                1 => array(
                  'title'       => '我要改善環境',
                  'description' => '從居家到公共空間，我們提供專業的檢測與改善服務，讓每個人都能安心使用。',
                  'link'        => home_url( '/remodeling/' ),
                  'background'  => get_theme_file_uri( 'public/img/banner/Homepage_Card01.svg' ),
                ),
                2 => array(
                  'title'       => '我想邀約演講',
                  'description' => '邀請我們的專業講師到現場分享，讓更多人了解『可及設計』的理念與實踐。',
                  'link'        => home_url( '/lectures/' ),
                  'background'  => get_theme_file_uri( 'public/img/banner/Homepage_Card02.svg' ),
                ),
                3 => array(
                  'title'       => '我想參加活動',
                  'description' => '參加課程、工作坊、講座或參展，親身理解『可及設計』，和大家一起學習、分享。',
                  'link'        => home_url( '/news/' ),
                  'background'  => get_theme_file_uri( 'public/img/banner/Homepage_Card03.svg' ),
                ),
              );

              if ( function_exists( 'get_field' ) ) {
                $three_cards = get_field( 'three-cards' );
                for ( $i = 1; $i <= 3; $i++ ) {
                  $card_title = ! empty( $three_cards[ 'card' . $i . '-title' ] ) ? $three_cards[ 'card' . $i . '-title' ] : '';
                  $card_desc  = ! empty( $three_cards[ 'card' . $i . '-description' ] ) ? $three_cards[ 'card' . $i . '-description' ] : '';
                  $card_link  = ! empty( $three_cards[ 'card' . $i . '-link' ] ) ? $three_cards[ 'card' . $i . '-link' ] : '';
                  $card_bg    = isset( $three_cards[ 'card' . $i . '-background' ] ) ? $three_cards[ 'card' . $i . '-background' ] : null;
                  
                  $bg_url = '';
                  if ( ! empty( $card_bg ) ) {
                    if ( is_array( $card_bg ) ) {
                      $bg_url = isset( $card_bg['url'] ) ? $card_bg['url'] : '';
                    } elseif ( is_numeric( $card_bg ) ) {
                      $bg_url = wp_get_attachment_image_url( $card_bg, 'full' );
                    } elseif ( is_string( $card_bg ) ) {
                      $bg_url = $card_bg;
                    }
                  }
                  
                  $cards_data[$i] = array(
                    'title'       => ! empty( $card_title ) ? $card_title : $default_cards[$i]['title'],
                    'description' => ! empty( $card_desc ) ? $card_desc : $default_cards[$i]['description'],
                    'link'        => ! empty( $card_link ) ? $card_link : $default_cards[$i]['link'],
                    'background'  => ! empty( $bg_url ) ? $bg_url : $default_cards[$i]['background'],
                  );
                }
              } else {
                $cards_data = $default_cards;
              }
              ?>
              <div class="card-container mobile_padding_left_right_20px">
                <?php foreach ( $cards_data as $i => $card ) : ?>
                  <a href="<?php echo esc_url( $card['link'] ); ?>" class="feature-card">
                    <div class="action-card action-card--<?php echo $i; ?>" style="background-image: url('<?php echo esc_url( $card['background'] ); ?>');">
                      <div class="text-wrapper-2"><?php echo esc_html( $card['title'] ); ?></div>
                      <div class="text-wrapper-3">
                        <?php echo esc_html( $card['description'] ); ?>
                      </div>
                    </div>
                  </a>
                <?php endforeach; ?>
              </div>
            </div>
          </div>
        </section>

        <?php
        // Retrieve ACF section1 group fields
        $sec1_title      = '每一步努力，都是為了讓環境更友善';
        $sec1_desc       = '了解協會的使命與推廣行動，認識我們如何從環境到數位，持續推動可及的未來。';
        $sec1_cta_text   = '認識我們';
        $sec1_cta_url    = home_url( '/about/' );
        $sec1_cta_target = '';
        $sec1_img_url    = 'https://c.animaapp.com/mkudp988xLWCmu/img/-----2025-09-23-21-09-13-1.png';

        if ( function_exists( 'get_field' ) ) {
          $section1 = get_field( 'section1' );
          if ( $section1 ) {
            if ( ! empty( $section1['section1-title'] ) ) {
              $sec1_title = $section1['section1-title'];
            }
            if ( ! empty( $section1['section1-description'] ) ) {
              $sec1_desc = $section1['section1-description'];
            }
            if ( ! empty( $section1['section1-cta-text'] ) ) {
              $sec1_cta_text = $section1['section1-cta-text'];
            }
            
            // Link field (ACF Link type)
            if ( ! empty( $section1['section1-cta-link'] ) ) {
              $cta_link = $section1['section1-cta-link'];
              if ( is_array( $cta_link ) ) {
                $sec1_cta_url    = isset( $cta_link['url'] ) ? $cta_link['url'] : $sec1_cta_url;
                $sec1_cta_target = isset( $cta_link['target'] ) ? $cta_link['target'] : '';
                if ( empty( $section1['section1-cta-text'] ) && ! empty( $cta_link['title'] ) ) {
                  $sec1_cta_text = $cta_link['title'];
                }
              } elseif ( is_string( $cta_link ) ) {
                $sec1_cta_url = $cta_link;
              }
            }
            
            // Image field
            if ( ! empty( $section1['section1-img'] ) ) {
              $img_field = $section1['section1-img'];
              if ( is_array( $img_field ) ) {
                $sec1_img_url = isset( $img_field['url'] ) ? $img_field['url'] : '';
              } elseif ( is_numeric( $img_field ) ) {
                $sec1_img_url = wp_get_attachment_image_url( $img_field, 'full' );
              } elseif ( is_string( $img_field ) ) {
                $sec1_img_url = $img_field;
              }
            }
          }
        }
        ?>
        <section class="about-us-section mobile_margin_bottom_40px">
          <div class="section_1280px">
            <div class="section_1040px gap_40px mobile_padding_left_right_20px mobile_gap_20px">
              <div class="title-group">
                <h2 class="main-title"><?php echo esc_html( $sec1_title ); ?></h2>
                <div class="title-line-bg"></div>
              </div>
              <div class="frame-6">
                <div class="frame-7">
                  <div class="frame-8">
                      <?php echo wp_kses_post( $sec1_desc ); ?>
                  </div>
                  <a href="<?php echo esc_url( $sec1_cta_url ); ?>" class="button"<?php echo ! empty( $sec1_cta_target ) ? ' target="' . esc_attr( $sec1_cta_target ) . '"' : ''; ?>>
                    <span class="text-wrapper-10"><?php echo esc_html( $sec1_cta_text ); ?></span>
                    <img class="button-arrow" src="<?php echo esc_url( get_theme_file_uri( 'public/img/arrow-right.svg' ) ); ?>" alt="" aria-hidden="true" />
                  </a>
                </div>
                <div class="frame-9" style="background-image: url('<?php echo esc_url( $sec1_img_url ); ?>');"></div>
              </div>
            </div>
          </div>
        </section>

        <?php
        // Retrieve ACF section2 group fields
        $sec2_title      = '推廣行動';
        $sec2_desc       = '從居家改善到社區推廣，AAEDT 積極推動不同計畫，<br />讓可及設計更貼近生活。';
        $sec2_cta_text   = '更多活動';
        $sec2_cta_url    = home_url( '/campaign/' );
        $sec2_cta_target = '';

        $default_outreach_cards = array(
          1 => array(
            'title' => '長照2.0居家環境改造',
            'link'  => 'https://www.google.com/',
            'img'   => get_theme_file_uri( 'public/img/outreach/2025-09-23-21-06-04-1.png' ),
            'tag'   => '改善環境',
          ),
          2 => array(
            'title' => '公共空間無障礙環境改善',
            'link'  => '#',
            'img'   => get_theme_file_uri( 'public/img/outreach/2025-09-23-21-06-48-1.png' ),
            'tag'   => '改善環境',
          ),
          3 => array(
            'title' => '可及性設計理念教育推廣',
            'link'  => '#',
            'img'   => get_theme_file_uri( 'public/img/outreach/2025-09-23-21-06-48-1-1.png' ),
            'tag'   => '改善環境',
          ),
        );

        $outreach_cards = array();

        if ( function_exists( 'get_field' ) ) {
          $section2 = get_field( 'section2' );
          if ( $section2 ) {
            if ( ! empty( $section2['section2-title'] ) ) {
              $sec2_title = $section2['section2-title'];
            }
            if ( ! empty( $section2['section2-description'] ) ) {
              $sec2_desc = $section2['section2-description'];
            }
            if ( ! empty( $section2['section2-cta-text'] ) ) {
              $sec2_cta_text = $section2['section2-cta-text'];
            }
            
            // Link field
            if ( ! empty( $section2['section2-cta-link'] ) ) {
              $cta_link = $section2['section2-cta-link'];
              if ( is_array( $cta_link ) ) {
                $sec2_cta_url    = isset( $cta_link['url'] ) ? $cta_link['url'] : $sec2_cta_url;
                $sec2_cta_target = isset( $cta_link['target'] ) ? $cta_link['target'] : '';
                if ( empty( $section2['section2-cta-text'] ) && ! empty( $cta_link['title'] ) ) {
                  $sec2_cta_text = $cta_link['title'];
                }
              } elseif ( is_string( $cta_link ) ) {
                $sec2_cta_url = $cta_link;
              }
            }
            
            // Post Objects
            for ( $i = 1; $i <= 3; $i++ ) {
              $post_field = isset( $section2[ 'landing-section2-card' . $i ] ) ? $section2[ 'landing-section2-card' . $i ] : null;
              if ( $post_field ) {
                $post_obj = get_post( $post_field );
                if ( $post_obj ) {
                  $categories = get_the_category( $post_obj->ID );
                  $tag = ! empty( $categories ) ? $categories[0]->name : '改善環境';
                  
                  $img_url = get_the_post_thumbnail_url( $post_obj->ID, 'full' );
                  if ( empty( $img_url ) ) {
                    $img_url = $default_outreach_cards[$i]['img'];
                  }
                  
                  $outreach_cards[$i] = array(
                    'title' => get_the_title( $post_obj->ID ),
                    'link'  => get_permalink( $post_obj->ID ),
                    'img'   => $img_url,
                    'tag'   => $tag,
                  );
                }
              }
              
              if ( empty( $outreach_cards[$i] ) ) {
                $outreach_cards[$i] = $default_outreach_cards[$i];
              }
            }
          }
        }

        if ( empty( $outreach_cards ) ) {
          $outreach_cards = $default_outreach_cards;
        }
        ?>
        <section class="outreach-section arc-top arc-bottom">
          <div class="content-section campaign_overview_section section_1280px">
            <div class="section_1040px gap_40px mobile_padding_left_right_20px">
              <div class="page-header mobile_gap_20px">
                <div class="title-group">
                  <h2 class="main-title"><?php echo esc_html( $sec2_title ); ?></h2>
                  <div class="title-line-bg"></div>
                </div>
                <div class="intro-group">
                  <h3 class="sub-title">我們正在努力的方向</h3>
                  <div class="intro-text">
                    <?php echo wp_kses_post( $sec2_desc ); ?>
                  </div>
                </div>
              </div>
              <div class="frame-13">
                <?php
                $card_wrapper_classes = array(
                  1 => 'frame-14 card',
                  2 => 'frame-17 card',
                  3 => 'frame-18 card',
                );
                $card_inner_classes = array(
                  1 => 'frame-15',
                  2 => 'frame-15 card',
                  3 => 'frame-15 card',
                );
                
                foreach ( $outreach_cards as $i => $card ) :
                  ?>
                  <div class="<?php echo esc_attr( $card_wrapper_classes[$i] ); ?>">
                    <div class="element-wrapper">
                      <img
                        class="element-2"
                        src="<?php echo esc_url( $card['img'] ); ?>"
                        alt="<?php echo esc_attr( $card['title'] ); ?>"
                      />
                    </div>
                    <div class="<?php echo esc_attr( $card_inner_classes[$i] ); ?>">
                      <div class="card-meeting-tag-wrap">
                        <span class="tag"><?php echo esc_html( $card['tag'] ); ?></span>
                      </div>
                      <h3 class="text-wrapper-9">
                        <a href="<?php echo esc_url( $card['link'] ); ?>"><?php echo esc_html( $card['title'] ); ?></a>
                      </h3>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
              <div class="button-wrapper mobile_center">
                <a href="<?php echo esc_url( $sec2_cta_url ); ?>" class="button"<?php echo ! empty( $sec2_cta_target ) ? ' target="' . esc_attr( $sec2_cta_target ) . '"' : ''; ?>>
                  <span class="text-wrapper-10"><?php echo esc_html( $sec2_cta_text ); ?></span>
                  <img class="button-arrow" src="<?php echo esc_url( get_theme_file_uri( 'public/img/arrow-right.svg' ) ); ?>" alt="" aria-hidden="true" />
                </a>
              </div>
            </div>
          </div>
        </section>

        <?php
        // Retrieve ACF section3 group fields
        $sec3_title      = '支持協會，讓改變發生。改善環境需要每一份力量。捐款、志工或合作提案，都是推動可及設計的重要支持。';
        $sec3_desc       = '本會帳號： 國泰世華銀行台中分行(代碼：013)<br />帳號：006-03-500889-4<br />戶名：台灣可及環境設計協會張華蓀';
        $sec3_cta_text   = '支持我們';
        $sec3_cta_url    = home_url( '/donate/' );
        $sec3_cta_target = '';
        $sec3_img_url    = 'https://c.animaapp.com/mkudp988xLWCmu/img/-----2025-09-23-21-10-39-1.png';

        if ( function_exists( 'get_field' ) ) {
          $section3 = get_field( 'section3' );
          if ( $section3 ) {
            if ( ! empty( $section3['section3-title'] ) ) {
              $sec3_title = $section3['section3-title'];
            }
            if ( ! empty( $section3['section3-description'] ) ) {
              $sec3_desc = $section3['section3-description'];
            }
            if ( ! empty( $section3['section3-cta-text'] ) ) {
              $sec3_cta_text = $section3['section3-cta-text'];
            }
            
            // Link field
            if ( ! empty( $section3['section3-cta-link'] ) ) {
              $cta_link = $section3['section3-cta-link'];
              if ( is_array( $cta_link ) ) {
                $sec3_cta_url    = isset( $cta_link['url'] ) ? $cta_link['url'] : $sec3_cta_url;
                $sec3_cta_target = isset( $cta_link['target'] ) ? $cta_link['target'] : '';
                if ( empty( $section3['section3-cta-text'] ) && ! empty( $cta_link['title'] ) ) {
                  $sec3_cta_text = $cta_link['title'];
                }
              } elseif ( is_string( $cta_link ) ) {
                $sec3_cta_url = $cta_link;
              }
            }
            
            // Image field
            if ( ! empty( $section3['section3-img'] ) ) {
              $img_field = $section3['section3-img'];
              if ( is_array( $img_field ) ) {
                $sec3_img_url = isset( $img_field['url'] ) ? $img_field['url'] : '';
              } elseif ( is_numeric( $img_field ) ) {
                $sec3_img_url = wp_get_attachment_image_url( $img_field, 'full' );
              } elseif ( is_string( $img_field ) ) {
                $sec3_img_url = $img_field;
              }
            }
          }
        }
        ?>
        <section class="donate-section mobile_margin_top_40px mobile_margin_bottom_40px">
          <div class="section_1280px">
            <div class="section_1040px gap_40px mobile_padding_left_right_20px mobile_gap_20px">
              <div class="title-group">
                <h2 class="main-title"><?php echo esc_html( $sec3_title ); ?></h2>
                <div class="title-line-bg"></div>
              </div>
              <div class="frame-6">
                <div class="frame-7">
                  <div class="frame-8">
                    <?php echo wp_kses_post( $sec3_desc ); ?>
                  </div>
                  <a href="<?php echo esc_url( $sec3_cta_url ); ?>" class="button"<?php echo ! empty( $sec3_cta_target ) ? ' target="' . esc_attr( $sec3_cta_target ) . '"' : ''; ?>>
                    <span class="text-wrapper-10"><?php echo esc_html( $sec3_cta_text ); ?></span>
                    <img class="button-arrow" src="<?php echo esc_url( get_theme_file_uri( 'public/img/arrow-right.svg' ) ); ?>" alt="" aria-hidden="true" />
                  </a>
                </div>
                <div class="frame-19" style="background-image: url('<?php echo esc_url( $sec3_img_url ); ?>');"></div>
              </div>
            </div>
          </div>
        </section>

        <?php
        // Retrieve ACF section4 group fields
        $sec4_title     = '媒體專區';
        $sec4_video_url = 'https://www.youtube.com/embed/IfVTo_PWc7Q?si=tLvN_a6t4mKbyhkv';
        $sec4_desc      = '影片說明目前尚未填寫，請至後台編輯填寫。';

        if ( function_exists( 'get_field' ) ) {
          $section4 = get_field( 'section4' );
          if ( $section4 ) {
            if ( ! empty( $section4['section4-title'] ) ) {
              $sec4_title = $section4['section4-title'];
            }
            if ( ! empty( $section4['section4-video-url'] ) ) {
              $raw_video_url = $section4['section4-video-url'];
              if ( strpos( $raw_video_url, 'youtube.com/watch?v=' ) !== false ) {
                $parts = parse_url( $raw_video_url );
                if ( isset( $parts['query'] ) ) {
                  parse_str( $parts['query'], $query );
                  if ( isset( $query['v'] ) ) {
                    $sec4_video_url = 'https://www.youtube.com/embed/' . $query['v'];
                  }
                }
              } elseif ( strpos( $raw_video_url, 'youtu.be/' ) !== false ) {
                $path = parse_url( $raw_video_url, PHP_URL_PATH );
                $sec4_video_url = 'https://www.youtube.com/embed/' . ltrim( $path, '/' );
              } else {
                $sec4_video_url = $raw_video_url;
              }
            }
            if ( ! empty( $section4['section4-description'] ) ) {
              $sec4_desc = $section4['section4-description'];
            }
          }
        }
        ?>
        <section class="video-section arc-top arc-bottom">
          <div class="section_1280px">
            <div class="section_1040px gap_40px mobile_padding_left_right_20px mobile_gap_20px">
              <div class="title-group">
                <h2 class="main-title"><?php echo esc_html( $sec4_title ); ?></h2>
                <div class="title-line-bg"></div>
              </div>
              <div class="frame-22">
                <iframe
                  class="element-3"
                  width="560"
                  height="315"
                  src="<?php echo esc_url( $sec4_video_url ); ?>"
                  title="<?php echo esc_attr( $sec4_title ); ?>"
                  allow="
                    accelerometer;
                    autoplay;
                    clipboard-write;
                    encrypted-media;
                    gyroscope;
                    picture-in-picture;
                    web-share;
                  "
                  referrerpolicy="strict-origin-when-cross-origin"
                  allowfullscreen
                ></iframe>

                <div class="frame-12">
                  <div class="text-wrapper-14">
                    <?php echo wp_kses_post( $sec4_desc ); ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
        <section class="partners-section mobile_margin_top_40px mobile_margin_bottom_40px">
          <div class="section_1280px">
            <div class="section_1040px gap_40px mobile_padding_left_right_20px mobile_gap_20px">
              <div class="title-group">
                <h2 class="main-title">合作夥伴</h2>
                <div class="title-line-bg"></div>
              </div>
              <div class="frame-25">
                <?php
                $partners_query = new WP_Query( array(
                  'post_type'      => 'partners',
                  'posts_per_page' => -1,
                  'post_status'    => 'publish',
                  'orderby'        => 'menu_order',
                  'order'          => 'ASC',
                ) );

                if ( $partners_query->have_posts() ) :
                  while ( $partners_query->have_posts() ) :
                    $partners_query->the_post();
                    if ( has_post_thumbnail() ) :
                      $logo_url = get_the_post_thumbnail_url( get_the_ID(), 'full' );
                      ?>
                      <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                        <img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php the_title_attribute(); ?>" />
                      </a>
                      <?php
                    endif;
                  endwhile;
                  wp_reset_postdata();
                else :
                  // Fallback to static mockup logos if no CPT posts exist yet
                  ?>
                  <img src="<?php echo esc_url( get_theme_file_uri( 'public/img/partners/1.svg' ) ); ?>" alt="新綠主義股份有限公司" />
                  <img src="<?php echo esc_url( get_theme_file_uri( 'public/img/partners/2.svg' ) ); ?>" alt="愷恩無障礙室內裝修設計工程有限公司" />
                  <img src="<?php echo esc_url( get_theme_file_uri( 'public/img/partners/3.svg' ) ); ?>" alt="薰香設計室內裝修有限公司" />
                  <img src="<?php echo esc_url( get_theme_file_uri( 'public/img/partners/4.svg' ) ); ?>" alt="亦欣企業" />
                  <?php
                endif;
                ?>
              </div>
              <!-- <div class="frame-25">
                <img src="img/partners/1.svg" alt="新綠主義股份有限公司" />
                <img src="img/partners/2.svg" alt="愷恩無障礙室內裝修設計工程有限公司" />
                <img src="img/partners/3.svg" alt="薰香設計室內裝修有限公司" />
                <img src="img/partners/4.svg" alt="亦欣企業" />
                <img src="img/partners/4.svg" alt="亦欣企業" />
                <img src="img/partners/3.svg" alt="薰香設計室內裝修有限公司" />
                <img src="img/partners/2.svg" alt="愷恩無障礙室內裝修設計工程有限公司" />
                <img src="img/partners/1.svg" alt="新綠主義股份有限公司" />
              </div> -->
              <!-- <img class="frame-25 hide-mobile" src="img/partners.svg" alt="partners" />
              <img class="frame-25 show-mobile" src="img/mobile-partners.svg" alt="partners" /> -->
            </div>
          </div>
        </section>
      </main>
<?php
get_footer();
?>