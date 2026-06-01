# hp-linova

客様向けLP（ランディングページ）。

## 構成
- 静的サイト (index.html + assets/)

## ローカル確認
- ブラウザで `index.html` 直接開く
- or `python -m http.server` で配信

## デプロイ
- 静的ホスティング (XServer FTP, Vercel, Netlify 等)

## Dynamic Workflows

`.claude/workflows/` に保存済ワークフロー（.js）。Workflow ツールで `{name: "<meta.name>"}` 呼び出し。

- 起動には明示オプトイン必須: メッセージに `workflow` キーワード or 明示依頼（settings.json の許可はプロンプト抑制のみ・オプトインは別途必要）
- スクリプトは JavaScript。`export const meta = {...}` 始まり必須
- `agent()` / `parallel()` / `pipeline()` / `phase()` / `log()` 使用可。デフォルトは `pipeline()`
- 進捗は `/workflows` で確認。バックグラウンド実行 → 完了通知
