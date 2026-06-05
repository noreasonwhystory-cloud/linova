<?php
if (!defined('ABSPATH')) exit;
get_header();
$home = home_url('/');
?>
<main class="section" id="top">
  <div class="inner">
    <?php while (have_posts()) : the_post(); ?>
      <article class="entry">
        <div class="crumbs"><a href="<?php echo esc_url($home); ?>">ホーム</a> ／ <?php the_title(); ?></div>
        <h1><?php the_title(); ?></h1>
        <?php if (has_post_thumbnail()) : ?>
          <div class="entry-thumb"><?php the_post_thumbnail('large'); ?></div>
        <?php endif; ?>
        <div class="entry-body"><?php the_content(); ?></div>
      </article>
    <?php endwhile; ?>
  </div>
</main>
<?php get_footer(); ?>
