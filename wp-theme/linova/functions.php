<?php
/**
 * LINOVA Theme functions
 */

if (!defined('ABSPATH')) {
    exit;
}

define('LINOVA_THEME_VERSION', '1.0.0');

/**
 * 会社プロフィール定数（未確定値はダミー。確定後ここを更新）
 */
function linova_profile() {
    return [
        'siteName'      => 'LINOVA',
        'catchPhrase'   => '住まいの課題解決をワンストップで',
        'area'          => ['愛知県', '岐阜県', '三重県'],
        'phone'         => '050-8895-4408',
        'phoneDisplay'  => '050-8895-4408',
        'hours'         => '受付 9:00〜18:00',
        'lineUrl'       => 'https://lin.ee/ZraOz0f',
        'email'         => 'info@linova-works.com',  // 専用メール（XServerで作成済）
    ];
}

/**
 * テーマセットアップ
 */
function linova_theme_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script']);
    add_theme_support('responsive-embeds');
    add_theme_support('automatic-feed-links');

    register_nav_menus([
        'primary' => '主要ナビゲーション',
        'footer'  => 'フッターナビゲーション',
    ]);
}
add_action('after_setup_theme', 'linova_theme_setup');

/**
 * トップページの <title> を「LINOVA｜<catchPhrase>」に固定（検索結果タイトル用）
 */
add_filter('pre_get_document_title', function ($title) {
    if (is_front_page() || is_home()) {
        $p = linova_profile();
        return $p['siteName'] . '｜' . $p['catchPhrase'];
    }
    return $title;
});

/**
 * CSS / JS 読み込み
 */
function linova_enqueue_assets() {
    // Google Fonts
    wp_enqueue_style(
        'linova-fonts',
        'https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700&family=Noto+Sans+JP:wght@400;500;700;900&family=Noto+Serif+JP:wght@500;600;700&display=swap',
        [],
        null
    );

    // テーマメインCSS（style.css にすべて記述）。
    // バージョンはファイル更新時刻 → 更新の度に自動キャッシュバスト。
    $css_path = get_stylesheet_directory() . '/style.css';
    wp_enqueue_style(
        'linova-style',
        get_stylesheet_uri(),
        ['linova-fonts'],
        file_exists($css_path) ? filemtime($css_path) : LINOVA_THEME_VERSION
    );

    // Lucide アイコン（CDN）
    wp_enqueue_script(
        'lucide',
        'https://unpkg.com/lucide@latest/dist/umd/lucide.min.js',
        [],
        null,
        true
    );

    // テーマJS（lucide.createIcons / nav / scroll / reveal）
    $js_path = get_template_directory() . '/assets/js/main.js';
    wp_enqueue_script(
        'linova-main',
        get_template_directory_uri() . '/assets/js/main.js',
        ['lucide'],
        file_exists($js_path) ? filemtime($js_path) : LINOVA_THEME_VERSION,
        true
    );
}
add_action('wp_enqueue_scripts', 'linova_enqueue_assets');

/**
 * カスタム投稿タイプ: 施工事例(work)
 */
function linova_register_post_types() {
    register_post_type('work', [
        'labels' => [
            'name'          => '施工事例',
            'singular_name' => '施工事例',
            'add_new'       => '新規追加',
            'add_new_item'  => '新規施工事例を追加',
            'edit_item'     => '施工事例を編集',
            'view_item'     => '施工事例を表示',
            'all_items'     => '施工事例一覧',
            'menu_name'     => '施工事例',
        ],
        'public'        => true,
        'has_archive'   => 'works',
        'rewrite'       => ['slug' => 'works'],
        'menu_icon'     => 'dashicons-format-gallery',
        'menu_position' => 5,
        'supports'      => ['title', 'editor', 'thumbnail'],
        'show_in_rest'  => true,
    ]);
}
add_action('init', 'linova_register_post_types');

/**
 * 施工事例(work)はクラシックエディタを使う
 */
add_filter('use_block_editor_for_post_type', function ($use_block_editor, $post_type) {
    if ($post_type === 'work') {
        return false;
    }
    return $use_block_editor;
}, 10, 2);

/**
 * 標準投稿のカテゴリ「お知らせ」「ブログ」を用意（無ければ作成）
 */
function linova_ensure_categories() {
    foreach (['お知らせ' => 'news', 'ブログ' => 'blog'] as $name => $slug) {
        if (!term_exists($slug, 'category')) {
            wp_insert_term($name, 'category', ['slug' => $slug]);
        }
    }
}
add_action('init', 'linova_ensure_categories');

/**
 * ACF ローカルJSON 保存/読込先をテーマ内 acf-json/ に
 */
add_filter('acf/settings/save_json', function ($path) {
    return get_template_directory() . '/acf-json';
});
add_filter('acf/settings/load_json', function ($paths) {
    $paths[] = get_template_directory() . '/acf-json';
    return $paths;
});

/**
 * テーマ画像URL（assets/images/）+ filemtime キャッシュバスト。
 * 同名差し替えでも即反映。存在しないファイルは空文字（呼び出し側で出し分け可）。
 */
