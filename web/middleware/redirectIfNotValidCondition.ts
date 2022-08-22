/**
 * urlにcondition=trueクエリが存在しない場合にリダイレクトさせる
 *
 * @param query
 * @param redirect
 */
// @ts-ignore
export default function ({ query, redirect }) {
  if (!query.condition) {
    redirect('/register/condition')
  }
}
