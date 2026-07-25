<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package AAEDT
 */

get_header();
?>

<main class="main" id="main-content">
  <section class="error-404 not-found content-section">
    <div class="section_1280px">
      <div class="section_1040px gap_20px mobile_padding_left_right_20px">
        <header class="page-header">
          <h1 class="main-title"><?php esc_html_e( '抱歉！找不到此頁面。', 'new-aaedt-theme' ); ?></h1>
        </header>

        <div class="page-content">
          <p><?php esc_html_e( '您所尋找的頁面可能已被移除、更改名稱，或是暫時無法使用。請點選下方按鈕回到首頁，或使用選單瀏覽其他內容。', 'new-aaedt-theme' ); ?></p>
          <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="nav-2" style="background-color: var(--primary, #fedb00); display: inline-block; padding: 10px 20px; border-radius: 8px; font-weight: bold; text-decoration: none; color: #1a1410; margin-top: 20px;">
            <?php esc_html_e( '回協會首頁', 'new-aaedt-theme' ); ?>
          </a>
        </div>
      </div>
    </div>
  </section>
</main>

<?php
get_footer();
