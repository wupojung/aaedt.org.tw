<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the "final" div and all content after.
 *
 * @package AAEDT
 */
?>

  <footer class="footer">
    <div class="footer-main-panel mobile_padding_left_right_20px">
      <!-- 左側：品牌與聯絡資訊 -->
      <div class="footer-brand-panel">
        <div class="footer-logo">
          <img src="<?php echo esc_url( get_theme_file_uri( 'public/img/logo.svg' ) ); ?>" alt="<?php esc_attr_e( '台灣可及環境設計協會 logo', 'new-aaedt-theme' ); ?>" />
        </div>
      </div>

      <div class="address_nav_area">
        <address class="footer-contact-list">
          <div class="footer-contact-item">
            <img class="icon" src="<?php echo esc_url( get_theme_file_uri( 'public/img/footer/property-1-map.svg' ) ); ?>" alt="" aria-hidden="true" />
            <span class="contact-text">406台中市北屯區松竹路二段 86 巷 28 弄 22 號 2 樓之 2</span>
          </div>
          <div class="footer-contact-item">
            <img class="icon" src="<?php echo esc_url( get_theme_file_uri( 'public/img/footer/property-1-phone.svg' ) ); ?>" alt="" aria-hidden="true" />
            <span class="contact-text">聯絡電話：<a href="tel:+886422437659">04-22437659</a></span>
          </div>
          <div class="footer-contact-item">
            <img class="icon" src="<?php echo esc_url( get_theme_file_uri( 'public/img/footer/property-1-fax.svg' ) ); ?>" alt="" aria-hidden="true" />
            <span class="contact-text">傳真號碼：04-25370205</span>
          </div>
        </address>
        
        <nav class="footer-nav-panel" aria-label="<?php esc_attr_e( '頁尾導覽', 'new-aaedt-theme' ); ?>">
          <div class="footer-nav-column">
            <a href="<?php echo esc_url( home_url( '/news/' ) ); ?>" class="footer-page-link">
              <span class="footer-link-text"><?php esc_html_e( '最新消息', 'new-aaedt-theme' ); ?></span>
            </a>
            <a href="<?php echo esc_url( home_url( '/about/' ) ); ?>" class="footer-page-link">
              <span class="footer-link-text"><?php esc_html_e( '認識協會', 'new-aaedt-theme' ); ?></span>
            </a>
            <a href="<?php echo esc_url( home_url( '/inspection/' ) ); ?>" class="footer-page-link">
              <span class="footer-link-text"><?php esc_html_e( '專業服務', 'new-aaedt-theme' ); ?></span>
            </a>
          </div>
          <div class="footer-nav-column">
            <a href="<?php echo esc_url( home_url( '/campaign_overview/' ) ); ?>" class="footer-page-link">
              <span class="footer-link-text"><?php esc_html_e( '推廣行動', 'new-aaedt-theme' ); ?></span>
            </a>
            <a href="<?php echo esc_url( home_url( '/related_organizations/' ) ); ?>" class="footer-page-link">
              <span class="footer-link-text"><?php esc_html_e( '相關資源', 'new-aaedt-theme' ); ?></span>
            </a>
            <a href="<?php echo esc_url( home_url( '/join/' ) ); ?>" class="footer-page-link">
              <span class="footer-link-text"><?php esc_html_e( '加入我們', 'new-aaedt-theme' ); ?></span>
            </a>
          </div>
        </nav>
      </div>

      <hr />

      <!-- 底部：政策 + 社群 -->
      <div class="footer-bottom-panel">
        <div class="footer-policy-panel">
          <a class="font_family_inter font_size_14 font_w_500" href="<?php echo esc_url( home_url( '/privacy-policy/' ) ); ?>">
            <?php esc_html_e( '隱私權政策', 'new-aaedt-theme' ); ?>
          </a>
          <span class="policy-divider" aria-hidden="true"></span>
          <a class="font_family_inter font_size_14 font_w_500" href="<?php echo esc_url( home_url( '/accessibility-statement/' ) ); ?>">
            <?php esc_html_e( '網站無障礙聲明', 'new-aaedt-theme' ); ?>
          </a>
        </div>
        <div class="footer-social-panel">
          <span class="font_size_14 font_w_500"><?php esc_html_e( '關注我們', 'new-aaedt-theme' ); ?></span>
          <a href="https://www.youtube.com/@AAEDT" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'YouTube（新視窗開啟）', 'new-aaedt-theme' ); ?>">
            <img class="footer-social-icon" src="<?php echo esc_url( get_theme_file_uri( 'public/img/footer/footer-social-media-youtube.svg' ) ); ?>" alt="YouTube" />
          </a>
          <a href="https://lin.ee/Q538Cx5" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Line@（新視窗開啟）', 'new-aaedt-theme' ); ?>">
            <img class="footer-social-icon" src="<?php echo esc_url( get_theme_file_uri( 'public/img/footer/footer-social-media-line.svg' ) ); ?>" alt="Line@" />
          </a>
          <a href="https://www.facebook.com/AAEDT2014" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Facebook（新視窗開啟）', 'new-aaedt-theme' ); ?>">
            <img class="footer-social-icon" src="<?php echo esc_url( get_theme_file_uri( 'public/img/footer/footer-social-media-fb.svg' ) ); ?>" alt="Facebook" />
          </a>
        </div>
      </div>
    </div>
  </footer>
</div> <!-- .final -->

<!-- WordPress-friendly loading of main ES Module script -->

  <!-- <script type="script" src="<?php echo esc_url( get_theme_file_uri( 'src/main.js' ) ); ?>"></script> -->
<?php wp_footer(); ?>
</body>
</html>
