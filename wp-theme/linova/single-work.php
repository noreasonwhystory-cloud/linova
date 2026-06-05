<?php
if (!defined('ABSPATH')) exit;
get_header();
$home = home_url('/');
$archive = get_post_type_archive_link('work') ?: $home;
?>
<main class="section" id="top">
  <div class="inner">
    <?php while (have_posts()) : the_post();
      $before = linova_field('before_image');
      $after  = linova_field('after_image');
      $before_url = is_array($before) ? ($before['sizes']['large'] ?? $before['url'] ?? '') : ($before ?: '');
      $after_url  = is_array($after)  ? ($after['sizes']['large']  ?? $after['url']  ?? '') : ($after ?: '');
      if (!$after_url && has_post_thumbnail()) { $after_url = get_the_post_thumbnail_url(null, 'large'); }
      ?>
      <article class="entry">
        <div class="crumbs"><a href="<?php echo esc_url($home); ?>">ホーム</a> ／ <a href="<?php echo esc_url($archive); ?>">施工事例</a></div>
        <?php if ($cat = linova_field('work_category')) : ?><span class="work-cat"><?php echo esc_html($cat); ?></span><?php endif; ?>
        <h1><?php the_title(); ?></h1>

        <div class="work-meta">
          <?php if ($loc = linova_field('location')) : ?><span><i data-lucide="map-pin"></i><?php echo esc_html($loc); ?></span><?php endif; ?>
          <?php if ($cmp = linova_field('completed_at')) : ?><span><i data-lucide="calendar"></i><?php echo esc_html($cmp); ?></span><?php endif; ?>
        </div>

        <?php if ($before_url || $after_url) : ?>
          <div class="work-ba">
            <?php if ($before_url) : ?><figure><img src="<?php echo esc_url($before_url); ?>" alt="施工前"><figcaption>BEFORE</figcaption></figure><?php endif; ?>
            <?php if ($after_url) : ?><figure><img src="<?php echo esc_url($after_url); ?>" alt="施工後"><figcaption>AFTER</figcaption></figure><?php endif; ?>
          </div>
        <?php endif; ?>

        <div class="entry-body"><?php the_content(); ?></div>

        <a class="back-link" href="<?php echo esc_url($archive); ?>"><i data-lucide="arrow-left"></i> 施工事例一覧へ戻る</a>
      </article>
    <?php endwhile; ?>
  </div>
</main>
<?php get_footer(); ?>
