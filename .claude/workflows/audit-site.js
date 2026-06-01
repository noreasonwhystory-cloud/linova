export const meta = {
  name: 'audit-site',
  description: '静的サイトを SEO・アクセシビリティ・レスポンシブ観点で監査',
  phases: [{ title: 'Audit' }],
}

const ISSUES = {
  type: 'object',
  properties: {
    issues: {
      type: 'array',
      items: {
        type: 'object',
        properties: { file: { type: 'string' }, title: { type: 'string' }, detail: { type: 'string' } },
        required: ['file', 'title', 'detail'],
      },
    },
  },
  required: ['issues'],
}

const LENSES = [
  { key: 'seo', prompt: 'HTML を確認し、SEO 問題（title/meta description 欠落・見出し階層・OGP）を洗い出せ。' },
  { key: 'a11y', prompt: 'HTML を確認し、アクセシビリティ問題（alt・aria・ラベル・コントラスト）を洗い出せ。' },
  { key: 'responsive', prompt: 'HTML/CSS を確認し、レスポンシブ問題（viewport・固定幅・はみ出し）を洗い出せ。' },
]

const audited = await parallel(LENSES.map(l => () =>
  agent(l.prompt, { label: `audit:${l.key}`, phase: 'Audit', schema: ISSUES })))

return { issues: audited.filter(Boolean).flatMap(r => r.issues) }
