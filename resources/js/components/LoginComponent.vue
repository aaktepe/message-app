<template>
    <div class="container">
      <div class="row mt-4">
        <div class="col-6 offset-3">
          <form action="#" @submit.prevent="handleLogin">
            <h2>Login for messages</h2>
            <div class="form-row">
              <input type="email" name="email" class="form-control" placeholder="Email Address" v-model="formData.email">
            </div>
            <div class="form-row">
              <input type="password" name="password" class="form-control" placeholder="Password" v-model="formData.password">
            </div>
            <div class="form-row">
              <button type="submit" class="btn btn-primary">Sign in</button>
            </div>
          </form>
        </div>
      </div>
    </div>
</template>

<script>
import axios from 'axios';

    export default {
      data() {
        return {
          messages: [],
          formData: {
            email: '',
            password: ''
          }
        }
      },
      methods: {
        handleLogin(){
          axios.get('/sanctum/csrf-cookie').then(response => {
            axios.post('api/login', this.formData)
            .then(response => {
                document.cookie = "token=Bearer "+ response.data.token +"; expires=Thu, 18 Dec 2022 12:00:00 UTC; path=/messages";
                console.log(response);
                const TOKEN = response.data.token;
                const BASEURL = 'http://127.0.0.1:8000/';
                const ENDPOINT = '/api/messages';
                axios.create({
                        baseURL: BASEURL,
                        headers: {
                            'Content-Type': 'application/json',
                            'Authorization': 'Bearer '+TOKEN
                        }
                    })
                    .get(ENDPOINT)
                    .then(res => {
                      window.location = '/messages';
                    });
            }).catch(function(error) {
                alert(error);
            })
          });
        }
      }
    }
</script>
<style>
  .form-row {
    margin-bottom: 1em;
  }
</style>
