<?php
if (!defined('ABSPATH')) exit;
$p   = linova_profile();
$img = get_template_directory_uri() . '/assets/images';
$home = home_url('/');
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div class="page">

  <!-- ===== HEADER ===== -->
  <header class="hdr">
    <a class="brand" href="<?php echo esc_url($home); ?>">
      <img class="logo-img" src="<?php echo esc_url($img); ?>/logo.png" alt="<?php echo esc_attr($p['siteName']); ?>">
    </a>
    <nav class="nav-desktop">
      <a href="<?php echo esc_url($home . '#service'); ?>">サービス</a>
      <a href="<?php echo esc_url($home . '#works'); ?>">施工事例</a>
      <a href="<?php echo esc_url($home . '#strength'); ?>">LINOVAの強み</a>
      <a href="<?php echo esc_url($home . '#area'); ?>">対応エリア</a>
      <a href="<?php echo esc_url($home . '#faq'); ?>">よくあるご質問</a>
      <a href="<?php echo esc_url($home . '#about'); ?>">会社情報</a>
    </nav>
    <div class="hdr-actions">
      <a class="hdr-tel" href="tel:<?php echo esc_attr($p['phone']); ?>">
        <i data-lucide="phone"></i>
        <span class="col"><b><?php echo esc_html($p['phoneDisplay']); ?></b><small><?php echo esc_html($p['hours']); ?></small></span>
      </a>
      <a class="hdr-line" href="<?php echo esc_url($p['lineUrl']); ?>"><span class="line-badge">LINE</span><span class="hl-label">LINEで相談</span></a>
      <a class="hdr-contact" href="<?php echo esc_url($home . '#contact'); ?>"><i data-lucide="mail"></i>お問い合わせ</a>
      <button class="burger" id="openNav" aria-label="メニュー"><i data-lucide="menu"></i></button>
    </div>
  </header>

  <!-- ===== NAV OVERLAY (mobile) ===== -->
  <nav class="navmenu" id="navmenu">
    <div class="nav-top">
      <img class="logo-img logo-white" src="<?php echo esc_url($img); ?>/logo-white.png" alt="<?php echo esc_attr($p['siteName']); ?>">
      <button class="nav-close" id="closeNav" aria-label="閉じる"><i data-lucide="x"></i></button>
    </div>
    <div class="nav-links">
      <a href="<?php echo esc_url($home); ?>" data-nav>トップ <span>HOME</span></a>
      <a href="<?php echo esc_url($home . '#about'); ?>" data-nav>会社情報 <span>ABOUT</span></a>
      <a href="<?php echo esc_url($home . '#service'); ?>" data-nav>対応サービス <span>SERVICE</span></a>
      <a href="<?php echo esc_url($home . '#works'); ?>" data-nav>施工事例 <span>WORKS</span></a>
      <a href="<?php echo esc_url($home . '#strength'); ?>" data-nav>LINOVAの強み <span>STRENGTH</span></a>
      <a href="<?php echo esc_url($home . '#area'); ?>" data-nav>対応エリア <span>AREA</span></a>
      <a href="<?php echo esc_url($home . '#faq'); ?>" data-nav>よくあるご質問 <span>FAQ</span></a>
      <a href="<?php echo esc_url($home . '#contact'); ?>" data-nav>お問い合わせ <span>CONTACT</span></a>
    </div>
    <div class="nav-foot">
      <a class="btn-line" href="<?php echo esc_url($p['lineUrl']); ?>" data-nav>
        <span class="line-badge">LINE</span>
        <span class="col"><span class="t1">LINEで相談する</span><span class="t2">24時間受付中</span></span>
      </a>
      <a class="nav-tel" href="tel:<?php echo esc_attr($p['phone']); ?>"><i data-lucide="phone"></i> <?php echo esc_html($p['phoneDisplay']); ?>（9:00〜18:00）</a>
    </div>
  </nav>
