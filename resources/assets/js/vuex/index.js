import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

const store = new Vuex.Store({
    state: {
        showLoading: true,
        defaultSport: null,
        currentLeague: null,
        currentTeam: null,
        currentSport: null
    },

    mutations: {
        setDefaultSport: (state, sport) => {
            state.defaultSport = sport
            if (state.currentSport === null) {
                state.currentSport = sport
            }
        },

        setCurrentLeague: (state, league) => {
            state.currentLeague = league
        },
        
        setCurrentTeam: (state, team) => {
            state.currentTeam = team
        },
        
        setCurrentSport: (state, sport) => {
            state.currentSport = sport
        },

        showLoading: (state, show) => {
            state.showLoading = show
        }
    }
})

export default store
