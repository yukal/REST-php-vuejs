// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import BootstrapVue from 'bootstrap-vue'
import App from './App'
import router from './router'
import VueResource from 'vue-resource'
import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

Vue.use(VueResource)
Vue.use(BootstrapVue)
Vue.config.productionTip = false

Vue.http.headers.common['Authorization'] =
  'QH4iM3l+K0xQWipVQXkha242RD5hbiFlJUomO31HV0d0dHd9e01OUSpDSl5TNCJ4bS1UdnhgeT9tfHMiMkVL'

// Vue.http.options.root = '/'
Vue.http.options.emulateHTTP = true
// Vue.http.options.emulateJSON = true

Vue.filter('date', function (value) {
  var date = new Date(value)
  return date.getDay() + '.' + date.getMonth() + '.' + date.getFullYear()
})

/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  template: '<App/>',
  components: { App }
})
