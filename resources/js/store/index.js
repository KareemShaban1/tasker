import Country from '@/store/Modules/Country'
import City from '@/store/Modules/City'
import State from '@/store/Modules/State'
import Language from '@/store/Modules/Language'
import TaskType from '@/store/Modules/TaskType'
import Vuex from 'vuex'
import auth from './auth'

export default new Vuex.Store({
  modules: {
    auth,
    Country,
    City,
    State,
    Language,
    TaskType,
  },
})
