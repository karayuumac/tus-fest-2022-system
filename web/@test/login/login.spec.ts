import { createLocalVue, mount, shallowMount } from '@vue/test-utils'
import Vuetify from 'vuetify'
import axios from 'axios'
import Login from '~/pages/login.vue'

describe('ログイン画面', () => {
  const localVue = createLocalVue()
  let vuetify: Vuetify

  beforeEach(() => {
    vuetify = new Vuetify()
  })

  jest.mock('axios')
  const postApiMock = jest.spyOn(axios, 'post').mockName('axois-post')
  postApiMock.mockResolvedValue({
    data: {
      message: 'Mock response'
    }
  })

  it('表示される', () => {
    const wrapper = mount(Login, {
      localVue, vuetify
    })
    const text = wrapper.find('.v-card__title').text()

    expect(text).toBe('ログイン')
  })

  it('ログインができる', async () => {
    const wrapper = shallowMount(Login, {
      localVue, vuetify
    })

    await wrapper.find('[data-email]').setValue('test@example.com')
    await wrapper.find('[data-password]').setValue('password')

    await wrapper.find('button').trigger('click')

    const contain = wrapper.find('.v-card__title')
    expect(contain.exists()).toBe(false)
  })
})
