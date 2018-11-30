<template>
  <div class="error-page">
    <h4 class="title">Settings</h4>

    <!-- {{ $route.params }} -->

    <!-- <b-table striped :items="items" class="table-sm"></b-table> -->

    <!-- Include Editor style. -->
    <!-- <link href='https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.9.0/css/froala_editor.min.css' rel='stylesheet' type='text/css' /> -->
    <!-- <link href='https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.9.0/css/froala_style.min.css' rel='stylesheet' type='text/css' /> -->

    <!-- Include JS file. -->
    <!-- <script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.9.0/js/froala_editor.min.js'></script> -->

      <div class="loading" v-if="loading">Loading...</div>

      <b-row>
        <b-col cols="8">
          <b-form @submit="onSubmit" @reset="onReset" v-if="show">
            <b-form-group id="exampleInputGroup1"
                          label="Email address:"
                          label-for="exampleInput1"
                          description="We'll never share your email with anyone else.">
              <b-form-input id="exampleInput1"
                            type="email"
                            v-model="form.email"
                            required
                            placeholder="Enter email">
              </b-form-input>
            </b-form-group>
            <b-form-group id="exampleInputGroup2"
                          label="Your Name:"
                          label-for="exampleInput2">
              <b-form-input id="exampleInput2"
                            type="text"
                            v-model="form.name"
                            required
                            placeholder="Enter name">
              </b-form-input>
            </b-form-group>
            <b-form-group id="exampleInputGroup3"
                          label="Food:"
                          label-for="exampleInput3">
              <b-form-select id="exampleInput3"
                            :options="foods"
                            required
                            v-model="form.food">
              </b-form-select>
            </b-form-group>

            <b-form-group>
              <b-form-textarea id="textarea1"
                          v-model="text"
                          placeholder="Enter something"
                          :rows="3"
                          :max-rows="6">
              </b-form-textarea>
            </b-form-group>

            <b-form-group id="exampleGroup4">
              <b-form-checkbox-group v-model="form.checked" id="exampleChecks">
                <b-form-checkbox value="me">Check me out</b-form-checkbox>
                <b-form-checkbox value="that">Check that out</b-form-checkbox>
              </b-form-checkbox-group>
            </b-form-group>
            <b-button type="submit" variant="primary">Submit</b-button>
            <b-button type="reset" variant="danger">Reset</b-button>
          </b-form>
        </b-col>

        <b-col>
          <div v-if="error" class="error">{{ error }}</div>
          <div v-if="post" class="content">
            <!-- <h2>{{ post.title }}</h2> -->
            <!-- <p>{{ post.body }}</p> -->
            <!-- <hr> -->

            <strong>As</strong>: {{ post.body.as }}
            <br><strong>City</strong>: {{ post.body.city }}
            <br><strong>Country</strong>: {{ post.body.country }}
            <br><strong>CountryCode</strong>: {{ post.body.countryCode }}
            <br><strong>Isp</strong>: {{ post.body.isp }}
            <br><strong>Lat</strong>: {{ post.body.lat }}
            <br><strong>Lon</strong>: {{ post.body.lon }}
            <br><strong>Org</strong>: {{ post.body.org }}
            <br><strong>Query</strong>: {{ post.body.query }}
            <br><strong>Region</strong>: {{ post.body.region }}
            <br><strong>RegionName</strong>: {{ post.body.regionName }}
            <br><strong>Status</strong>: {{ post.body.status }}
            <br><strong>Timezone</strong>: {{ post.body.timezone }}
            <br><strong>Zip</strong>: {{ post.body.zip }}
          </div>
        </b-col>
      </b-row>

      <br><hr><br>

      <b-pagination align="right" size="md" :total-rows="100" v-model="currentPage" :per-page="10"></b-pagination>
  </div>
</template>

<script>
// const items = [
//   { isActive: true, age: 40, first_name: 'Dickerson', last_name: 'Macdonald' },
//   { isActive: false, age: 21, first_name: 'Larsen', last_name: 'Shaw' },
//   { isActive: false, age: 89, first_name: 'Geneva', last_name: 'Wilson' },
//   { isActive: true, age: 38, first_name: 'Jami', last_name: 'Carney' }
// ]

export default {
  name: 'pageSettings',
  data () {
    return {
      loading: false,
      post: null,
      error: null,
      text: null,
      currentPage: 3,

      form: {
        email: '',
        name: '',
        food: null,
        checked: []
      },
      foods: [
        { text: 'Select One', value: null },
        'Carrots', 'Beans', 'Tomatoes', 'Corn'
      ],
      show: true
    }
  },
  created () {
    // fetch the data when the view is created and the data is
    // already being observed
    this.fetchData()
  },
  watch: {
    // call again the method if the route changes
    '$route': 'fetchData'
  },
  methods: {
    init: function () {
      this.loadData()
    },

    fetchData () {
      const url = 'http://0.0.0.0:8000/'
      // const url = 'http://ip-api.com/json'
      // const url = 'https://dou.ua/feed/'

      this.error = this.post = null
      this.loading = true

      this.$http.get(url).then(function (response) {
        const self = this
        // this.post = response
        // this.loading = false
        setTimeout(() => {
          self.text = response.bodyText
          self.post = response
          self.loading = false
        }, 600)
        console.log(response)
      }, function (error) {
        console.log(error.statusText)
      })
    },

    onSubmit (evt) {
      evt.preventDefault()
      alert(JSON.stringify(this.form))
    },

    onReset (evt) {
      evt.preventDefault()
      /* Reset our form values */
      this.form.email = ''
      this.form.name = ''
      this.form.food = null
      this.form.checked = []
      /* Trick to reset/clear native browser form validation state */
      this.show = false
      this.$nextTick(() => { this.show = true })
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.loading {
  box-sizing: border-box;
  position: absolute;
  z-index: 20;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;

  display: flex;
  justify-content: center;
  align-items: center;

  font-size: 1.2rem;
  color: #fff;
  background: rgba(52, 58, 64, 0.4);
}
</style>
