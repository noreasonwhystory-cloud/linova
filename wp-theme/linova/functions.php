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
    // バージョン固定（@latest だと破壊的変更でアイコン全崩壊リスク）
    wp_enqueue_script(
        'lucide',
        'https://unpkg.com/lucide@0.460.0/dist/umd/lucide.min.js',
        [],
        '0.460.0',
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

    // よくあるご質問（title=質問 / 本文=回答）
    register_post_type('faq', [
        'labels' => [
            'name'          => 'よくあるご質問',
            'singular_name' => 'よくあるご質問',
            'add_new'       => '新規追加',
            'add_new_item'  => '新規Q&Aを追加',
            'edit_item'     => 'Q&Aを編集',
            'all_items'     => 'Q&A一覧',
            'menu_name'     => 'よくあるご質問',
        ],
        'public'             => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'publicly_queryable' => false,
        'exclude_from_search' => true,
        'has_archive'        => false,
        'rewrite'            => false,
        'menu_icon'          => 'dashicons-editor-help',
        'menu_position'      => 6,
        'supports'           => ['title', 'editor'],
        'show_in_rest'       => true,
    ]);

    // 施工事例 工事種別（一覧フィルタ用タクソノミ）
    register_taxonomy('work_cat', 'work', [
        'labels' => [
            'name'          => '工事種別',
            'singular_name' => '工事種別',
            'menu_name'     => '工事種別',
            'add_new_item'  => '工事種別を追加',
            'all_items'     => '工事種別一覧',
        ],
        'public'            => true,
        'hierarchical'      => true,
        'show_admin_column' => true,
        'show_in_rest'      => true,
        'rewrite'           => ['slug' => 'work-cat'],
    ]);

    // 工事種別（FAQフィルタ用タクソノミ）
    register_taxonomy('faq_cat', 'faq', [
        'labels' => [
            'name'          => '工事種別',
            'singular_name' => '工事種別',
            'menu_name'     => '工事種別',
            'add_new_item'  => '工事種別を追加',
            'all_items'     => '工事種別一覧',
        ],
        'public'            => true,
        'hierarchical'      => true,
        'show_admin_column' => true,
        'show_in_rest'      => true,
        'rewrite'           => ['slug' => 'faq-cat'],
    ]);
}
add_action('init', 'linova_register_post_types');

/**
 * FAQ工事種別 初期term（無ければ作成・管理画面で追加変更可）
 */
function linova_ensure_faq_terms() {
    $terms = ['外壁', '屋根・板金', '防水', '漏水調査', '内装', '外構', '設備', '全般'];
    foreach ($terms as $t) {
        if (!term_exists($t, 'faq_cat')) {
            wp_insert_term($t, 'faq_cat');
        }
    }
}
add_action('init', 'linova_ensure_faq_terms', 11);

/**
 * 施工事例 工事種別 初期term（英語スラッグ・冪等・管理画面で増減可）
 */
function linova_ensure_work_terms() {
    $terms = [
        '店舗改修' => 'store', '防水' => 'waterproof', '屋根・板金' => 'roof',
        '外壁' => 'wall', '雨漏り' => 'leak', '大規模改修' => 'large',
        '内装' => 'interior', '外構' => 'exterior', '設備' => 'facility',
    ];
    foreach ($terms as $name => $slug) {
        if (!term_exists($slug, 'work_cat')) {
            wp_insert_term($name, 'work_cat', ['slug' => $slug]);
        }
    }
}
add_action('init', 'linova_ensure_work_terms', 11);

/**
 * 施工事例(work)・FAQはクラシックエディタを使う
 */
add_filter('use_block_editor_for_post_type', function ($use_block_editor, $post_type) {
    if (in_array($post_type, ['work', 'faq'], true)) {
        return false;
    }
    return $use_block_editor;
}, 10, 2);

/**
 * 「よくあるご質問」固定ページ(slug=faq・テンプレ page-faq.php)を自動生成。
 * 既存なら何もしない。1度作れば以後はフラグでスキップ。
 */
