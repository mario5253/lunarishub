<footer class="footer">
    <div class="footer_inner">
      <div class="footer_info">
        <div class="footer_logo">
          <h3 class="logo logo-white"><a href="">FOOD SCIENCE<span>メキシカン・レストラン</span></a></h3>
        </div>
        <div class="footer_text">
          <p>〒162-0846 東京都新宿区市谷左内町21-13</p>
        </div>
      </div>
      <section class="footer_sns">
        <h3>SHARE ON</h3>
        <?php
          wp_nav_menu([
            'theme_location' => 'footer-sns',
            'menu_class'     => 'footer-sns_links',
            'container'      => false,
          ]);
        ?>
      </section>
      <div class="footer_copyright">
        <small>&copy; FOOD SCIENCE All rights reserved.</small>
      </div>
    </div>
  </footer>

  <div class="pageTop js-toTop">
    <a href="#"><i class="fas fa-arrow-up"></i><span>TOP PAGE</span></a>
  </div>
  <?php wp_footer();?>
</body>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-56CJN8TR"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
</html>