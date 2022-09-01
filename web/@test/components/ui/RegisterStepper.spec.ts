import { createLocalVue, mount } from '@vue/test-utils'
import Vuetify from 'vuetify'
import RegisterStepper from '~/components/ui/RegisterStepper.vue'

describe('RegisterStepper.vue', () => {
  const localVue = createLocalVue()
  let vuetify: Vuetify

  beforeEach(() => {
    vuetify = new Vuetify()
  })

  it('step = 1で条件の確認が選択状態になる', async () => {
    const wrapper = mount(RegisterStepper, {
      propsData: {
        step: 1
      },
      localVue,
      vuetify
    })
    await wrapper.setData({ step: 1 })

    expect(wrapper.findAll('.v-stepper__step--active > .v-stepper__label').length).toBe(1)
    expect(wrapper.find('.v-stepper__step--active > .v-stepper__label').text()).toBe('条件の確認')
  })

  it('step = 2でユーザー登録が選択状態になる', async () => {
    const wrapper = mount(RegisterStepper, {
      propsData: {
        step: 2
      },
      localVue,
      vuetify
    })
    await wrapper.setData({ step: 2 })

    expect(wrapper.findAll('.v-stepper__step--complete').length).toBe(1)
    expect(wrapper.find('.v-stepper__step--active > .v-stepper__label').text()).toBe('ユーザー登録')
  })

  it('step = 3でメールアドレス確認が選択状態になる', async () => {
    const wrapper = mount(RegisterStepper, {
      propsData: {
        step: 3
      },
      localVue,
      vuetify
    })
    await wrapper.setData({ step: 3 })

    expect(wrapper.findAll('.v-stepper__step--complete').length).toBe(2)
    expect(wrapper.find('.v-stepper__step--active > .v-stepper__label').text()).toBe('メールアドレス確認')
  })

  it('step = 4で登録完了が選択状態になる', async () => {
    const wrapper = mount(RegisterStepper, {
      propsData: {
        step: 4
      },
      localVue,
      vuetify
    })
    await wrapper.setData({ step: 4 })

    expect(wrapper.findAll('.v-stepper__step--complete').length).toBe(3)
    expect(wrapper.find('.v-stepper__step--active > .v-stepper__label').text()).toBe('登録完了')
  })
})
