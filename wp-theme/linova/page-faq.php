<?php
/**
 * Template Name: よくあるご質問
 */
if (!defined('ABSPATH')) exit;
get_header();
$home = home_url('/');
?>
<main class="section faq-sec" id="top">
  <div class="inner">
    <div class="sec-head page-head" style="text-align:center">
      <div class="crumbs"><a href="<?php echo esc_url($home); ?>">ホーム</a> ／ よくあるご質問</div>
      <span class="eyebrow">FAQ</span>
      <h2 class="sec-title">よくあるご質問</h2>
      <p class="lead">LINOVAによくいただくご質問をまとめました。ご不明点がありましたら、お気軽にご相談ください。</p>
    </div>
    <div class="faq-list">
      <?php foreach (linova_faqs() as $i => $faq) linova_faq_item($faq, $i === 0); ?>
    </div>
    <a class="back-link" href="<?php echo esc_url($home); ?>"><i data-lucide="arrow-left"></i> トップへ戻る</a>
  </div>
</main>
<?php get_footer(); ?>
