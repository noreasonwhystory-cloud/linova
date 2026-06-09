<?php
if (!defined('ABSPATH')) exit;
get_header();
$home = home_url('/');
?>
<main class="section" id="top">
  <div class="inner" style="text-align:center;max-width:620px">
    <span class="eyebrow">404</span>
    <h2 class="sec-title">ページが見つかりません</h2>
    <p class="lead" style="margin-top:14px">お探しのページは移動または削除された可能性があります。URL をご確認のうえ、トップページからお進みください。</p>
    <p style="margin-top:26px">
      <a class="hero-cta" href="<?php echo esc_url($home); ?>">トップへ戻る <span class="arr">→</span></a>
    </p>
  </div>
</main>
<?php get_footer(); ?>
