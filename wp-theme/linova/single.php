<?php
if (!defined('ABSPATH')) exit;
get_header();
$home = home_url('/');
?>
<main class="section" id="top">
  <div class="inner">
    <?php while (have_posts()) : the_post(); ?>
      <article class="entry">
        <?php
        $cats = get_the_category();
        $crumb_cat = '';
        if (!empty($cats)) {
            $crumb_cat = ' ／ <a href="' . esc_url(get_category_link($cats[0]->term_id)) . '">' . esc_html($cats[0]->name) . '</a>';
        }
        ?>
        <div class="crumbs"><a href="<?php echo esc_url($home); ?>">ホーム</a><?php echo $crumb_cat; ?></div>
        <time class="post-date"><?php echo esc_html(get_the_date()); ?></time>
        <h1><?php the_title(); ?></h1>
        <?php if (has_post_thumbnail()) : ?>
          <div class="entry-thumb"><?php the_post_thumbnail('large'); ?></div>
        <?php endif; ?>
        <div class="entry-body"><?php the_content(); ?></div>
        <a class="back-link" href="<?php echo esc_url($home); ?>"><i data-lucide="arrow-left"></i> トップへ戻る</a>
      </article>
    <?php endwhile; ?>
  </div>
</main>
<?php get_footer(); ?>
