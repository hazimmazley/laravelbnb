<template>
  <div>
        <div class="invalid-feedback" 
        v-for="(error, index) 
        in errors" 
        :key="key(index) + index">{{ error }}</div>
  </div>
</template>

<script>
export default {
    props: ['errors'],
    methods: {
        key(index) {
            return `validation_error${index}_${Math.random()}`;
        }
    }
}
</script>

<style scoped>
    .form-control.is-invalid ~ div > .invalid-feedback {
        display: block;
    }
</style>