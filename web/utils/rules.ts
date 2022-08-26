export const email_rules = [
  (email: string): boolean | string => !!email || 'メールアドレスを入力してください.'
]

export const password_rules = [
  (password: string): boolean | string => !!password || 'パスワードを入力してください.',
  (password: string): boolean | string => (password && password.length >= 8) || 'パスワードは8文字以上で入力してください.'
]

export const family_name_rules = [
  (family_name: string): boolean | string => !!family_name || '姓を入力してください.'
]

export const last_name_rules = [
  (last_name: string): boolean | string => !!last_name || '名を入力してください.'
]

export const family_name_yomi_rules = [
  (family_name_yomi: string): boolean | string => !!family_name_yomi || 'セイを入力してください.'
]

export const last_name_yomi_rules = [
  (last_name_yomi: string): boolean | string => !!last_name_yomi || 'メイを入力してください.'
]

export const phone_number_rules = [
  (phone_number: string): boolean | string => !!phone_number || '電話番号を入力してください.'
]
