import { Action, Module, Mutation, VuexModule } from 'vuex-module-decorators'
import { getAuth, onAuthStateChanged } from 'firebase/auth'

interface UserState {
  userUid: string,
  isLoggedIn: boolean
}

@Module({
  name: 'auth',
  stateFactory: true,
  namespaced: true
})
export default class AuthModule extends VuexModule {
  private user: UserState = {
    userUid: '',
    isLoggedIn: false
  }

  get isAuthenticated (): boolean {
    return this.user.isLoggedIn
  }

  @Mutation
  setUser (user: UserState) {
    this.user = user
  }

  @Mutation
  resetUser () {
    this.user = {
      userUid: '',
      isLoggedIn: false
    }
  }

  @Action({ rawError: true })
  async checkAuth () {
    const auth = getAuth()
    const unsubscribe = onAuthStateChanged(auth, (user) => {
      if (!user) {
        this.resetUser()
      } else {
        this.setUser({
          userUid: user.uid,
          isLoggedIn: true
        })
      }
      unsubscribe()
    })
  }
}
