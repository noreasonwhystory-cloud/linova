<?php
/**
 * Template Name: プライバシーポリシー
 */
if (!defined('ABSPATH')) exit;
get_header();
$home = home_url('/');
$p = linova_profile();
?>
<main class="section" id="top">
  <div class="inner">
    <article class="entry">
      <div class="crumbs"><a href="<?php echo esc_url($home); ?>">ホーム</a> ／ プライバシーポリシー</div>
      <h1><?php echo (have_posts() && get_the_title()) ? esc_html(get_the_title()) : 'プライバシーポリシー'; ?></h1>
      <div class="entry-body">
        <?php
        // ページ本文が入力されていればそれを優先表示。空なら既定の雛形を表示。
        $has_content = false;
        if (have_posts()) {
            the_post();
            $content = trim(get_the_content());
            if ($content !== '') {
                $has_content = true;
                the_content();
            }
        }
        if (!$has_content) :
        ?>
        <p><?php echo esc_html($p['siteName']); ?>（以下「当社」）は、お客様の個人情報の保護を重要な責務と認識し、以下の方針に基づき適切に取り扱います。</p>

        <h2>1. 個人情報の取得</h2>
        <p>当社は、お問い合わせ・お見積り・現地調査のご依頼等に際し、お名前・会社名・電話番号・メールアドレス・ご相談内容などの個人情報を、適法かつ公正な手段で取得します。</p>

        <h2>2. 利用目的</h2>
        <p>取得した個人情報は、次の目的の範囲内で利用します。</p>
        <ul>
          <li>お問い合わせ・ご相談への対応、お見積り・施工に関するご連絡</li>
          <li>施工・アフターフォローに関するご案内</li>
          <li>サービス品質向上のための分析</li>
        </ul>

        <h2>3. 第三者提供</h2>
        <p>当社は、法令に基づく場合を除き、ご本人の同意なく個人情報を第三者に提供しません。なお、施工の実施に必要な範囲で協力業者に提供する場合は、適切な管理を行います。</p>

        <h2>4. 安全管理</h2>
        <p>当社は、個人情報の漏えい・滅失・毀損の防止その他安全管理のために必要かつ適切な措置を講じます。</p>

        <h2>5. 開示・訂正・削除</h2>
        <p>ご本人からの個人情報の開示・訂正・利用停止・削除のご請求に対しては、ご本人を確認のうえ、合理的な範囲で速やかに対応します。</p>

        <h2>6. お問い合わせ窓口</h2>
        <p>本ポリシーに関するお問い合わせは、当サイトのお問い合わせフォームまたはお電話にて承ります。</p>

        <p style="margin-top:24px;color:var(--muted);font-size:13px">制定日：2026年6月　／　<?php echo esc_html($p['siteName']); ?></p>
        <?php endif; ?>
      </div>
      <a class="back-link" href="<?php echo esc_url($home); ?>"><i data-lucide="arrow-left"></i> トップへ戻る</a>
    </article>
  </div>
</main>
<?php get_footer(); ?>
