import { Context } from '@nuxt/types'
import redirectIfNotVerified from '~/middleware/redirectIfNotVerified'
import { createStore } from '~/.nuxt/store'
import { initializeStores, ToasterStore } from '~/utils/store-accsessor'

describe('redirectIfNotVerified middleware', () => {
  it('ログインしていない場合はリダイレクトされる', () => {
    initializeStores(createStore())

    const mockStore = {
      $auth: {
        user: undefined
      }
    }
    const mockRedirect = jest.fn()

    redirectIfNotVerified({
      store: mockStore,
      redirect: mockRedirect
    } as any as Context)

    expect(mockRedirect).toHaveBeenCalledWith('/login')
    expect(ToasterStore.getToast).toEqual({
      message: 'ログインしてください',
      timeout: 3000,
      color: 'error'
    })
  })

  it('ログインしているが、メール認証が済んでいない場合はリダイレクトされる', () => {
    const mockStore = {
      $auth: {
        user: {
          data: {
            has_email_verified: false
          }
        }
      }
    }
    const mockRedirect = jest.fn()

    redirectIfNotVerified({
      store: mockStore,
      redirect: mockRedirect
    } as any as Context)

    expect(mockRedirect).toHaveBeenCalledWith('/user/verified')
  })

  it('ログインしていて、メール認証も済んでいる場合は何もしない', () => {
    const mockStore = {
      $auth: {
        user: {
          data: {
            has_email_verified: true
          }
        }
      }
    }
    const mockRedirect = jest.fn()

    redirectIfNotVerified({
      store: mockStore,
      redirect: mockRedirect
    } as any as Context)

    expect(mockRedirect).toHaveBeenCalledTimes(0)
  })
})
