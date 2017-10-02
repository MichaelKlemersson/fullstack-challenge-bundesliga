<template>
    <div id="league-matches" class="row">
        <BcLoader></BcLoader>

        <div v-show="!isLoading">
            <div class="col-md-12" v-if="currentLeague !== ''">
                <h2>{{ currentLeague }}</h2>
            </div>

            <div class="clearfix">
                <div class="col-md-3 col-xs-12 pull-right">
                    <div class="form-group">
                        <label for="select-league-group" class="control-label">Gameday</label>
                        <select @change="changeLeagueGroup" v-model="selectedGroup" id="select-league-group" class="form-control">
                            <option v-for="group in groups" :value="group.GroupOrderID">
                                {{ group.GroupName }}
                            </option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-sm-6 col-xs-12" v-for="match in matches">
                <div class="panel panel-default">
                    <div class="panel-heading clearfix">
                        {{ match.Team1.TeamName }}
                        <img :src="match.Team1.TeamIconUrl" class="team-icon" alt="">
                        x
                        <img :src="match.Team2.TeamIconUrl" class="team-icon" alt="">
                        {{ match.Team2.TeamName }}
                        <br/>
                    </div>

                    <div class="panel-body">
                        <div v-if="match.MatchIsFinished">
                            <p>
                                <strong>Date: </strong>{{ formatMatchDate(match.MatchDateTime) }}
                            </p>

                            <p v-if="match.Location">
                                <strong>City: </strong>{{ match.Location.LocationCity }}
                            </p>

                            <p v-if="match.Location">
                                <strong>Stadium: </strong>{{ match.Location.LocationStadium }}
                            </p>

                            <p>
                                <strong>Winner: </strong><span v-html="getWinner(match)"></span>
                            </p>

                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th class="text-center">{{ match.Team1.TeamName }}</th>
                                            <th class="text-center">{{ match.Team2.TeamName }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-center">{{ match.MatchResults[match.MatchResults.length-1].PointsTeam1 }}</td>
                                            <td class="text-center">{{ match.MatchResults[match.MatchResults.length-1].PointsTeam2 }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div v-else>
                            This match will start in {{ diffMatchDate(match.MatchDateTime) }}
                        </div>
                    </div>
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
        max-width: 16px;
    }
    .table{
        margin-bottom: 5px;
    }
    .panel-heading, table > thead > th{
        text-overflow: ellipsis;
        white-space: nowrap;
        overflow: hidden;
    }
</style>

<script>
    import axios from 'axios'
    import moment from 'moment'
    import BcLoader from './../root/BcLoader'

    export default {
        components: {
            BcLoader
        },

        data: () => {
            return {
                currentLeague: '',
                matches: [],
                groups: [],
                currentLeagueGroup: null,
                selectedGroup: null
            }
        },

        watch: {
            '$route': 'initPage'
        },

        computed: {
            isLoading() {
                return this.$store.state.showLoading
            }
        },

        mounted () {
            this.initPage()
        },

        methods: {
            initPage() {
                this.$store.commit('showLoading', true)
                this.getLeagueMatches()
                    .then(response => response.data)
                    .then(data => {
                        this.matches = data
                        this.$store.commit('showLoading', false)
                        this.currentLeague = this.matches[0].LeagueName
                    })
                    .catch(err => console.error(err))
            
                this.getAvailableGroups()
                    .then(response => response.data)
                    .then(data => {
                        this.currentLeagueGroup = data.current
                        this.groups = data.groups
                        this.selectedGroup = this.currentLeagueGroup.GroupOrderID
                    })
            },

            getLeagueMatches(group) {
                let params = { league: this.$store.state.route.params.id }

                if (group) {
                    params.session = this.getCurrentSession()
                    params.group = group
                }

                return axios.get('/leagues/matches', { params })
            },

            getCurrentSession() {
                const now = new Date();

                return (now.getMonth() <= 5 ? now.getFullYear() - 1 : now.getFullYear());
            },

            getAvailableGroups() {
                return axios.get('/leagues/groups', {
                    params: {
                        league: this.$store.state.route.params.id,
                        session: this.getCurrentSession()
                    }
                })
            },

            formatMatchDate(date) {
                return moment(date).format('YYYY-MM-DD hh:mm a')
            },

            diffMatchDate(date) {
                let time = moment(date).diff(moment(), 'days')
                if (parseInt(time) <= 0) {
                    time = moment(date).diff(moment(), 'hours') + ' hours'
                } else {
                     time += ' days'
                }
                return time
            },

            getWinner(match) {
                const finalResult = match.MatchResults[match.MatchResults.length-1]
                if (finalResult !== undefined && finalResult.PointsTeam1 != finalResult.PointsTeam2) {
                    const winner = finalResult.PointsTeam1 > finalResult.PointsTeam2 ? match.Team1.TeamName : match.Team2.TeamName
                    return '<label class="label label-success">' + winner + '</label>'
                }
                return ''
            },

            changeLeagueGroup() {
                this.$store.commit('showLoading', true)
                this.getLeagueMatches(this.selectedGroup)
                    .then(response => response.data)
                    .then(data => {
                        this.matches = data
                        this.$store.commit('showLoading', false)
                        this.currentLeague = this.matches[0].LeagueName
                    })
                    .catch(err => console.error(err))
            }
        }
    }
</script>
