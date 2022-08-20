// @ts-ignore
export default function ({ query, redirect }) {
  if (!query.condition) {
    redirect('/register/condition')
  }
}
