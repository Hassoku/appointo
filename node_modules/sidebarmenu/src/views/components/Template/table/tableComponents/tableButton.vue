<template>
<div>
  <el-button v-for="btn in col.cptProperties" :key="btn.value"
  :type="btn.type" :size="btn.size" :icon="btn.icon"
  @click="btn.eventClick(index, row)">{{btn.label}}</el-button>
  </div>
</template>

<script>
export default {
  props: ['row', 'col', 'index'],
  mounted () {
  },
  methods: {
    todo () {
    //   this.$emit('row-editor', this.row)
      this.$set(this.row, '_edit', !this.row._edit)
    }
  }
}
</script>