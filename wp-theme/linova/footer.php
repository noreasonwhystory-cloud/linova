<?php
if (!defined('ABSPATH')) exit;
$p    = linova_profile();
$img  = get_template_directory_uri() . '/assets/images';
$home = home_url('/');
?>
  <!-- ===== FOOTER ===== -->
  <footer class="ftr">
    <div class="inner ftr-in">
      <div class="ftr-brand">
        <a class="brand" href="<?php echo esc_url($home); ?>"><img class="logo-img logo-white" src="<?php echo esc_url($img); ?>/logo-white.png" alt="<?php echo esc_attr($p['siteName']); ?>"></a>
        <p class="ftxt">住まいの課題を、最適な解決へ。<br>愛知・岐阜・三重エリアを中心に対応しています。</p>
      </div>
      <nav class="ftr-nav">
        <a href="<?php echo esc_url($home . '#service'); ?>">対応サービス</a>
        <a href="<?php echo esc_url($home . '#works'); ?>">施工事例</a>
        <a href="<?php echo esc_url($home . '#strength'); ?>">LINOVAの強み</a>
        <a href="<?php echo esc_url($home . '#area'); ?>">対応エリア</a>
        <a href="<?php echo esc_url($home . '#contact'); ?>">お問い合わせ</a>
        <a href="<?php echo esc_url($home . 'privacy/'); ?>">プライバシーポリシー</a>
      </nav>
    </div>
    <p class="cc">© <?php echo esc_html(date('Y')); ?> <?php echo esc_html($p['siteName']); ?>. All rights reserved.</p>
  </footer>

  <!-- ===== MOBILE CTA BAR (sticky, mobile only) ===== -->
  <div class="m-cta" id="mCta">
    <div class="m-cta-top">
      <span class="mc-title">工事のご相談はこちら</span>
      <span class="mc-area"><i data-lucide="map-pin"></i>愛知・岐阜・三重 対応</span>
    </div>
    <div class="m-cta-btns">
      <a class="btn-line" href="<?php echo esc_url($p['lineUrl']); ?>">
        <span class="line-badge">LINE</span>
        <span class="col"><span class="t1">LINEで相談する</span><span class="t2">24時間受付中</span></span>
      </a>
      <a class="btn-tel" href="tel:<?php echo esc_attr($p['phone']); ?>">
        <span class="tel-ic"><i data-lucide="phone"></i></span>
        <span class="col"><span class="t1"><?php echo esc_html($p['phoneDisplay']); ?></span><span class="t2"><?php echo esc_html($p['hours']); ?></span></span>
      </a>
    </div>
  </div>

</div><!-- /.page -->
<?php wp_footer(); ?>
</body>
</html>