add_action('after_setup_theme', function () {
    if (get_option('linova_faq_page_done')) {
        return;
    }
    $existing = get_page_by_path('faq');
    if (!$existing) {
        $id = wp_insert_post([
            'post_title'   => 'よくあるご質問',
            'post_name'    => 'faq',
            'post_status'  => 'publish',
            'post_type'    => 'page',
            'post_content' => '',
        ]);
        if ($id && !is_wp_error($id)) {
            update_post_meta($id, '_wp_page_template', 'page-faq.php');
        }
    } else {
        // 既存ページにテンプレ未割当なら割り当て
        if (get_post_meta($existing->ID, '_wp_page_template', true) !== 'page-faq.php') {
            update_post_meta($existing->ID, '_wp_page_template', 'page-faq.php');
        }
    }
    update_option('linova_faq_page_done', 1);
});

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
 * よくあるご質問（全件）。front は先頭 LINOVA_FAQ_TOP 件、/faq/ は全件を共用。
 */
define('LINOVA_FAQ_TOP', 6);

function linova_faqs() {
    return [
        ['q' => 'LINOVAにはどのような工事を依頼できますか？',
         'a' => '店舗改修・原状回復・外壁工事・屋根工事・防水工事・設備工事・漏水調査など、建物に関する修繕・改修工事全般に対応しています。建物の課題に応じて最適な施工方法をご提案いたします。'],
        ['q' => '管理会社ですが、継続的に依頼することはできますか？',
         'a' => 'もちろん可能です。小規模修繕から改修工事まで継続的に対応しており、複数物件のご依頼にも柔軟に対応いたします。建物管理のパートナーとして長期的なお付き合いを大切にしています。'],
        ['q' => '現地調査や見積りだけでも依頼できますか？',
         'a' => 'はい。現地調査・原因調査・お見積り作成まで対応しております。「どのような工事が必要か分からない」という段階でもお気軽にご相談ください。'],
        ['q' => '工事の進捗状況は確認できますか？',
         'a' => 'はい。LINOVAでは独自の案件・報告共有システムを活用し、現地調査から施工中の進捗、完了報告までを分かりやすく共有しています。管理会社様・オーナー様も状況を把握しやすく、安心してお任せいただけます。'],
        ['q' => '工事後の報告書はありますか？',
         'a' => 'はい。施工写真・完了報告書をご提出するだけでなく、独自の報告共有システムにより、施工内容や進捗履歴も分かりやすく共有しています。オーナー様への報告資料としてもそのままご活用いただけます。'],
        ['q' => '店舗営業中でも工事できますか？',
         'a' => '可能です。営業時間や営業日を考慮し、夜間施工や工程調整など営業への影響を抑えた施工計画をご提案いたします。'],
        ['q' => '雨漏りや漏水調査だけでも依頼できますか？',
         'a' => 'もちろん可能です。漏水調査・原因特定・必要な修繕工事・施工管理までワンストップで対応しております。原因が分からない場合でもお気軽にご相談ください。'],
        ['q' => '外装・設備・内装など複数工事をまとめて依頼できますか？',
         'a' => 'はい。外装・屋根・防水・設備・内装・原状回復など、複数工種をまとめてご依頼いただけます。窓口を一本化することで、管理会社様やオーナー様の業務負担を軽減いたします。'],
        ['q' => '対応エリアはどこですか？',
         'a' => '愛知県を中心に対応しております。案件内容によっては近隣エリアも対応可能ですので、まずはお気軽にご相談ください。'],
        ['q' => 'LINOVAに依頼するメリットは何ですか？',
         'a' => 'LINOVAは単に工事を行う会社ではありません。調査・見積・施工管理・完了報告までをワンストップで対応し、さらに独自の案件・報告共有システムにより、工事の進捗や施工内容を写真付きで分かりやすく共有しています。建物の課題解決と、管理会社様・オーナー様の業務負担軽減を両立できることが、LINOVAの強みです。'],
    ];
}

/**
 * FAQ アコーディオン1件を出力（front/専用ページ共用）。
 * $q=質問(plain) / $a_html=回答HTML(サニタイズ済) / $cat_slugs=工事種別slug配列(JSフィルタ用)
 */
function linova_faq_item($q, $a_html, $cat_slugs = []) {
    $data = $cat_slugs ? ' data-cats="' . esc_attr(implode(' ', $cat_slugs)) . '"' : '';
    printf(
        '<details class="faq-item"%s><summary class="faq-q"><span class="faq-badge q">Q</span><span class="faq-qt">%s</span><i data-lucide="chevron-down" class="faq-chev"></i></summary><div class="faq-a"><span class="faq-badge a">A</span><div class="faq-at">%s</div></div></details>',
        $data,
        esc_html($q),
        $a_html
    );
}

