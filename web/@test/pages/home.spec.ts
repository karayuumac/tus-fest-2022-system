import { createLocalVue, mount } from '@vue/test-utils'
import Vuetify from 'vuetify'
import { createStore } from '~/.nuxt/store'
import { initializeStores, ToasterStore } from '~/utils/store-accsessor'
import Home from '~/pages/home.vue'

describe('home.vue', () => {
  const localVue = createLocalVue()
  let vuetify: Vuetify

  beforeEach(() => {
    // store の初期化
    initializeStores(createStore())
    vuetify = new Vuetify()
  })

  it('ログアウトできる', () => {
    const mockAuth = jest.fn()
    const mockRouter = jest.fn()
    const wrapper = mount(Home, {
      mocks: {
        $auth: {
          logout: mockAuth
        },
        $router: {
          push: mockRouter
        }
      },
      localVue,
      vuetify
    })

    const logoutButton = wrapper.find('.v-btn')
    expect(logoutButton.text()).toBe('ログアウト')

    logoutButton.trigger('click')
    expect(mockAuth).toHaveBeenCalledTimes(1)
    expect(ToasterStore.getToast).toEqual({
      message: 'ログアウトしました',
      timeout: 3000,
      color: 'success'
    })
    expect(mockRouter).toHaveBeenCalledWith('/')
  })
})
