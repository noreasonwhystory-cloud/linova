<?php
if (!defined('ABSPATH')) exit;
get_header();
$home = home_url('/');
$archive = get_post_type_archive_link('work') ?: $home . '#works';
?>
<?php while (have_posts()) : the_post();
    $cat    = linova_field('work_category');
    // 本文エディタ = 詳細ページのリード文（1回だけフィルタ適用して使い回す）
    $raw_content = get_the_content();
    $lead_html   = trim($raw_content) !== '' ? apply_filters('the_content', $raw_content) : '';

    // ギャラリー画像URL配列を組み立て（photo_1..6→無ければ after/before）
    $imgs = [];
    foreach (['photo_1', 'photo_2', 'photo_3', 'photo_4', 'photo_5', 'photo_6'] as $pf) {
        $g = linova_field($pf);
        if (is_array($g)) {
            $u = $g['sizes']['large'] ?? $g['url'] ?? '';
            if ($u) { $imgs[] = ['full' => $u, 'alt' => $g['alt'] ?: get_the_title()]; }
        }
    }
    if (empty($imgs)) {
        foreach (['after_image', 'before_image'] as $fn) {
            $v = linova_field($fn);
            $u = is_array($v) ? ($v['sizes']['large'] ?? $v['url'] ?? '') : ($v ?: '');
            if ($u) { $imgs[] = ['full' => $u, 'alt' => get_the_title()]; }
        }
    }
    if (empty($imgs) && has_post_thumbnail()) {
        $imgs[] = ['full' => get_the_post_thumbnail_url(null, 'large'), 'alt' => get_the_title()];
    }

    $scope     = linova_field('work_scope');
    $period    = linova_field('work_period');
    $location  = linova_field('location');
    $overview  = linova_field('overview');
    $challenges = linova_field('challenges');
    $response  = linova_field('response');
    // 「よくあるご質問」(faq CPT)から選択されたQ&Aを引用
    $case_faqs = [];
    $refs = linova_field('case_faq_refs');
    if (is_array($refs)) {
        foreach ($refs as $rid) {
            $rid = is_object($rid) ? $rid->ID : (is_array($rid) ? ($rid['ID'] ?? 0) : (int) $rid);
            if ($rid && get_post_status($rid) === 'publish') {
                $case_faqs[] = [
                    'q' => get_the_title($rid),
                    'a' => apply_filters('the_content', get_post_field('post_content', $rid)),
                ];
            }
        }
    }
