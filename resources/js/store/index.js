import { createStore } from "vuex";


import Person from './modules/person';


const store = createStore({
    modules: {
        Person
    },
    // state: {
    //     //define variables
    // },
    // mutation: {
    //     //update variable value
    // },
    // actions: {
    //     //action to be performed
    // },
    // getters: {
    //     //get state variable value
    // },
});


export default store;
