# hp-linova（LINOVA WordPress テーマ）

客様向けLP → WordPress カスタムテーマ化。住まいの課題解決（外装・防水・板金・内装・外構）の集客サイト。

## 構成
- WordPress カスタムテーマ（手書き・なべさん方式）。本体は `wp-theme/linova/`
- 施工事例=CPT `work`（ACF: before_image/after_image/work_category/location/completed_at）
- お知らせ/ブログ=WP標準投稿+カテゴリ（お知らせ/ブログ）
- 問合せ=Contact Form 7
- アイコン=Lucide(CDN)、フォント=Google Fonts(Montserrat/Noto Sans JP/Noto Serif JP)

## デプロイ（本番直結）
- 本番: https://linova-works.com （XServer・サーバーID gaihekinabe/sv17070・なべさんと同サーバー別ドメイン別DB `gaihekinabe_wp4`）
- main push → GitHub Actions(`SamKirkland/FTP-Deploy-Action`) → FTPS同期 → `linova-works.com/public_html/wp-content/themes/linova/`
- トリガー: `wp-theme/**` 変更時のみ。専用サブFTP `linova@linova-works.com` 使用（なべさんと分離）
- Secrets: `XSERVER_FTP_HOST` / `XSERVER_FTP_USER` / `XSERVER_FTP_PASSWORD`（linovaリポに設定済）

## 注意
- **public_html ルートを同期しない**（WP本体破壊防止）。同期対象はテーマフォルダのみ
- push = 即本番反映。テーマ変更は慎重に
- 改行 LF→CRLF 警告は無視可（Windows）
- プラグイン: Advanced Custom Fields / Contact Form 7（管理画面で導入・有効化）

## Dynamic Workflows

`.claude/workflows/` に保存済ワークフロー（.js）。Workflow ツールで `{name: "<meta.name>"}` 呼び出し。

- 起動には明示オプトイン必須: メッセージに `workflow` キーワード or 明示依頼
- スクリプトは JavaScript。`export const meta = {...}` 始まり必須
- `agent()` / `parallel()` / `pipeline()` / `phase()` / `log()` 使用可。デフォルトは `pipeline()`
- 進捗は `/workflows` で確認
