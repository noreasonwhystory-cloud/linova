<?php
if (!defined('ABSPATH')) exit;
get_header();
?>
<main class="section" id="top">
  <div class="inner">
    <div class="sec-head">
      <span class="eyebrow"><?php echo is_search() ? 'SEARCH' : 'NEWS'; ?></span>
      <h2 class="sec-title">
        <?php
        if (is_search()) {
            echo '「' . esc_html(get_search_query()) . '」の検索結果';
        } elseif (is_category() || is_archive()) {
            echo esc_html(single_term_title('', false) ?: wp_get_document_title());
        } else {
            echo 'お知らせ・ブログ';
        }
        ?>
      </h2>
    </div>

    <?php if (have_posts()) : ?>
      <div class="post-list">
        <?php while (have_posts()) : the_post(); ?>
          <article class="post-item">
            <a href="<?php the_permalink(); ?>">
              <?php if (has_post_thumbnail()) : ?>
                <div class="post-thumb"><?php the_post_thumbnail('medium_large'); ?></div>
              <?php endif; ?>
              <div class="post-body">
                <time class="post-date"><?php echo esc_html(get_the_date()); ?></time>
                <h3 class="post-title"><?php the_title(); ?></h3>
                <p class="post-excerpt"><?php echo esc_html(wp_trim_words(get_the_excerpt(), 60)); ?></p>
              </div>
            </a>
          </article>
        <?php endwhile; ?>
      </div>
      <div class="pager"><?php the_posts_pagination(['mid_size' => 1]); ?></div>
    <?php else : ?>
      <p class="lead">記事がまだありません。</p>
    <?php endif; ?>
  </div>
</main>
<?php get_footer(); ?>
