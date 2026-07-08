<?php
if (!defined('ABSPATH')) exit;
get_header();
$home = home_url('/');

// 投稿のある工事種別のみチップに出す
$wterms = get_terms(['taxonomy' => 'work_cat', 'hide_empty' => true]);
// 新着判定: 30日以内
$new_threshold = strtotime('-30 days', current_time('timestamp'));
?>
<main class="wl-page">

  <!-- head -->
  <div class="wl-head">
    <span class="eyebrow">WORKS</span>
    <h1 class="sec-title">施工事例</h1>
    <p class="lead">これまでの施工事例をご紹介します。小規模な修繕から大規模改修まで、建物に関するさまざまな課題に対応してきました。</p>
  </div>

  <!-- filter -->
  <?php if (!is_wp_error($wterms) && !empty($wterms)) : ?>
    <div class="wl-filter" id="wlFilter">
      <button class="wl-chip active" data-cat="all">すべて</button>
      <?php foreach ($wterms as $t) : ?>
        <button class="wl-chip" data-cat="<?php echo esc_attr($t->slug); ?>"><?php echo esc_html($t->name); ?></button>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

  <!-- grid -->
  <div class="wl-grid" id="wlGrid">
    <?php
    $wq = new WP_Query([
        'post_type'      => 'work',
        'posts_per_page' => -1,
        'orderby'        => 'date',
        'order'          => 'DESC',
        'no_found_rows'  => true,
    ]);
    if ($wq->have_posts()) :
        while ($wq->have_posts()) : $wq->the_post();
            $terms = get_the_terms(get_the_ID(), 'work_cat');
            $slugs = (!is_wp_error($terms) && $terms) ? wp_list_pluck($terms, 'slug') : [];
            $img_url = linova_card_image();
            $label = linova_field('work_category');
            if (!$label && !is_wp_error($terms) && $terms) { $label = $terms[0]->name; }
            $is_new = get_the_time('U') >= $new_threshold;
            ?>
            <a class="wl-card" data-cat="<?php echo esc_attr(implode(' ', $slugs)); ?>" href="<?php the_permalink(); ?>">
              <div class="wl-media">
                <?php if ($img_url) : ?><img loading="lazy" decoding="async" src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr(get_the_title()); ?>"><?php endif; ?>
                <?php if ($label) : ?><span class="wl-cat"><?php echo esc_html($label); ?></span><?php endif; ?>
                <?php if ($is_new) : ?><span class="wl-new">NEW</span><?php endif; ?>
              </div>
              <div class="wl-body">
                <h3><?php the_title(); ?></h3>
                <p><?php echo esc_html(wp_trim_words(get_the_excerpt(), 48)); ?></p>
                <div class="wl-meta">
                  <?php if ($loc = linova_field('location')) : ?><span><i data-lucide="map-pin"></i><?php echo esc_html($loc); ?></span><?php endif; ?>
                  <?php if ($cmp = linova_field('completed_at')) : ?><span><i data-lucide="calendar"></i><?php echo esc_html($cmp); ?></span><?php endif; ?>
                </div>
                <span class="wl-link">詳しく見る <span class="arr">→</span></span>
              </div>
            </a>
        <?php endwhile; wp_reset_postdata();
    endif; ?>
  </div>

  <div class="wl-empty" id="wlEmpty">
    <?php echo ($wq->post_count > 0) ? '該当する施工事例が見つかりませんでした。' : '施工事例は準備中です。'; ?>
  </div>

  <div class="wl-more" id="wlMore" style="display:none">
    <button id="wlMoreBtn">もっと見る <i data-lucide="chevron-down"></i></button>
  </div>

</main>
<?php get_footer(); ?>
