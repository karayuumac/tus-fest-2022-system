<template>
  <div>sample</div>
</template>

<script lang="ts">
import { Component, Vue } from 'nuxt-property-decorator'
import redirectIfNotValidCondition from '~/middleware/redirectIfNotValidCondition'

@Component({
  middleware: [redirectIfNotValidCondition]
})
export default class UserCreate extends Vue {

}
</script>

<style lang="scss" scoped>

</style>
