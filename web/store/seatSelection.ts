import { Module, Mutation, VuexModule } from 'vuex-module-decorators'

export type SeatSelection = {
  selection: string[]
  maxSelection: number
}

@Module({
  name: 'seatSelection',
  stateFactory: true,
  namespaced: true
})
export default class SeatSelectionModule extends VuexModule {
  private seatSelection: SeatSelection = {
    selection: [],
    maxSelection: 4
  }

  get getSelection (): string[] {
    return this.seatSelection.selection
  }

  get exists () {
    return (seatSelection: string) => {
      return this.seatSelection.selection.filter((elem) => {
        return elem === seatSelection
      }).length > 0
    }
  }

  @Mutation
  initialize (maxSelection: number): void {
    this.seatSelection = {
      selection: [],
      maxSelection
    }
  }

  @Mutation
  insertSelection (seatName: string): void {
    if (this.seatSelection.selection.length >= this.seatSelection.maxSelection) {
      return
    }
    this.seatSelection.selection.push(seatName)
  }

  @Mutation
  removeSelection (seatName: string): void {
    this.seatSelection.selection.forEach((elem, index) => {
      if (elem === seatName) {
        this.seatSelection.selection.splice(index, 1)
      }
    })
  }

  get getSelectionInArray () {
    const result = []
    for (let i = 0; i < this.seatSelection.selection.length; i++) {
      const array = this.seatSelection.selection[i].split('-')
      const row = array[0].charCodeAt(0) - 'A'.charCodeAt(0) + 1
      const col = parseInt(array[1])
      result.push({
        row,
        col
      })
    }
    return result
  }

  @Mutation
  reset (): void {
    this.seatSelection = {
      selection: [],
      maxSelection: this.seatSelection.maxSelection
    }
  }
}
