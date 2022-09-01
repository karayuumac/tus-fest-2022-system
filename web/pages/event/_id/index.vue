<template>
  <v-container fluid>
    <v-card max-width="750px" class="mx-auto">
      <CardHeader />
      <v-card-text class="font-size-normal" />
    </v-card>
  </v-container>
</template>

<script lang="ts">
import { Component, Vue } from 'nuxt-property-decorator'
import CardHeader from '~/components/ui/CardHeader.vue'
import redirectIfNotVerified from '~/middleware/redirectIfNotVerified'
import redirectIfNotApplication from '~/middleware/event/redirectIfNotInApplication'

@Component({
  components: { CardHeader },
  middleware: [redirectIfNotVerified, redirectIfNotApplication]
})
export default class EventIndex extends Vue {
  mounted () {
    const event_id = this.$route.params.id
    this.$axios
      .$get(`/api/event/${event_id}`)
      .then((res) => {
        return res.event
      })
  }
}
</script>

<style scoped>

</style>
