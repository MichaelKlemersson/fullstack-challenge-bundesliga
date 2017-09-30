<template>
    <div id="next-matches" class="row">
        <div class="col-md-4 col-xs-12" v-for="league in leagues">
            <div class="panel panel-default">
                <div class="panel-heading"><strong>{{ league.leagueName }}</strong></div>

                <div class="panel-body text-center">
                    <i v-show="league.nextMatches === undefined" class="fa fa-refresh fa-spin fa-3x fa-fw margin-bottom"></i>
                    
                    <div v-show="league.nextMatches !== undefined">
                        <a class="link-match" v-for="match in league.nextMatches">
                            {{ match.Team1.TeamName }}
                            <img :src="match.Team1.TeamIconUrl" class="team-icon" alt="">
                            x
                            <img :src="match.Team2.TeamIconUrl" class="team-icon" alt="">
                            {{ match.Team2.TeamName }}
                            <br/>
                        </a>
                    </div>
                </div>

                <div class="panel-footer text-center" v-show="league.nextMatches !== undefined">
                    <a href="">See more content <i class="fa fa-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
    .link-match{
        display: block;
        padding: 3px 0;
        text-decoration: none;
        cursor: pointer;
    }
    .team-icon{
        max-width: 20px;
    }
</style>

<script>
    import axios from 'axios'
    import Queue from 'promise-queue'
    import { indexOf } from 'lodash'

    export default {
        data: () => {
            return {
                leagues: []
            }
        },

        mounted () {
            this.getCurrentSport(sport => {
                axios.get('/leagues', { 
                    params: {
                        sport: sport.sportsID,
                        session: this.getCurrentSession()
                    }
                }).then(response => {
                    if (response.data.length) {
                        let queueNextMatches = new Queue(2, response.data.length);
                        const _self = this

                        response.data.forEach(function(league, index) {
                            if (indexOf(['bl1', 'bl2', 'bl3'], league.leagueShortcut) === -1) {
                                return;
                            }
                            queueNextMatches.add(() => {
                                const deferred = $.Deferred()
                                axios.get('/leagues/matches/upcoming', { 
                                    params: { 
                                        league: league.leagueShortcut,
                                        session: league.leagueSaison
                                    }
                                }).then(response => {
                                    if (response.data.matchID !== -1) {
                                        league.nextMatches = response.data
                                        _self.leagues.push(league)
                                    }
                                    deferred.resolve()
                                })
                                return deferred.promise()
                            })
                        })

                        this.$store.commit('showLoading', false)
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
            },

            getCurrentSession() {
                const now = new Date();

                return (now.getMonth() <= 5 ? now.getFullYear() - 1 : now.getFullYear());
            }
        }
    }
</script>
