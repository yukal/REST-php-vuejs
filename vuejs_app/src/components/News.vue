<template>
  <div class="error-page">
    <h4 class="title">News</h4>

    <b-table striped :fields="fields" :items="items" class="table-sm">
      <template slot="title" slot-scope="data">
        <b-link :to="`news/${data.item.id}`">{{data.value}}</b-link>
      </template>

      <template slot="date" slot-scope="data">{{data.value | date}}</template>

      <template slot="_" slot-scope="row">
        <b-button size="sm" variant="outline-secondary">× Remove</b-button>
      </template>
    </b-table>
  </div>
</template>

<script>
export default {
  data () {
    return {
      apiUrl: 'http://api.domain.loc/news/',
      show: true,
      fields: [
        'id',
        'title',
        'description',
        'author',
        'district',
        'rubric',
        'date',
        '_'
      ],
      items: []
    }
  },
  created () {
    // fetch the data when the view is created and the data is
    // already being observed
    this.fetchData()
  },
  watch: {
    // call again the method if the route changes
    $route: 'fetchData'
  },
  methods: {
    fetchData () {
      // const url = "http://api.domain.loc/news"
      this.$http.get(this.apiUrl).then(
        function (response) {
          this.items = response.body
          // setTimeout(() => {this.items = response.body}, 300)
          console.log(response.status, response.statusText)
        },
        function (error) {
          console.log(error.status, error.statusText)
        }
      )
    }
  }
}
</script>