function linova_asset_img($file) {
    $rel = '/assets/images/' . ltrim($file, '/');
    $abs = get_template_directory() . $rel;
    if (!file_exists($abs)) {
        return '';
    }
    return get_template_directory_uri() . $rel . '?v=' . filemtime($abs);
}

/**
 * 施工事例の ACF ヘルパー（ACF未導入でも安全に空を返す）
 */
function linova_field($name, $post_id = null) {
    if (function_exists('get_field')) {
        return get_field($name, $post_id);
    }
    return '';
}

/**
 * OGP / Twitter Card / meta description
 */
add_action('wp_head', function () {
    $p    = linova_profile();
    $site = $p['siteName'];

    if (is_front_page() || is_home()) {
        $title = $site . '｜' . $p['catchPhrase'];
        $url   = home_url('/');
        $type  = 'website';
    } elseif (is_singular()) {
        $title = get_the_title() . '｜' . $site;
        $url   = get_permalink();
        $type  = 'article';
    } else {
        $title = wp_get_document_title();
        $url   = home_url(add_query_arg([], $GLOBALS['wp']->request));
        $type  = 'website';
    }

    $description = '愛知・岐阜・三重を中心に、外壁・防水・板金・内装・外構など建物の課題を一貫対応。調査・提案から施工管理まで「' . $site . '」にお任せください。';
    $image       = get_template_directory_uri() . '/assets/images/hero.png';
    ?>
    <meta name="description" content="<?php echo esc_attr($description); ?>" />
    <meta property="og:title" content="<?php echo esc_attr($title); ?>" />
    <meta property="og:description" content="<?php echo esc_attr($description); ?>" />
    <meta property="og:type" content="<?php echo esc_attr($type); ?>" />
    <meta property="og:url" content="<?php echo esc_url($url); ?>" />
    <meta property="og:image" content="<?php echo esc_url($image); ?>" />
    <meta property="og:site_name" content="<?php echo esc_attr($site); ?>" />
    <meta property="og:locale" content="ja_JP" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="<?php echo esc_attr($title); ?>" />
    <meta name="twitter:description" content="<?php echo esc_attr($description); ?>" />
    <meta name="twitter:image" content="<?php echo esc_url($image); ?>" />
    <?php
}, 5);

/**
 * favicon / サイトアイコン（LINOVA マーク）。
 * カスタマイザーでサイトアイコン未設定の場合に theme の favicon を出力。
 */
add_action('wp_head', function () {
    if (function_exists('has_site_icon') && has_site_icon()) {
        return; // WP のサイトアイコンを優先
    }
    $f = linova_asset_img('favicon.png');
    if (!$f) return;
    echo '<link rel="icon" href="' . esc_url($f) . '" sizes="any">' . "\n";
    echo '<link rel="apple-touch-icon" href="' . esc_url($f) . '">' . "\n";
}, 6);

/**
 * Contact Form 7: 既定CSSを読み込まない（テーマ側で制御）
 */
add_filter('wpcf7_load_css', '__return_false');

/**
 * 「設定 → 一般」末尾に CF7 フォームID 設定欄を追加
 * （トップ問合せフォームに表示する Contact Form 7 のID）
 */
add_action('admin_init', function () {
    register_setting('general', 'linova_cf7_shortcode', ['sanitize_callback' => 'sanitize_text_field']);
    register_setting('general', 'linova_gsc_verify', ['sanitize_callback' => 'sanitize_text_field']);

    add_settings_section('linova_section', 'LINOVAテーマ設定', function () {
        echo '<p>トップの問い合わせ欄に表示する Contact Form 7 のショートコードを貼り付け（例 <code>[contact-form-7 id="xxxxxxx" title="お問い合わせ"]</code>）。空欄なら既定フォームを表示。</p>';
    }, 'general');

    add_settings_field('linova_cf7_shortcode', 'TOP問合せ CF7 ショートコード', function () {
        $value = (string) get_option('linova_cf7_shortcode', '');
        printf('<input type="text" name="linova_cf7_shortcode" value="%s" class="large-text" placeholder="[contact-form-7 id=&quot;...&quot;]" />', esc_attr($value));
    }, 'general', 'linova_section');

    add_settings_field('linova_gsc_verify', 'Google Search Console 確認コード', function () {
        $value = (string) get_option('linova_gsc_verify', '');
        printf('<input type="text" name="linova_gsc_verify" value="%s" class="regular-text" placeholder="content の値だけ" />', esc_attr($value));
        echo '<p class="description">Search Console「HTMLタグ」方式の <code>content="..."</code> の値のみを貼り付け（タグ全体不要）。</p>';
    }, 'general', 'linova_section');
});

/**
 * Google Search Console 所有権確認 meta タグ出力
 */
add_action('wp_head', function () {
    $code = trim((string) get_option('linova_gsc_verify', ''));
    if ($code !== '') {
        echo '<meta name="google-site-verification" content="' . esc_attr($code) . '" />' . "\n";
    }
}, 4);

/**
 * TOP問合せに表示する CF7 ショートコード（設定優先・無ければ既定）
 */
function linova_cf7_shortcode() {
    $sc = trim((string) get_option('linova_cf7_shortcode', ''));
    if ($sc === '') {
        $sc = '[contact-form-7 id="6bfa258" title="お問い合わせ"]';
    }
    return $sc;
}
