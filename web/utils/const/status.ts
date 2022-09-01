export enum Status {
  LOTTERY_APPLICATIONS = 'lottery_applications',
  PENDING = 'pending',
  DONE = 'done'
}

export function toStatus (stringStatus: string) {
  switch (stringStatus) {
    case 'lottery_applications':
      return Status.LOTTERY_APPLICATIONS
    case 'pending':
      return Status.PENDING
    case 'done':
      return Status.DONE
    default:
      throw new Error('マッチする文字列が見つかりません.')
  }
}
