<?php
if (!defined('ABSPATH')) exit;
get_header();
$p   = linova_profile();
$img = get_template_directory_uri() . '/assets/images';
$home = home_url('/');
?>

  <!-- ===== HERO ===== -->
  <section class="hero" id="top">
    <img class="hero-bg" fetchpriority="high" src="<?php echo esc_url($img); ?>/hero.png" alt="">
    <div class="ov"></div>
    <div class="hero-in">
      <div class="hero-top">
        <h1>住まいの課題を、<br>最適な解決へ。</h1>
        <p class="sub">調査・提案から施工管理まで、<br>一貫してサポートします。</p>
        <a class="hero-cta" href="<?php echo esc_url($home . '#service'); ?>">サービスを見る <span class="arr">→</span></a>
      </div>
      <div class="hero-bottom">
        <div class="feat-row">
          <div class="feat"><i data-lucide="search-check"></i><span>調査・診断</span></div>
          <div class="feat"><i data-lucide="clipboard-list"></i><span>提案・お見積り</span></div>
          <div class="feat"><i data-lucide="hard-hat"></i><span>施工管理</span></div>
          <div class="feat"><i data-lucide="house"></i><span>アフターフォロー</span></div>
        </div>
        <div class="scroll-cue"><i data-lucide="chevron-down"></i></div>
      </div>
    </div>
  </section>

  <!-- ===== ABOUT (intro) ===== -->
  <section class="section soft about-sec" id="about">
    <div class="inner about-grid">
      <div class="about-tx">
        <span class="eyebrow">ABOUT</span>
        <h2 class="display">法人・管理会社様のパートナーとして、確かな品質とスムーズな施工を。</h2>
        <div class="about-img-m"><img loading="lazy" decoding="async" src="<?php echo esc_url($img); ?>/about.png" alt="LINOVA 打ち合わせの様子"></div>
        <p class="lead">LINOVAは、外装・防水・板金・内装・外構など、建物に関するさまざまな課題に対応します。</p>
        <p class="lead">調査・提案から施工管理、アフターフォローまで一貫してサポートし、ご担当者様の負担を軽減します。</p>
      </div>
      <div class="about-media">
        <img loading="lazy" decoding="async" src="<?php echo esc_url($img); ?>/about.png" alt="LINOVA 打ち合わせの様子">
      </div>
    </div>
  </section>

  <!-- ===== FLOW ===== -->
  <section class="section flow-sec">
    <div class="inner">
      <div class="flow-head">
        <div class="flow-title">
          <span class="eyebrow">FLOW</span>
          <h2 class="display">課題ごとに、<br>最適な解決策を。</h2>
        </div>
        <div class="flow-lead">
          <p class="lead">雨漏りや外壁の劣化、防水不良など、住まいの課題は一つとして同じものはありません。</p>
          <p class="lead">LINOVAは調査から提案、施工管理まで一貫して対応し、状況に合わせた最適な解決策をご提案します。</p>
        </div>
      </div>
      <div class="flow-grid">
        <div class="flow-step">
          <div class="fs-head"><span class="fs-no">01</span><span class="fs-ic"><i data-lucide="search"></i></span></div>
          <h3>調査</h3><p>現地調査・原因特定</p>
          <img loading="lazy" decoding="async" class="fs-img" src="<?php echo esc_url($img); ?>/flow-1-chosa.png" alt="調査">
        </div>
        <div class="flow-step">
          <div class="fs-head"><span class="fs-no">02</span><span class="fs-ic"><i data-lucide="clipboard-list"></i></span></div>
          <h3>提案</h3><p>最適な工法と予算をご提案</p>
          <img loading="lazy" decoding="async" class="fs-img" src="<?php echo esc_url($img); ?>/flow-2-teian.png" alt="提案">
        </div>
        <div class="flow-step">
          <div class="fs-head"><span class="fs-no">03</span><span class="fs-ic"><i data-lucide="hard-hat"></i></span></div>
          <h3>施工管理</h3><p>専門業者と連携し品質を管理</p>
          <img loading="lazy" decoding="async" class="fs-img" src="<?php echo esc_url($img); ?>/flow-3-kanri.png" alt="施工管理">
        </div>
        <div class="flow-step">
          <div class="fs-head"><span class="fs-no">04</span><span class="fs-ic"><i data-lucide="house"></i></span></div>
          <h3>アフターフォロー</h3><p>施工後もしっかりサポート</p>
          <img loading="lazy" decoding="async" class="fs-img" src="<?php echo esc_url($img); ?>/flow-4-after.png" alt="アフターフォロー">
        </div>
      </div>
    </div>
  </section>

  <!-- ===== SERVICE ===== -->
  <section class="section soft" id="service">
    <div class="inner">
      <div class="sec-head">
        <span class="eyebrow">SERVICE</span>
        <h2 class="sec-title">対応サービス</h2>
        <p class="lead">住まいのさまざまな課題に対応するため、幅広い工事に対応しています。</p>
      </div>
      <div class="svc-grid">
        <?php
        // [写真ファイル, アイコンファイル, タイトル, 説明]
        $services = [
            ['svc-1-gaiheki.png', 'svc-icon-1.png', '外壁工事', '塗装・補修・張り替えなど、外壁に関する工事全般に対応。'],
            ['svc-2-bousui.png',  'svc-icon-2.png', '防水工事', '屋上・バルコニー・ベランダなどの防水工事を行います。'],
            ['svc-3-bankin.png',  'svc-icon-3.png', '板金工事', '屋根・雨樋・笠木などの板金工事で建物を雨風から守ります。'],
            ['svc-4-rousui.png',  'svc-icon-4.png', '漏水調査', '雨漏りの原因を徹底調査し、最適な修繕方法をご提案。'],
            ['svc-5-naisou.png',  'svc-icon-5.png', '内装工事', '天井・壁・床などの内装工事で快適な空間づくりをサポート。'],
            ['svc-6-gaikou.png',  'svc-icon-6.png', '外構工事', 'エクステリア・フェンス・駐車場など外構工事にも対応可能。'],
        ];
        foreach ($services as $s) :
            $photo = linova_asset_img($s[0]);
            $icon  = linova_asset_img($s[1]);
        ?>
          <div class="svc">
            <div class="svc-media">
              <?php if ($photo) : ?><img loading="lazy" decoding="async" src="<?php echo esc_url($photo); ?>" alt="<?php echo esc_attr($s[2]); ?>"><?php endif; ?>
              <?php if ($icon) : ?><span class="svc-icon"><img loading="lazy" decoding="async" src="<?php echo esc_url($icon); ?>" alt=""></span><?php endif; ?>
            </div>
            <div class="svc-body"><h3><?php echo esc_html($s[2]); ?></h3><p><?php echo esc_html($s[3]); ?></p><span class="chev"><i data-lucide="chevron-right"></i></span></div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- ===== 最新の解決事例 ===== -->
  <section class="section" id="solutions">
    <div class="inner">
      <div class="sec-head sol-head">
        <div class="sol-titles">
          <span class="eyebrow">NEW</span>
          <h2 class="sec-title">最新の解決事例</h2>
          <p class="lead">建物のあらゆる課題に、迅速・丁寧に対応します。</p>
        </div>
      </div>

      <div class="sol-wrap">
        <button class="sol-arrow prev" id="solPrev" aria-label="前へ"><i data-lucide="chevron-left"></i></button>
        <div class="sol-track" id="solTrack">
          <?php
          $sq = new WP_Query([
              'post_type'      => 'work',
              'posts_per_page' => 8,
              'orderby'        => 'date',
              'order'          => 'DESC',
              'no_found_rows'  => true,
          ]);
          if ($sq->have_posts()) :
              while ($sq->have_posts()) : $sq->the_post();
                  $img_url = linova_card_image();
                  ?>
                  <article class="sol-card">
                    <div class="sol-media">
                      <?php if ($img_url) : ?><img loading="lazy" decoding="async" src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr(get_the_title()); ?>"><?php endif; ?>
                      <?php if ($cat = linova_field('work_category')) : ?><span class="sol-cat"><?php echo esc_html($cat); ?></span><?php endif; ?>
                    </div>
                    <div class="sol-body">
                      <h3><?php the_title(); ?></h3>
                      <p><?php echo esc_html(wp_trim_words(get_the_excerpt(), 40)); ?></p>
                      <a class="sol-link" href="<?php the_permalink(); ?>">詳しく見る <span class="arr">→</span></a>
                    </div>
                  </article>
                  <?php
              endwhile; wp_reset_postdata();
          else :
              // work 投稿が無い間のフォールバック（提供の4カード）
              $sol_fallback = [
                  ['case-1-after.png', '店舗改修工事',   '飲食店改修工事',       '店舗リニューアルに伴う外装・内装・設備工事を一括対応。'],
                  ['case-2-after.png', '防水工事',       '屋上ウレタン防水工事', '屋上の防水層の劣化を解消し、長期的に安心できる防水性能を確保。'],
                  ['case-3-after.png', '屋根工事',       '屋根カバー工法工事',   '既存の屋根材を活かしたカバー工法で、雨漏りを解消し屋根の寿命を延ばす。'],
                  ['case-4-after.png', '外壁塗装工事',   '外壁塗装工事',         '外壁の劣化を補修し、美観と耐久性を向上。資産価値を守ります。'],
              ];
              $sol_link = get_post_type_archive_link('work') ?: $home . '#works';
              foreach ($sol_fallback as $c) : ?>
                <article class="sol-card">
                  <div class="sol-media">
                    <img loading="lazy" decoding="async" src="<?php echo esc_url(linova_asset_img($c[0])); ?>" alt="<?php echo esc_attr($c[2]); ?>">
                    <span class="sol-cat"><?php echo esc_html($c[1]); ?></span>
                  </div>
                  <div class="sol-body">
                    <h3><?php echo esc_html($c[2]); ?></h3>
                    <p><?php echo esc_html($c[3]); ?></p>
                    <a class="sol-link" href="<?php echo esc_url($sol_link); ?>">詳しく見る <span class="arr">→</span></a>
                  </div>
                </article>
              <?php endforeach;
          endif; ?>
        </div>
        <button class="sol-arrow next" id="solNext" aria-label="次へ"><i data-lucide="chevron-right"></i></button>
      </div>
      <div class="sol-dots" id="solDots"></div>
      <a class="works-more sol-more" href="<?php echo esc_url(get_post_type_archive_link('work') ?: $home . '#works'); ?>">すべての施工事例を見る <i data-lucide="arrow-right"></i></a>
    </div>
  </section>

  <!-- ===== WORKS ===== -->
  <section class="section" id="works">
    <div class="inner">
      <div class="sec-head works-head">
        <div>
          <span class="eyebrow">WORKS</span>
          <h2 class="sec-title">施工事例</h2>
          <p class="lead">これまでの施工事例の一部をご紹介します。小規模な修繕から大規模改修まで幅広く対応しています。</p>
        </div>
      </div>
      <div class="works">
        <?php
        $wq = new WP_Query(['post_type' => 'work', 'posts_per_page' => 6, 'no_found_rows' => true]);
        if ($wq->have_posts()) :
          while ($wq->have_posts()) : $wq->the_post();
            $before = linova_field('before_image');
            $after  = linova_field('after_image');
            $before_url = is_array($before) ? ($before['sizes']['large'] ?? $before['url'] ?? '') : ($before ?: '');
            $after_url  = is_array($after)  ? ($after['sizes']['large']  ?? $after['url']  ?? '') : ($after ?: '');
            if (!$after_url && has_post_thumbnail()) { $after_url = get_the_post_thumbnail_url(null, 'large'); }
            ?>
            <article class="case">
              <a class="case-media" href="<?php the_permalink(); ?>">
                <?php if ($before_url) : ?><img loading="lazy" decoding="async" src="<?php echo esc_url($before_url); ?>" alt="施工前"><?php endif; ?>
                <?php if ($after_url) : ?><img loading="lazy" decoding="async" src="<?php echo esc_url($after_url); ?>" alt="施工後"><?php endif; ?>
                <span class="ba-tag before">BEFORE</span><span class="ba-tag after">AFTER</span>
                <span class="ba-arrow"><i data-lucide="chevron-right"></i></span>
              </a>
              <div class="case-tx">
                <?php if ($cat = linova_field('work_category')) : ?><span class="case-cat"><?php echo esc_html($cat); ?></span><?php endif; ?>
                <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                <p><?php echo esc_html(wp_trim_words(get_the_excerpt(), 50)); ?></p>
                <div class="case-meta">
                  <?php if ($loc = linova_field('location')) : ?><span><i data-lucide="map-pin"></i><?php echo esc_html($loc); ?></span><?php endif; ?>
                  <?php if ($cmp = linova_field('completed_at')) : ?><span><i data-lucide="calendar"></i><?php echo esc_html($cmp); ?></span><?php endif; ?>
                </div>
              </div>
            </article>
          <?php endwhile; wp_reset_postdata();
        else :
          // 施工事例未入稿時の静的フォールバック（P2で入稿後はCPTに切替）
          $fallback = [
            ['case-1', '雨漏り修繕', '屋上からの雨漏りを解消', '原因調査から防水工事まで一貫して対応しました。', '名古屋市中区／マンション', '2024年3月完工'],
            ['case-2', '外壁補修・塗装工事', '外壁の劣化を補修し、美観と耐久性を向上', 'ひび割れ補修と塗装により、建物の寿命を延ばしました。', '岐阜市／戸建住宅', '2024年2月完工'],
            ['case-3', '板金工事', '強風で破損した屋根を板金工事で復旧', '強風により破損した屋根をガルバリウム鋼板で復旧しました。', '四日市市／工場', '2024年1月完工'],
            ['case-4', '大規模改修工事', '共用部の改修で資産価値を向上', '外壁・防水・シーリング工事など大規模改修を行いました。', '名古屋市／マンション', '2023年11月完工'],
          ];
          foreach ($fallback as $c) : ?>
            <article class="case">
              <div class="case-media">
                <img loading="lazy" decoding="async" src="<?php echo esc_url($img . '/' . $c[0] . '-before.png'); ?>" alt="施工前">
                <img loading="lazy" decoding="async" src="<?php echo esc_url($img . '/' . $c[0] . '-after.png'); ?>" alt="施工後">
                <span class="ba-tag before">BEFORE</span><span class="ba-tag after">AFTER</span>
                <span class="ba-arrow"><i data-lucide="chevron-right"></i></span>
              </div>
              <div class="case-tx">
                <span class="case-cat"><?php echo esc_html($c[1]); ?></span>
                <h3><?php echo esc_html($c[2]); ?></h3>
                <p><?php echo esc_html($c[3]); ?></p>
                <div class="case-meta">
                  <span><i data-lucide="map-pin"></i><?php echo esc_html($c[4]); ?></span>
                  <span><i data-lucide="calendar"></i><?php echo esc_html($c[5]); ?></span>
                </div>
              </div>
            </article>
          <?php endforeach;
        endif; ?>
      </div>
    </div>
  </section>

  <!-- ===== STRENGTH ===== -->
  <section class="section soft" id="strength">
    <div class="inner">
      <div class="sec-head">
        <span class="eyebrow">STRENGTH</span>
        <h2 class="sec-title">LINOVAの強み</h2>
        <p class="lead">調査から施工管理まで一貫して対応することで、元請け様の負担を軽減し、確かな品質をお届けします。</p>
      </div>
      <div class="str-list">
        <div class="str">
          <div class="str-ic"><i data-lucide="share-2"></i></div>
          <div class="str-tx">
            <div class="str-no">01</div>
            <h3>専門業者ネットワーク</h3>
            <div class="role">必要な工事を最適な体制で対応</div>
            <p>各分野の専門業者と連携し、工事内容に応じて最適なチームを編成。高品質な工事を実現します。</p>
          </div>
        </div>
        <div class="str">
          <div class="str-ic"><i data-lucide="clipboard-check"></i></div>
          <div class="str-tx">
            <div class="str-no">02</div>
            <h3>調査から施工管理まで</h3>
            <div class="role">窓口を一本化</div>
            <p>調査・提案から施工管理、アフターフォローまで一貫して対応。やり取りの手間を減らし、スムーズに進行します。</p>
          </div>
        </div>
        <div class="str">
          <div class="str-ic"><i data-lucide="building-2"></i></div>
          <div class="str-tx">
            <div class="str-no">03</div>
            <h3>小さな修繕から各種改修工事まで対応</h3>
            <div class="role">外装・防水・板金・内装・外構まで幅広く対応</div>
            <p>調査・提案・施工管理まで一貫サポートいたします。</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ===== CTA BANNER (mobile only) ===== -->
  <section class="cta">
    <div class="ov"></div>
    <div class="cta-in">
      <h3>住まいの課題解決は、私たちにお任せください。</h3>
      <a href="<?php echo esc_url($home . '#contact'); ?>">お問い合わせ・ご相談はこちら <i data-lucide="chevron-right"></i></a>
    </div>
  </section>

  <!-- ===== AREA ===== -->
  <section class="section" id="area">
    <div class="inner">
      <div class="sec-head">
        <span class="eyebrow">AREA</span>
        <h2 class="sec-title">対応エリア</h2>
        <p class="lead">愛知・岐阜・三重エリアを中心に幅広く対応しています。</p>
      </div>
      <div class="area-grid">
        <div class="map">
          <img loading="lazy" decoding="async" src="<?php echo esc_url($img); ?>/area-map.png" alt="対応エリアマップ（愛知県・岐阜県・三重県）">
        </div>
        <div class="area-side">
          <div class="area-note">
            <div class="ni"><i data-lucide="building-2"></i></div>
            <div><b>上記エリア以外でも対応可能な場合があります。</b><span>まずはお気軽にご相談ください。</span></div>
          </div>
          <div class="area-list">
            <div class="area-row"><i data-lucide="map-pin"></i><div><b>愛知県</b><span>名古屋市を中心に全域対応</span></div></div>
            <div class="area-row"><i data-lucide="map-pin"></i><div><b>岐阜県</b><span>岐阜市・大垣市・多治見市などを中心に対応</span></div></div>
            <div class="area-row"><i data-lucide="map-pin"></i><div><b>三重県</b><span>四日市市・津市・鈴鹿市などを中心に対応</span></div></div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ===== FAQ ===== -->
  <section class="section faq-sec" id="faq">
    <div class="inner">
      <div class="sec-head" style="text-align:center">
        <span class="eyebrow">FAQ</span>
        <h2 class="sec-title">よくあるご質問</h2>
        <p class="lead">LINOVAによくいただくご質問をまとめました。<br>ご不明点がありましたら、お気軽にご相談ください。</p>
      </div>
      <div class="faq-list">
        <?php
        $fq = new WP_Query([
            'post_type'      => 'faq',
            'posts_per_page' => LINOVA_FAQ_TOP,
            'orderby'        => 'menu_order date',
            'order'          => 'ASC',
            'no_found_rows'  => true,
        ]);
        if ($fq->have_posts()) :
            while ($fq->have_posts()) : $fq->the_post();
                linova_faq_item(get_the_title(), apply_filters('the_content', get_the_content()));
            endwhile; wp_reset_postdata();
        else :
            foreach (array_slice(linova_faqs(), 0, LINOVA_FAQ_TOP) as $faq) {
                linova_faq_item($faq['q'], wpautop(esc_html($faq['a'])));
            }
        endif;
        ?>
      </div>
      <a class="works-more faq-more" href="<?php echo esc_url($home . 'faq/'); ?>">
        <i data-lucide="help-circle"></i> すべてのご質問を見る <i data-lucide="arrow-right"></i>
      </a>
      <p class="faq-note">その他のご質問もこちらからご確認いただけます。</p>
    </div>
  </section>

  <!-- ===== CONTACT ===== -->
  <section class="section soft" id="contact">
    <div class="inner contact-grid">
      <div class="contact-intro">
        <span class="eyebrow">CONTACT</span>
        <h2 class="sec-title">工事のご相談はこちら</h2>
        <p class="lead">住まいのトラブルから改修工事まで、お気軽にご相談ください。現地調査・お見積りは無料です。</p>
        <div class="contact-direct">
          <a class="cd-tel" href="tel:<?php echo esc_attr($p['phone']); ?>"><i data-lucide="phone"></i><span class="col"><b><?php echo esc_html($p['phoneDisplay']); ?></b><small><?php echo esc_html($p['hours']); ?></small></span></a>
          <a class="cd-line" href="<?php echo esc_url($p['lineUrl']); ?>"><span class="line-badge">LINE</span>LINEで相談する</a>
          <a class="cd-mail" href="mailto:<?php echo esc_attr($p['email']); ?>"><i data-lucide="mail"></i><?php echo esc_html($p['email']); ?></a>
        </div>
      </div>
      <div class="form-card">
        <h3>お問い合わせフォーム</h3>
        <?php
        if (shortcode_exists('contact-form-7')) {
            echo do_shortcode(linova_cf7_shortcode());
        } else {
            // CF7未設定時の静的フォールバック（P4でCF7に置換）
            ?>
            <p class="fsub">下記フォームに必要事項をご入力のうえ、送信してください。</p>
            <div class="form-row">
              <div class="field"><label for="lf-name">お名前 <span class="req">必須</span></label><input id="lf-name" type="text" placeholder="例）山田 太郎"></div>
              <div class="field"><label for="lf-company">会社名 <span class="req">必須</span></label><input id="lf-company" type="text" placeholder="例）株式会社○○建設"></div>
            </div>
            <div class="form-row">
              <div class="field"><label for="lf-tel">電話番号 <span class="req">必須</span></label><input id="lf-tel" type="tel" placeholder="例）090-1234-5678"></div>
              <div class="field"><label for="lf-email">メールアドレス <span class="req">必須</span></label><input id="lf-email" type="email" placeholder="例）info@linova-works.com"></div>
            </div>
            <div class="field"><label for="lf-msg">ご相談内容 <span class="req">必須</span></label><textarea id="lf-msg" placeholder="例）雨漏りの調査・修繕について相談したい"></textarea></div>
            <p style="font-size:12px;color:var(--muted);margin-top:6px">※フォームは現在準備中です。お電話・LINEでお問い合わせください。</p>
            <?php
        }
        ?>
      </div>
    </div>
  </section>

<?php get_footer(); ?>
