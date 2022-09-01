import { Dayjs, locale } from 'dayjs'
import 'dayjs/locale/ja'

export function toStringDay (date: Dayjs) {
  locale('ja')
  return date.format('YYYY/MM/DD(dd)')
}

export function toStringTime (date: Dayjs) {
  locale('ja')
  return date.format('HH:mm')
}
