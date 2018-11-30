<template>
  <div class="error-page">
    <h4 class="title">News</h4>

    <b-form @submit="onSubmit" @reset="onReset" v-if="show">
      <b-row>
        <b-col cols="8">
          <!-- <b-form @submit="onSubmit" @reset="onReset" v-if="show">
              <h4><strong>{{ form.title }}</strong></h4>
              <h6>{{ form.description }}</h6>

              <p>
                <b-img src="https://picsum.photos/300/150/?image=41" fluid alt="Fluid image" />
                <b-img src="https://picsum.photos/1024/400/?image=41" fluid alt="Responsive image" />
              </p>

              <div>{{ form.content }}</div>
          </b-form>-->
          <b-form-group label="Add new post:" label-for="post-title" class="h5">
            <b-form-input
              id="post-title"
              type="text"
              v-model="form.title"
              required
              placeholder="Post title"
            ></b-form-input>
          </b-form-group>

          <b-form-group label="Description:" label-for="post-description">
            <b-form-input
              id="post-description"
              type="text"
              v-model="form.description"
              required
              placeholder="Post description"
            ></b-form-input>
          </b-form-group>

          <b-form-group>
            <b-form-textarea
              id="post-subject"
              v-model="form.content"
              placeholder="Post subject"
              :rows="10"
              :max-rows="12"
            ></b-form-textarea>
          </b-form-group>

          <!-- <b-form-group>
              <b-form-checkbox-group v-model="form.checked" id="exampleChecks">
                <b-form-checkbox value="me">Check me out</b-form-checkbox>
                <b-form-checkbox value="that">Check that out</b-form-checkbox>
              </b-form-checkbox-group>
          </b-form-group>-->
          <p>
            <!-- <b-card img-src="form.src" img-alt="Card image" img-top></b-card> -->

            <b-img :src="form.image" fluid alt="Fluid image"/>
            <!-- <b-img src="https://picsum.photos/300/150/?image=41" fluid alt="Fluid image"/> -->
            <!-- <b-img src="https://picsum.photos/1024/400/?image=41" fluid alt="Responsive image" /> -->
          </p>
        </b-col>

        <b-col>
          <b-form-group>
            <b-button :pressed.sync="form.nofollow" variant="outline-primary" size="sm">nofollow</b-button>
            <b-button :pressed.sync="form.noindex" variant="outline-primary" size="sm">noindex</b-button>
          </b-form-group>

          <b-form-group label="Author:">
            <b-form-select required :options="authors" v-model="form.author"></b-form-select>
          </b-form-group>

          <b-form-group label="Date:" label-for="post-date">
            <b-form-input id="post-date" type="text" v-model="form.date" placeholder="Post date"></b-form-input>
          </b-form-group>

          <b-form-group label="District:" label-for="post-district">
            <b-form-input
              id="post-district"
              type="number"
              v-model="form.district"
              placeholder="Post district"
            ></b-form-input>
          </b-form-group>

          <b-form-group label="Rubric:" label-for="post-rubric">
            <b-form-input
              id="post-rubric"
              type="number"
              v-model="form.rubric"
              placeholder="Post rubric"
            ></b-form-input>
          </b-form-group>

          <b-form-group label="Tags:" label-for="post-tags">
            <b-form-input id="post-tags" type="text" v-model="form.tags" placeholder="Post tags"></b-form-input>
          </b-form-group>
        </b-col>
      </b-row>

      <br>
      <hr>

      <b-form-group>
        <b-button type="button" variant="secondary" @click="onBack">Back</b-button>
        <b-button type="submit" variant="primary">Save</b-button>
        <b-button type="button" variant="danger" @click="onDelete">Remove</b-button>
        <!-- <b-button type="reset" variant="danger">Reset</b-button> -->
      </b-form-group>
    </b-form>
  </div>
</template>

<script>
export default {
  name: 'pageSettings',
  data () {
    return {
      apiUrl: 'http://api.domain.loc/news/' + this.$route.params.id,
      form: {},
      authors: [
        'Inna Samoshevska',
        'Mike Wazowski',
        'James P. Sullivan',
        'George Sanderson',
        'Celia Mae',
        'BB King',
        'David Coverdale'
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
    $route: 'fetchData'
  },
  methods: {
    init: function () {
      // this.loadData()
    },

    onResponseData (response) {
      this.form = response.body
    },

    onResponseError (response) {
      console.log(response.status, response.statusText)
    },

    fetchData () {
      // setTimeout(() => {self.items = response.body}, 300)
      this.$http
        .get(this.apiUrl)
        .then(this.onResponseData, this.onResponseError)
    },

    onSubmit (evt) {
      var data = {data: this.form}
      var config = {
        headers: {
          'X-REST-Method': this.form.content.length ? 'PATCH' : 'PUT'
        }
      }

      this.$http.post(this.apiUrl, data, config).then(response => {
        console.log(response.status, response.statusText)
      })

      evt.preventDefault()
    },

    onDelete (evt) {
      var config = {
        headers: {
          'X-REST-Method': 'DELETE'
        }
      }

      this.$http.post(this.apiUrl, {}, config).then(response => {
        if (response.status === 200) {
          this.$router.push({ name: 'news' })
        }
      })

      evt.preventDefault()
    },

    onBack (evt) {
      this.$router.go(-1)
      evt.preventDefault()
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
      this.$nextTick(() => {
        this.show = true
      })
    }
  }
}
</script>
