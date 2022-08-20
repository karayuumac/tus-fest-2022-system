<template>
  <v-tooltip left open-delay="900">
    <template #activator="{ on }">
      <v-fab-transition>
        <v-btn
          v-show="shouldShowGoTopButton"
          v-scroll="onScroll"
          fab
          fixed
          bottom
          right
          color="light-blue"
          v-on="on"
          @click="toTop"
        >
          <v-icon color="white">
            {{ mdiChevronUp }}
          </v-icon>
        </v-btn>
      </v-fab-transition>
    </template>
  </v-tooltip>
</template>

<script lang="ts">
import { mdiChevronUp } from '@mdi/js'
import { Component, Vue } from 'nuxt-property-decorator'

@Component
export default class GoTopButton extends Vue {
  shouldShowGoTopButton = false

  mdiChevronUp = mdiChevronUp

  toTop () {
    this.$vuetify.goTo(0)
  }

  onScroll (event: Event): void {
    if (typeof window === 'undefined') {
      return
    }
    let scrollTop = 0
    if (event.target instanceof HTMLInputElement) {
      scrollTop = event.target.scrollTop
    }
    const top = window.scrollY || scrollTop || 0
    this.shouldShowGoTopButton = top > 100
  }
}
</script>

<style scoped>

</style>
