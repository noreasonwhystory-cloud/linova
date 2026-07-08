<?php
if (!defined('ABSPATH')) exit;
get_header();
$home = home_url('/');
$archive = get_post_type_archive_link('work') ?: $home . '#works';
?>
<?php while (have_posts()) : the_post();
    $cat    = linova_field('work_category');
    $desc   = linova_field('description');
    if (!$desc) { $desc = get_the_excerpt(); }

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
    $overview  = trim(get_the_content());
    $challenges = linova_field('challenges');
    $response  = linova_field('response');
    $case_faqs = [];
    for ($n = 1; $n <= 3; $n++) {
        $q = linova_field('faq' . $n . '_q');
        $a = linova_field('faq' . $n . '_a');
        if ($q) { $case_faqs[] = ['q' => $q, 'a' => $a]; }
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
    <?php if ($desc) : ?><p class="cd-desc"><?php echo esc_html($desc); ?></p><?php endif; ?>
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
              <div class="gal-thumb"><img src="<?php echo esc_url($im['full']); ?>" alt="<?php echo esc_attr($im['alt']); ?>"></div>
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
  if ($overview)   { $steps[] = ['ic' => 'house',       'title' => '工事の概要',   'teal' => false, 'body' => apply_filters('the_content', get_the_content())]; }
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
            <div class="cd-faq-a"><div class="inner-a"><span class="a-badge">A</span><p><?php echo nl2br(esc_html($f['a'])); ?></p></div></div>
          </div>
        <?php endforeach; ?>
      </div>
    </section>
  <?php endif; ?>

  <div style="max-width:1000px;margin:0 auto;padding:34px 24px 0;">
    <a class="back-link" href="<?php echo esc_url($archive); ?>"><i data-lucide="arrow-left"></i> 施工事例一覧へ戻る</a>
  </div>

</main>
<?php endwhile; ?>
<?php get_footer(); ?>
