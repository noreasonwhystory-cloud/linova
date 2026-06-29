<?php
/**
 * Template Name: よくあるご質問
 */
if (!defined('ABSPATH')) exit;
get_header();
$home = home_url('/');

// 投稿が1件以上ある工事種別のみフィルタに出す
$terms = get_terms(['taxonomy' => 'faq_cat', 'hide_empty' => true]);
?>
<main class="section faq-sec" id="top">
  <div class="inner">
    <div class="sec-head page-head" style="text-align:center">
      <div class="crumbs"><a href="<?php echo esc_url($home); ?>">ホーム</a> ／ よくあるご質問</div>
      <span class="eyebrow">FAQ</span>
      <h2 class="sec-title">よくあるご質問</h2>
      <p class="lead">LINOVAによくいただくご質問をまとめました。気になる工事種別で絞り込めます。</p>
    </div>

    <?php if (!is_wp_error($terms) && !empty($terms)) : ?>
      <div class="faq-filter">
        <button class="faq-pill active" data-filter="*">すべて</button>
        <?php foreach ($terms as $t) : ?>
          <button class="faq-pill" data-filter="<?php echo esc_attr($t->slug); ?>"><?php echo esc_html($t->name); ?></button>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <div class="faq-list">
      <?php
      $fq = new WP_Query([
          'post_type'      => 'faq',
          'posts_per_page' => -1,
          'orderby'        => 'menu_order date',
          'order'          => 'ASC',
          'no_found_rows'  => true,
      ]);
      if ($fq->have_posts()) :
          while ($fq->have_posts()) : $fq->the_post();
              $cats = get_the_terms(get_the_ID(), 'faq_cat');
              $slugs = (!is_wp_error($cats) && $cats) ? wp_list_pluck($cats, 'slug') : [];
              linova_faq_item(get_the_title(), apply_filters('the_content', get_the_content()), $slugs);
          endwhile; wp_reset_postdata();
      else :
          foreach (linova_faqs() as $faq) {
              linova_faq_item($faq['q'], wpautop(esc_html($faq['a'])));
          }
      endif;
      ?>
    </div>
    <p class="faq-empty" style="display:none;text-align:center;color:var(--muted);margin-top:18px">該当する質問がありません。</p>

    <a class="back-link" href="<?php echo esc_url($home); ?>"><i data-lucide="arrow-left"></i> トップへ戻る</a>
  </div>
</main>
<?php get_footer(); ?>
