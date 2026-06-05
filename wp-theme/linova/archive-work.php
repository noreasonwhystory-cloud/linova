<?php
if (!defined('ABSPATH')) exit;
get_header();
$home = home_url('/');
?>
<main class="section" id="top">
  <div class="inner">
    <div class="sec-head page-head">
      <div class="crumbs"><a href="<?php echo esc_url($home); ?>">ホーム</a> ／ 施工事例</div>
      <span class="eyebrow">WORKS</span>
      <h2 class="sec-title">施工事例</h2>
      <p class="lead">これまでの施工事例をご紹介します。小規模な修繕から大規模改修まで幅広く対応しています。</p>
    </div>

    <?php if (have_posts()) : ?>
      <div class="works">
        <?php while (have_posts()) : the_post();
          $before = linova_field('before_image');
          $after  = linova_field('after_image');
          $before_url = is_array($before) ? ($before['sizes']['large'] ?? $before['url'] ?? '') : ($before ?: '');
          $after_url  = is_array($after)  ? ($after['sizes']['large']  ?? $after['url']  ?? '') : ($after ?: '');
          if (!$after_url && has_post_thumbnail()) { $after_url = get_the_post_thumbnail_url(null, 'large'); }
          ?>
          <article class="case">
            <a class="case-media" href="<?php the_permalink(); ?>">
              <?php if ($before_url) : ?><img src="<?php echo esc_url($before_url); ?>" alt="施工前"><?php endif; ?>
              <?php if ($after_url) : ?><img src="<?php echo esc_url($after_url); ?>" alt="施工後"><?php endif; ?>
              <span class="ba-tag before">BEFORE</span><span class="ba-tag after">AFTER</span>
              <span class="ba-arrow"><i data-lucide="chevron-right"></i></span>
            </a>
            <div class="case-tx">
              <?php if ($cat = linova_field('work_category')) : ?><span class="case-cat"><?php echo esc_html($cat); ?></span><?php endif; ?>
              <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
              <p><?php echo esc_html(wp_trim_words(get_the_excerpt(), 50)); ?></p>
              <div class="case-meta">
                <?php if ($loc = linova_field('location')) : ?><span><i data-lucide="map-pin"></i><?php echo esc_html($loc); ?></span><?php endif; ?>
                <?php if ($cmp = linova_field('completed_at')) : ?><span><i data-lucide="calendar"></i><?php echo esc_html($cmp); ?></span><?php endif; ?>
              </div>
            </div>
          </article>
        <?php endwhile; ?>
      </div>
      <div class="pager"><?php the_posts_pagination(['mid_size' => 1, 'prev_text' => '←', 'next_text' => '→']); ?></div>
    <?php else : ?>
      <p class="lead">施工事例はまだ登録されていません。</p>
    <?php endif; ?>

    <a class="back-link" href="<?php echo esc_url($home); ?>"><i data-lucide="arrow-left"></i> トップへ戻る</a>
  </div>
</main>
<?php get_footer(); ?>
