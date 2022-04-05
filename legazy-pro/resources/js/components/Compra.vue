<template>
     <input
     type="sumbit"
     class="btn btn-flat-success"
     value="comprar"
     v-on:click="comprarProducto"
     >
</template>

<script>

export default {
    props: ['productoId'],
    mounted(){
        console.log('producto actual', this.productoId)
    },
    methods:{
        comprarProducto(){
           console.log('diste click');
        }
    }

}

</script>
