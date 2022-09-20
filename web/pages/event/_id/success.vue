<template>
  <div>
    Hello, world!
  </div>
</template>

<script lang="ts">
import { Component, Vue } from 'nuxt-property-decorator'
import redirectIfTokenIsNotValid from '~/middleware/event/redirectIfTokenIsNotValid'

@Component({
  middleware: [redirectIfTokenIsNotValid]
})
export default class Success extends Vue {
}
</script>

<style lang="scss" scoped>

</style>
