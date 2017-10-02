<template>
    <div class="text-center fake-loader" v-show="showLoading">
        <div class="clearfix"></div>
        <i class="fa fa-refresh fa-spin fa-3x fa-fw margin-bottom"></i>
    </div>
</template>

<style>
    .fake-loader{
        padding: 40px 0;
        margin: 20px 0;
    }
</style>


<script>
    export default {
        name: 'BcLoader',

        computed: {
            showLoading() {
                return this.$store.state.showLoading
            }
        }
    }
</script>

