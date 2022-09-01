<template>
  <div class="mr-4">
    <v-btn
      v-if="event.isInApplication"
      outlined
      :color="event.isFree ? 'blue' : 'green darken-1'"
      large
      @click="() => {}"
    >
      <span class="font-weight-bold text-subtitle-1">
        <span v-if="event.isFree">予約</span>
        <span v-else>購入</span>
      </span>
    </v-btn>
  </div>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'nuxt-property-decorator'

@Component
export default class EventButton extends Vue {
  @Prop({ type: Object, required: true }) event!: Event
}
</script>

<style scoped>

</style>
