import dayjs, { Dayjs, locale } from 'dayjs'
import { Status, toStatus } from '~/utils/const/status'
import 'dayjs/locale/ja'
import { toStringDay, toStringTime } from '~/utils/time'

export class Event {
  private readonly id: number
  private readonly name: string
  private readonly applicationStartDate: Dayjs
  private readonly dueDate: Dayjs
  private readonly beginDate: Dayjs
  private readonly endDate: Dayjs
  private readonly price: number
  private readonly status: Status
  private readonly canReserve: boolean
  private readonly maxReservationCount: number
  private readonly isFull: boolean

  constructor (
    id: number,
    name: string,
    applicationStateDate: string,
    dueDate: string,
    beginDate: string,
    endDate: string,
    price: number,
    status: string,
    canReserve: boolean,
    maxReservationCount: number,
    isFull: boolean
  ) {
    locale('ja')

    this.id = id
    this.name = name
    this.applicationStartDate = dayjs(applicationStateDate)
    this.dueDate = dayjs(dueDate)
    this.beginDate = dayjs(beginDate)
    this.endDate = dayjs(endDate)
    this.price = price
    this.status = toStatus(status)
    this.canReserve = canReserve
    this.maxReservationCount = maxReservationCount
    this.isFull = isFull
  }

  get getId () {
    return this.id
  }

  get getName () {
    return this.name
  }

  get isHeldSameDate () {
    return dayjs(this.beginDate).isSame(this.endDate, 'days')
  }

  get stringApplicationStartDay () {
    return toStringDay(this.applicationStartDate)
  }

  get stringApplicationStartTime () {
    return toStringTime(this.applicationStartDate)
  }

  get stringDueDay () {
    return toStringDay(this.dueDate)
  }

  get stringDueTime () {
    return toStringTime(this.dueDate)
  }

  get stringBeginDay () {
    return toStringDay(this.beginDate)
  }

  get stringBeginTime () {
    return toStringTime(this.beginDate)
  }

  get stringEndDay () {
    return toStringDay(this.endDate)
  }

  get stringEndTime () {
    return toStringTime(this.endDate)
  }

  get isFree () {
    return this.price === 0
  }

  get getPrice () {
    return this.price
  }

  get isBeforeApplication () {
    return dayjs().isBefore(this.applicationStartDate)
  }

  get isInApplication () {
    const now = dayjs()
    return now.isAfter(this.applicationStartDate) && now.isBefore(this.dueDate)
  }

  get hasFinishedApplication () {
    return dayjs().isAfter(this.dueDate) && this.status === Status.LOTTERY_APPLICATIONS
  }

  get isInLottery () {
    return this.status === Status.PENDING
  }

  get hasFinishedLottery () {
    return this.status === Status.DONE
  }

  get getStatusMessage () {
    if (this.isBeforeApplication) {
      return this.isFree ? '予約前' : '販売前'
    } else if (this.isInApplication) {
      return this.isFree ? '予約受付中' : '販売受付中'
    } else if (this.hasFinishedApplication) {
      return this.isFree ? '予約終了' : '販売終了'
    } else if (this.isInLottery) {
      return '抽選中'
    } else if (this.hasFinishedLottery) {
      return '抽選終了'
    }
  }

  get getMaxReservationCount () {
    return this.maxReservationCount
  }

  get getCanReserve () {
    return this.canReserve
  }

  get getIsFull () {
    return this.isFull
  }
}
