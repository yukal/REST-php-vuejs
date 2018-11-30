import Vue from 'vue'
import Router from 'vue-router'
import PageDashboard from '@/components/Dashboard'
import PageSettings from '@/components/PageSettings'
import PageNews from '@/components/News'
import PageNewsItem from '@/components/NewsItem'
import PageError from '@/components/ErrorPage'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'dashboard',
      component: PageDashboard
    },
    {
      path: '/news',
      name: 'news',
      component: PageNews
    },
    {
      path: '/news/:id',
      name: 'news-item',
      component: PageNewsItem
    },
    {
      path: '/settings',
      name: 'pageSettings',
      component: PageSettings
    },
    {
      path: '*',
      name: 'ErrorPage',
      component: PageError,
      meta: {
        title: 'ErrorPage'
      }
    }
  ],
  mode: 'history'
})
