import { createLocalVue, mount } from '@vue/test-utils'
import Vuetify from 'vuetify'
import Index from '~/pages/index.vue'
import { createStore } from '~/.nuxt/store'
import { initializeStores } from '~/utils/store-accsessor'

describe('index.vue', () => {
  const localVue = createLocalVue()
  let vuetify: Vuetify

  beforeEach(() => {
    // store の初期化
    initializeStores(createStore())
    vuetify = new Vuetify()
  })

  it('パネルは開いている', () => {
    const wrapper = mount(Index, {
      // mounted で $auth を呼んでいるため mock を作成しておく
      mocks: {
        $auth: {}
      },
      data () {
        return {
          isLoggedIn: false
        }
      },
      localVue,
      vuetify
    })

    expect(wrapper.findAll('.v-expansion-panel').at(0).attributes('aria-expanded')).toBe('true')
    expect(wrapper.findAll('.v-expansion-panel').at(1).attributes('aria-expanded')).toBe('true')
  })

  it('ログインしていないとき、「ユーザー登録を行う」ボタン・「すでにユーザー登録済みの方はこちら」ボタンが表示される', () => {
    const wrapper = mount(Index, {
      mocks: {
        $auth: {}
      },
      data () {
        return {
          isLoggedIn: false
        }
      },
      localVue,
      vuetify
    })

    expect(wrapper.findAll('.v-btn').at(0).text()).toBe('ユーザー登録を行う')
    expect(wrapper.findAll('.v-btn').at(1).text()).toBe('すでにユーザー登録済みの方はこちら')
  })

  it('ログインしているとき、「予約の確認はこちら」ボタンが表示される', () => {
    const wrapper = mount(Index, {
      mocks: {
        $auth: {}
      },
      data () {
        return {
          isLoggedIn: true
        }
      },
      localVue,
      vuetify
    })

    expect(wrapper.find('.v-btn').text()).toBe('予約の確認はこちら')
  })

  it('「ユーザー登録を行う」をクリックすると、条件の確認画面にリダイレクトされる', () => {
    const mockRouterPush = jest.fn()
    const wrapper = mount(Index, {
      mocks: {
        $auth: {},
        $router: {
          push: mockRouterPush
        }
      },
      data () {
        return {
          isLoggedIn: false
        }
      },
      localVue,
      vuetify
    })

    wrapper.findAll('.v-btn').at(0).trigger('click')
    expect(mockRouterPush).toHaveBeenCalledWith('/user/condition')
  })

  it('「すでにユーザー登録済みの方はこちら」をクリックすると、ログイン画面にリダイレクトされる', () => {
    const mockRouterPush = jest.fn()
    const wrapper = mount(Index, {
      mocks: {
        $auth: {},
        $router: {
          push: mockRouterPush
        }
      },
      data () {
        return {
          isLoggedIn: false
        }
      },
      localVue,
      vuetify
    })

    wrapper.findAll('.v-btn').at(1).trigger('click')
    expect(mockRouterPush).toHaveBeenCalledWith('/user/login')
  })

  it('「予約の確認はこちら」をクリックすると、ホーム画面にリダイレクトする', () => {
    const mockRouterPush = jest.fn()
    const wrapper = mount(Index, {
      mocks: {
        $auth: {},
        $router: {
          push: mockRouterPush
        }
      },
      data () {
        return {
          isLoggedIn: true
        }
      },
      localVue,
      vuetify
    })

    wrapper.findAll('.v-btn').at(0).trigger('click')
    expect(mockRouterPush).toHaveBeenCalledWith('/home')
  })
})
