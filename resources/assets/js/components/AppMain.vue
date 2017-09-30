<template>
    <div id="body-wrapper">
        <BcRootHeader></BcRootHeader>

        <div class="container">
            <router-view></router-view>

            <BcLoader></BcLoader>
        </div>
    </div>
</template>

<script>
    import BcRootHeader from './root/BcRootHeader'
    import BcLoader from './root/BcLoader'
    import axios from 'axios'

    export default {
        components: {
            BcRootHeader,
            BcLoader
        }
    }
</script>