?>
<main class="case-page">

  <!-- breadcrumb -->
  <div class="crumb">
    <a href="<?php echo esc_url($home); ?>">ホーム</a><span class="sep">›</span>
    <a href="<?php echo esc_url($archive); ?>">施工事例一覧</a><span class="sep">›</span>
    <span class="cur"><?php the_title(); ?></span>
  </div>

  <!-- title -->
  <div class="cd-head">
    <div class="cd-titlerow">
      <h1 class="cd-title"><?php the_title(); ?></h1>
      <?php if ($cat) : ?><span class="cd-badge"><?php echo esc_html($cat); ?></span><?php endif; ?>
    </div>
    <?php if ($lead_html) : ?><div class="cd-desc"><?php echo $lead_html; ?></div><?php endif; ?>
  </div>

  <!-- gallery -->
  <?php if (!empty($imgs)) : ?>
    <div class="cd-gallery">
      <div class="gal-main">
        <img id="galMain" src="<?php echo esc_url($imgs[0]['full']); ?>" alt="<?php echo esc_attr($imgs[0]['alt']); ?>">
      </div>
      <?php if (count($imgs) > 1) : ?>
        <div class="gal-wrap">
          <button class="gal-arrow prev" id="galPrev" aria-label="前へ"><i data-lucide="chevron-left"></i></button>
          <div class="gal-track" id="galTrack">
            <?php foreach ($imgs as $im) : ?>
              <button type="button" class="gal-thumb" aria-label="この写真を大きく表示"><img src="<?php echo esc_url($im['full']); ?>" alt="<?php echo esc_attr($im['alt']); ?>" loading="lazy" decoding="async"></button>
            <?php endforeach; ?>
          </div>
          <button class="gal-arrow next" id="galNext" aria-label="次へ"><i data-lucide="chevron-right"></i></button>
        </div>
      <?php endif; ?>
    </div>
  <?php endif; ?>

  <!-- meta — 3 boxes -->
  <?php if ($scope || $period || $location) : ?>
    <div class="cd-meta">
      <div class="m"><span class="mh"><i data-lucide="building-2"></i>工事内容</span><b><?php echo esc_html($scope ?: '—'); ?></b></div>
      <div class="m"><span class="mh"><i data-lucide="calendar"></i>工事期間</span><b><?php echo esc_html($period ?: '—'); ?></b></div>
      <div class="m"><span class="mh"><i data-lucide="map-pin"></i>場所</span><b><?php echo esc_html($location ?: '—'); ?></b></div>
    </div>
  <?php endif; ?>

  <!-- numbered sections -->
  <?php
  $steps = [];
  if ($overview)   { $steps[] = ['ic' => 'house',       'title' => '工事の概要',   'teal' => false, 'body' => wpautop(esc_html($overview))]; }
  if ($challenges) { $steps[] = ['ic' => 'user-round',  'title' => 'お客様の課題', 'teal' => false, 'checks' => preg_split('/\r\n|\r|\n/', trim($challenges))]; }
  if ($response)   { $steps[] = ['ic' => 'handshake',   'title' => 'LINOVAの対応', 'teal' => true,  'body' => wpautop(esc_html($response))]; }
  if ($steps) : ?>
    <div class="cd-steps">
      <?php foreach ($steps as $i => $s) : ?>
        <section class="cstep">
          <span class="cstep-no"><?php printf('%02d', $i + 1); ?></span>
          <span class="cstep-ic"><i data-lucide="<?php echo esc_attr($s['ic']); ?>"></i></span>
          <h2<?php echo !empty($s['teal']) ? ' class="teal"' : ''; ?>><?php echo esc_html($s['title']); ?></h2>
          <div class="cstep-body">
            <?php if (!empty($s['checks'])) : ?>
              <ul class="checks">
                <?php foreach ($s['checks'] as $c) : if (trim($c) === '') continue; ?>
                  <li><i data-lucide="circle-check"></i><?php echo esc_html($c); ?></li>
                <?php endforeach; ?>
              </ul>
            <?php else : echo $s['body']; endif; ?>
          </div>
        </section>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

  <!-- FAQ (this case) -->
  <?php if (is_array($case_faqs) && !empty($case_faqs)) : ?>
    <section class="cd-faq-sec">
      <h2><i data-lucide="messages-square"></i>よくあるご質問</h2>
      <div class="cd-faq-list">
        <?php foreach ($case_faqs as $f) : ?>
          <div class="cd-faq">
            <button class="cd-faq-q">
              <span class="cd-faq-badge">Q</span>
              <span class="qt"><?php echo esc_html($f['q']); ?></span>
              <span class="chev"><i data-lucide="chevron-down"></i></span>
            </button>
            <div class="cd-faq-a"><div class="inner-a"><span class="a-badge">A</span><div class="cd-faq-atext"><?php echo wp_kses_post($f['a']); ?></div></div></div>
          </div>
        <?php endforeach; ?>
      </div>
      <a class="works-more cd-faq-more" href="<?php echo esc_url($home . 'faq/'); ?>">よくあるご質問をすべて見る <i data-lucide="arrow-right"></i></a>
    </section>
  <?php endif; ?>

  <div style="max-width:1000px;margin:0 auto;padding:34px 24px 0;">
    <a class="back-link" href="<?php echo esc_url($archive); ?>"><i data-lucide="arrow-left"></i> 施工事例一覧へ戻る</a>
  </div>

</main>
<?php endwhile; ?>
<?php get_footer(); ?>
