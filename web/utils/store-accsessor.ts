/* eslint-disable import/no-mutable-exports */
import { Store } from 'vuex'
import { getModule } from 'vuex-module-decorators'
import ToasterModule from '~/store/toaster'

let ToasterStore: ToasterModule
function initializeStores (store: Store<any>): void {
  ToasterStore = getModule(ToasterModule, store)
}

export { initializeStores, ToasterStore }
