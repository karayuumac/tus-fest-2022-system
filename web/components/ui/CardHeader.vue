<template>
  <div>
    <div class="card-header-background">
      <v-card-title class="white--text d-flex flex-column align-end">
        <span>2022年度野田地区理大祭</span>
        <h3>来場者予約システム</h3>
      </v-card-title>
    </div>
    <v-container v-show="showBackButton">
      <v-row class="pa-2">
        <v-btn
          color="blue"
          outlined
          @click="clickBack"
        >
          <v-icon>{{ mdiChevronLeft }}</v-icon>
          戻る
        </v-btn>
      </v-row>
      <v-divider class="mt-2" />
    </v-container>
  </div>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'nuxt-property-decorator'
import { mdiChevronLeft } from '@mdi/js'

@Component
export default class CardHeader extends Vue {
  mdiChevronLeft = mdiChevronLeft

  @Prop({
    type: Boolean, default: true
  })
    showBackButton!: boolean

  clickBack () {
    window.history.back()
  }
}
</script>

<style lang="scss" scoped>
.card-header-background {
  background: linear-gradient(180deg, #71c7d1, #71c7d1 65%, #009dda 0, #009dda);
  height: 200px;
}

.card-header-img {
  position: absolute;
  left: 25px;
  top: 20px;
  animation: move-y 4s infinite alternate ease-in-out;
  @keyframes move-y {
    from {
      transform: translateY(-10px);
    }
    to {
      transform: translateY(5px);
    }
  }
}

.border-round {
  margin: 12px;
  padding: 4px;
  border: white 4px solid;
  border-radius: 10px;
}
</style>
