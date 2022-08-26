import { Toast } from '~/store/toaster'
import { createStore } from '~/.nuxt/store'
import { initializeStores, ToasterStore } from '~/utils/store-accsessor'

describe('ToasterStoreのテスト', () => {
  beforeEach(() => {
    // store の初期化
    initializeStores(createStore())
  })

  it('getToast', () => {
    const expectedState: Toast = {
      message: null,
      color: 'error',
      timeout: 4000
    }

    expect(ToasterStore.getToast).toEqual(expectedState)
  })

  it('setToast', () => {
    const expectedState: Toast = {
      message: 'test',
      color: 'success',
      timeout: 3000
    }
    ToasterStore.setToast(expectedState)

    expect(ToasterStore.getToast).toEqual(expectedState)
  })

  it('resetToast', () => {
    const expectedState: Toast = {
      message: null,
      color: 'error',
      timeout: 4000
    }
    ToasterStore.resetToast()

    expect(ToasterStore.getToast).toEqual(expectedState)
  })
})
