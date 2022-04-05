<template>
    <span class="invalid-feedback" v-if="formName.errors.has(propName)" v-text="formName.errors.get(propName)"></span>
</template>

<script>
export default {
    name: 'show-error',
    props:['formName','propName']
}
</script>
