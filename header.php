<?php
/**
 * The Header for the AAEDT Theme.
 *
 * Displays all of the <head> section, the opening <body>, and the accessibility-compliant navigation.
 *
 * @package AAEDT
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>" />
 
  <?php if ( ! function_exists( '_wp_render_title_tag' ) ) : ?>
    <title><?php wp_title( '|', true, 'right' ); ?></title>
  <?php endif; ?>
  <script type="module" src="<?php echo esc_url( get_theme_file_uri( 'src/main.js' ) ); ?>"></script>
  <?php wp_head(); ?>
  <style>

    /* 預先定義下拉選單的隱藏狀態，防止閃爍 */
    .nav-dropdown {
      opacity: 0 !important;
      visibility: hidden !important;
      transform: translateY(-10px) !important;
      position: absolute !important;
    }
    /* 當 JS 或是 CSS 載入完成，且有 active 時才覆蓋 */
    .nav.active .nav-dropdown {
      opacity: 1 !important;
      visibility: visible !important;
      transform: translateY(0) !important;
    }
  </style>
</head>

<body <?php body_class(); ?>>
<?php 
if ( function_exists( 'wp_body_open' ) ) {
  wp_body_open();
}
?>

  <!-- skip link 必需要是第一個元件 -->
  <a href="#main-content" class="sr-only sr-only-focusable">
    <?php esc_html_e( '跳至主要內容', 'new-aaedt-theme' ); ?>
  </a>

  <div class="final">
    <nav class="nav-bar" aria-label="<?php esc_attr_e( '主選單', 'new-aaedt-theme' ); ?>">
      <div class="nav-bar-inner">
        
        <!-- Logo 區塊：支援 WordPress 後台自訂 Logo，若未設定則自動使用主題目錄下的 logo.svg -->
        <div class="nav-logo">
          <?php if ( has_custom_logo() ) : ?>
            <?php the_custom_logo(); ?>
          <?php else : ?> 
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php esc_attr_e( '回協會首頁', 'new-aaedt-theme' ); ?>">
              <img class="logo" src="<?php echo bloginfo('template_directory') ?>/public/img/logo.png;" alt="台灣可及環境設計協會 - 回首頁" />
            </a>
          <?php endif; ?>
        </div>

        <!-- 
            Hamburger toggle（手機版導覽開關）
            - aria-expanded 由 JavaScript 中的 initMobileToggle() 控制
            - aria-controls 指向 nav-content-wrapper
        -->
        <button
          class="nav-toggle"
          type="button"
          aria-controls="nav-content-wrapper"
          aria-expanded="false"
          aria-label="<?php esc_attr_e( '開啟／關閉導覽選單', 'new-aaedt-theme' ); ?>"
        >
          <!-- Hamburger icon -->
          <svg
            class="icon-hamburger"
            width="24"
            height="24"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
            aria-hidden="true"
            focusable="false"
          >
            <line x1="3" y1="6" x2="21" y2="6" />
            <line x1="3" y1="12" x2="21" y2="12" />
            <line x1="3" y1="18" x2="21" y2="18" />
          </svg>
          <!-- Close icon -->
          <svg
            class="icon-close"
            width="24"
            height="24"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
            aria-hidden="true"
            focusable="false"
          >
            <line x1="18" y1="6" x2="6" y2="18" />
            <line x1="6" y1="6" x2="18" y2="18" />
          </svg>
        </button>

        <!-- 導覽內容包裝層 -->
        <div class="nav-content-wrapper" id="nav-content-wrapper">
          <a
            href="#U"
            title="<?php esc_attr_e( '右上方功能區塊', 'new-aaedt-theme' ); ?>"
            id="AU"
            accesskey="U"
            name="U"
            class="sr-only sr-only-focusable"
          >
            <span class="sr-only"><?php esc_html_e( '右上方功能區塊', 'new-aaedt-theme' ); ?></span>
            <span aria-hidden="true">:::</span>
          </a>

          <?php
          if ( has_nav_menu( 'primary' ) ) {
            wp_nav_menu( array(
              'theme_location' => 'primary',
              'container'      => false,
              'menu_class'     => 'nav-menu-list',
              'fallback_cb'    => '__return_false',
              'walker'         => new New_Aaedt_Nav_Walker(),
            ) );
          } else {
            ?>
            <div class="nav-menu-fallback" style="color: #b32d2e; font-size: 14px; padding: 10px 20px; font-weight: 500; background: #fdf2f2; border: 1px solid #f8d7da; border-radius: 4px; margin: 10px;">
              <?php _e( '系統提示：請前往「外觀 ➔ 選單」建立導覽選單，並將其指派至「Primary Menu」主選單位置。', 'new-aaedt-theme' ); ?>
            </div>
            <?php
          }
          ?>

          <img class="nav-divider" src="<?php echo esc_url( get_theme_file_uri( 'public/img/nav-divider.svg' ) ); ?>" alt="" />

          <a href="https://www.aaedt.org.tw/blog/asdc/" target="_blank" class="nav-2" rel="noopener noreferrer" aria-label="<?php esc_attr_e( '學生競圖 (新視窗開啟)', 'new-aaedt-theme' ); ?>">
            <span class="nav-link">學生競圖</span>
            <img class="icon-external" src="<?php echo esc_url( get_theme_file_uri( 'public/img/icon-external.svg' ) ); ?>" alt="" />
          </a>
        </div>
      </div>
    </nav>
    <!-- 備註：主內容容器 <main class="main" id="main-content"> 將在個別頁面範本中開啟，並於 footer.php 關閉 -->
