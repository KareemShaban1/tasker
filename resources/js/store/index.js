import Country from '@/store/Modules/Country'
import City from '@/store/Modules/City'
import State from '@/store/Modules/State'
import Language from '@/store/Modules/Language'
import TaskType from '@/store/Modules/TaskType'
import Task from '@/store/Modules/Task'
import Vuex from 'vuex'
import auth from './auth'
import Category from '@/store/Modules/Category'
import Specialty from '@/store/Modules/Specialty'
import Client from '@/store/Modules/Client'
import Offer from '@/store/Modules/Offer'
import User from '@/store/Modules/User'


export default new Vuex.Store({
  modules: {
    auth,
    Country,
    City,
    State,
    Language,
    TaskType,
    Task,
    Category,
    Specialty,
    Client,
    Offer,
    User
  },
})
