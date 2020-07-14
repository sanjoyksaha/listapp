import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

import Dashboard from '../components/Dashboard'
import Users from '../components/users/Users'
import Profile from '../components/profile/Profile'
import Category from '../components/category/Category'
import CreateCompany from '../components/company/CreateCompany'
import List from '../components/company/List'
import Details from '../components/company/Details'
import Edit from '../components/company/Edit'
import Event from '../components/event/Event'
// import Testing from '../components/Testing'

const routes = [
    { path:'/dashboard', component: Dashboard ,  meta:{ title: 'Dashboard' }},
    { path:'/users', component: Users, meta:{ title: 'Users' } },
    { path:'/profile', component: Profile, meta:{ title: 'Profile' } },
    { path:'/category', component: Category, meta:{ title: 'Category' } },
    { path:'/create-company', component: CreateCompany, meta:{ title: 'Create Company' } },
    { path:'/company-lists', component: List, meta:{ title: 'Company Lists' } },
    { path:'/company/:id', component: Details, meta:{ title: 'Details Of Company' } },
    { path:'/company/:id/edit', component: Edit, meta:{ title: 'Edit Company' } },
    { path:'/events', component: Event, meta:{ title: 'Events' } },
    // { path:'/testing', component: Testing },
];

const router = new VueRouter({
    routes, // short for `routes: routes`
    hashbang: false,
    mode: "history",
});

export default router
