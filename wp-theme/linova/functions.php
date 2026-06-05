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
        'catchPhrase'   => '住まいの課題を、最適な解決へ。',
        'area'          => ['愛知県', '岐阜県', '三重県'],
        'phone'         => '052-000-0000',          // TODO: 実電話番号
        'phoneDisplay'  => '052-xxx-xxxx',          // TODO: 表示用
        'hours'         => '受付 9:00〜18:00',
        'lineUrl'       => '#',                      // TODO: LINE公式URL
        'email'         => 'info@linova-works.com',  // TODO: 実メール
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
 * Contact Form 7: 既定CSSを読み込まない（テーマ側で制御）
 */
add_filter('wpcf7_load_css', '__return_false');

/**
 * 「設定 → 一般」末尾に CF7 フォームID 設定欄を追加
 * （トップ問合せフォームに表示する Contact Form 7 のID）
 */
add_action('admin_init', function () {
    register_setting('general', 'linova_cf7_form_id', ['sanitize_callback' => 'absint']);

    add_settings_section('linova_section', 'LINOVAテーマ設定', function () {
        echo '<p>Contact Form 7 のフォーム編集画面URL末尾 <code>post=NN</code> の数値を入力すると、トップの問い合わせ欄にそのフォームを表示します（0で静的フォールバック）。</p>';
    }, 'general');

    add_settings_field('linova_cf7_form_id', 'TOP問合せ CF7 フォームID', function () {
        $value = (int) get_option('linova_cf7_form_id', 0);
        printf('<input type="number" name="linova_cf7_form_id" value="%d" min="0" step="1" class="small-text" />', $value);
    }, 'general', 'linova_section');
});
