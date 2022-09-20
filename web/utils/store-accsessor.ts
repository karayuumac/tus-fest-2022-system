/* eslint-disable import/no-mutable-exports */
import { Store } from 'vuex'
import { getModule } from 'vuex-module-decorators'
import ToasterModule from '~/store/toaster'
import SeatSelectionModule from '~/store/seatSelection'

let ToasterStore: ToasterModule
let SeatSelectionStore: SeatSelectionModule

function initializeStores (store: Store<any>): void {
  ToasterStore = getModule(ToasterModule, store)
  SeatSelectionStore = getModule(SeatSelectionModule, store)
}

export { initializeStores, ToasterStore, SeatSelectionStore }