/**
 * 既存10件を faq 投稿として自動生成（冪等・1度だけ）。工事種別も付与。
 */
add_action('init', function () {
    if (get_option('linova_faq_seed_done')) {
        return;
    }
    if (!post_type_exists('faq')) {
        return; // CPT未登録なら次回
    }
    // 原子ロック（add_optionは既存キーで false）→ 初回同時アクセスの重複seed防止
    if (!add_option('linova_faq_seed_lock', 1, '', 'no')) {
        return;
    }
    // 既にfaq投稿が1件でもあれば seed しない（手動運用済とみなす）
    $existing = get_posts(['post_type' => 'faq', 'posts_per_page' => 1, 'fields' => 'ids', 'post_status' => 'any']);
    if (empty($existing)) {
        $cat_map = [6 => '漏水調査']; // index6=漏水質問のみ明示。他は全般（index5「店舗営業」の内装誤分類を撤去）
        foreach (linova_faqs() as $i => $faq) {
            $id = wp_insert_post([
                'post_type'    => 'faq',
                'post_status'  => 'publish',
                'post_title'   => $faq['q'],
                'post_content' => $faq['a'],
                'menu_order'   => $i,
            ]);
            if ($id && !is_wp_error($id)) {
                $cat = $cat_map[$i] ?? '全般';
                wp_set_object_terms($id, $cat, 'faq_cat');
            }
        }
    }
    update_option('linova_faq_seed_done', 1);
}, 20);

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
 * 施工事例 保存時: 工事種別(work_cat)未設定なら work_category テキストから自動付与。
 * ACFの「カテゴリ」だけ埋めてタームを付け忘れても一覧フィルタで消えないようにする。
 */
add_action('save_post_work', function ($post_id) {
    if (wp_is_post_revision($post_id) || (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)) return;
    $existing = wp_get_object_terms($post_id, 'work_cat', ['fields' => 'ids']);
    if (!is_wp_error($existing) && !empty($existing)) return; // 手動選択済は尊重
    $label = function_exists('get_field') ? (string) get_field('work_category', $post_id) : '';
    if ($label === '') return;
    $map = [
        '店舗' => 'store', '内装' => 'interior', '防水' => 'waterproof',
        '屋根' => 'roof', '板金' => 'roof', '外壁' => 'wall', '塗装' => 'wall',
        '雨漏' => 'leak', '漏水' => 'leak', '大規模' => 'large', '改修' => 'large',
        '外構' => 'exterior', '設備' => 'facility',
    ];
    $slugs = [];
    foreach ($map as $kw => $slug) {
        if (mb_strpos($label, $kw) !== false) $slugs[] = $slug;
    }
    $slugs = array_values(array_unique($slugs));
    if ($slugs) wp_set_object_terms($post_id, $slugs, 'work_cat');
}, 20);

/**
 * 施工事例 保存時: スラッグが日本語/非ASCIIなら work-<ID> の番号スラッグに置換。
 * （日本語スラッグはURLエンコードされ長く可読性が低いため）
 */
add_action('save_post_work', function ($post_id, $post) {
    if (wp_is_post_revision($post_id) || (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)) return;
    if (in_array($post->post_status, ['auto-draft', 'trash'], true)) return;
    static $running = false;
    if ($running) return;
    $slug = $post->post_name;
    // 非ASCII含む or 空 or URLエンコード(%xx)なら番号スラッグへ
    if ($slug === '' || preg_match('/[^\x20-\x7E]/', $slug) || strpos($slug, '%') !== false) {
        $desired = 'work-' . $post_id;
        if ($slug !== $desired) {
            $running = true;
            wp_update_post(['ID' => $post_id, 'post_name' => $desired]);
            $running = false;
        }
    }
}, 25, 2);

/**
 * テーマ有効化時: CPT/タクソノミを登録してから rewrite ルールをフラッシュ。
 * 有効化直後の /works/・アーカイブ404を防ぐ。
 */
add_action('after_switch_theme', function () {
    linova_register_post_types();
    linova_ensure_work_terms();
    linova_ensure_faq_terms();
    flush_rewrite_rules();
});

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
