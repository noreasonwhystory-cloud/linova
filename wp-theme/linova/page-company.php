<?php
/**
 * Template Name: 会社概要
 */
if (!defined('ABSPATH')) exit;
get_header();
$home = home_url('/');
$p = linova_profile();

// ページ本文が入力されていればそれを優先。空なら既定テーブルを表示。
$has_content = false;
if (have_posts()) {
    the_post();
    if (trim(get_the_content()) !== '') { $has_content = true; }
}

$rows = [
    ['会社名', esc_html($p['siteName'])],
    ['所在地', '—'],
    ['代表者', '—'],
    ['設立', '—'],
    ['事業内容', '外壁・防水・板金・内装・外構工事、大規模改修、漏水調査 ほか建物に関する各種工事'],
    ['対応エリア', esc_html(implode('・', $p['area']))],
    ['建設業許可', '—'],
    ['電話番号', esc_html($p['phoneDisplay']) . '（' . esc_html($p['hours']) . '）'],
    ['メール', '<a href="mailto:' . esc_attr($p['email']) . '">' . esc_html($p['email']) . '</a>'],
];
?>
<main class="section" id="top">
  <div class="inner">
    <article class="entry">
      <div class="crumbs"><a href="<?php echo esc_url($home); ?>">ホーム</a> ／ 会社概要</div>
      <h1>会社概要</h1>
      <div class="entry-body">
        <?php if ($has_content) : the_content(); else : ?>
          <table class="info-table">
            <tbody>
              <?php foreach ($rows as $r) : ?>
                <tr><th><?php echo esc_html($r[0]); ?></th><td><?php echo $r[1]; ?></td></tr>
              <?php endforeach; ?>
            </tbody>
          </table>
          <p style="margin-top:16px;color:var(--muted);font-size:13px">※「—」の項目は確定後に更新します。</p>
        <?php endif; ?>
      </div>
      <a class="back-link" href="<?php echo esc_url($home); ?>"><i data-lucide="arrow-left"></i> トップへ戻る</a>
    </article>
  </div>
</main>
<?php get_footer(); ?>
