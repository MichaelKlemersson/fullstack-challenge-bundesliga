<template>
    <div id="next-matches">
        <div class="col-lg-4 col-sm-6 col-xs-12" v-for="league in leagues">
            <div class="panel panel-default">
                <div class="panel-heading"><strong>{{ league.leagueName }}</strong></div>

                <div class="panel-body">
                    Panel content
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'

    export default {
        data: () => {
            return {
                leagues: []
            }
        },

        mounted () {
            this.getCurrentSport(sport => {
                axios.get('/leagues', { params: { sport: sport.sportsID } }).then(response => {
                    if (response.data.length) {
                        const leagues = response.data.map(function(item) {
                            // axios.get('/leagues/matches/next', { params: { league: item.leagueShortcut } }).then(response => {
                            //     item.nextMatch = response.data
                            // })
    
                            return item
                        });
    
                        this.leagues = leagues
                    }
                })
            })
        },

        methods: {
            getCurrentSport(callback) {
                if (this.$store.state.currentSport == null) {
                    return axios.get('/sports/default').then(response => {
                        this.$store.commit('setDefaultSport', response.data)

                        callback(this.$store.state.currentSport)
                    })      
                }
            }
        }
    }
</script>
