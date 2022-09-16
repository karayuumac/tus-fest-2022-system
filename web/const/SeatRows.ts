export interface SeatRow {
  name: string;
  left: number;
  center: number;
  right: number;
}

export const seatRows: SeatRow[] = [
  { name: 'A', left: 3, center: 11, right: 3 },
  { name: 'B', left: 5, center: 11, right: 5 },
  { name: 'C', left: 5, center: 11, right: 5 },
  { name: 'D', left: 6, center: 11, right: 6 },
  { name: 'E', left: 6, center: 11, right: 6 },
  { name: 'F', left: 6, center: 11, right: 6 },
  { name: 'G', left: 7, center: 11, right: 7 },
  { name: 'H', left: 7, center: 11, right: 7 },
  { name: 'I', left: 7, center: 11, right: 7 },
  { name: 'J', left: 7, center: 11, right: 7 },
  { name: 'K', left: 7, center: 11, right: 7 },
  { name: '', left: 0, center: 0, right: 0 },
  { name: 'L', left: 7, center: 11, right: 7 },
  { name: 'M', left: 7, center: 11, right: 7 },
  { name: 'N', left: 7, center: 11, right: 7 },
  { name: 'O', left: 7, center: 11, right: 7 },
  { name: 'P', left: 7, center: 11, right: 7 },
  { name: 'Q', left: 6, center: 11, right: 6 },
  { name: 'R', left: 6, center: 11, right: 6 },
  { name: 'S', left: 6, center: 11, right: 6 },
  { name: 'T', left: 5, center: 11, right: 5 },
  { name: 'U', left: 5, center: 11, right: 5 },
  { name: 'V', left: 0, center: 11, right: 0 }
]

export const maxRows = 23
export const maxCols = 25
