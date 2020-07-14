export default {
    state: {
        category: [],
        company: [],
        companyDetails: [],
        event: [],
    },

    getters: {
        getCategories(state) {
            return state.category;
        },

        getCompanies(state) {
            return state.company;
        },

        getCompanyById(state) {
            return state.companyDetails;
        },

        getEvents(state) {
            return state.event;
        }
    },

    actions: {
        allCategory(context){
            axios.get("/api/category")
                .then(res=>{
                    context.commit('categories', res.data)
                })
                .catch(()=>{
                    toastr.error("Data isn't loaded successfully, something went wrong");
                })
        },

        allCompany(context){
            axios.get("/api/company")
                .then(res=>{
                    context.commit('companies', res.data)
                })
                .catch(()=>{
                    toastr.error("Data isn't loaded successfully, something went wrong");
                })
        },

        companyById(context, payload) {
            axios.get("/api/company/"+payload)
                .then(res =>{
                    context.commit('companyById', res.data)
                })
                .catch((error)=>{
                    toastr.error("Data isn't loaded successfully, something went wrong");
                })
        },

        allEvent(context) {
            axios.get("/api/event")
                .then(res=>{
                    context.commit('events', res.data)
                })
                .catch((err)=>{
                    toastr.error("Data isn't loaded successfully, something went wrong");
                })
        },

        search(context, payload) {
            axios.get('/api/findCompany?q='+payload)
                .then((res) => {
                    context.commit('searching', res.data);
                })
                .catch(() => console.log('error'))
        }
    },

    mutations: {
        categories(state, data) {
            return state.category = data;
        },

        companies(state, data) {
            return state.company = data;
        },

        searching(state, data) {
            return state.company = data;
        },

        companyById(state, data) {
            return state.companyDetails = data;
        },

        events(state, data) {
            return state.event = data;
        },

        // even(state, data) {
        //     return state.event = data;
        // }
    },

}
