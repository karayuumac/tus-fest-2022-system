import { Context } from '@nuxt/types'
import redirectIfAuthenticated from '~/middleware/redirectIfAuthenticated'
import { createStore } from '~/.nuxt/store'
import { initializeStores, ToasterStore } from '~/utils/store-accsessor'

describe('redirectIfAuthenticated middleware', () => {
  it('ログインしている場合はリダイレクトされる', () => {
    initializeStores(createStore())

    const mockStore = {
      $auth: {
        loggedIn: true
      }
    }
    const mockRedirect = jest.fn()

    redirectIfAuthenticated({
      store: mockStore,
      redirect: mockRedirect
    } as any as Context)

    expect(mockRedirect).toHaveBeenCalledWith('/home')
    expect(ToasterStore.getToast).toEqual({
      message: 'すでにログインしています',
      timeout: 3000,
      color: 'error'
    })
  })

  it('ログインしていない場合は何もしない', () => {
    const mockStore = {
      $auth: {
        loggedIn: false
      }
    }
    const mockRedirect = jest.fn()

    redirectIfAuthenticated({
      store: mockStore,
      redirect: mockRedirect
    } as any as Context)

    expect(mockRedirect).toHaveBeenCalledTimes(0)
  })
})
