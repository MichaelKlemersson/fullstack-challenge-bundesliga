<template>
    <div id="body-wrapper">
        <BcRootHeader></BcRootHeader>

        <div class="container">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
    import BcRootHeader from './root/BcRootHeader.vue'
    import axios from 'axios'

    export default {
        components: {
            BcRootHeader
        },

        mounted() {
            // axios.get('/sports/default').then(response => {
            //     this.$store.commit('setDefaultSport', response.data)
            // })
        }
    }
</script>
