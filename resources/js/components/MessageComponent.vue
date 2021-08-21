<template>
  <div class="container">
    <h1>Contact Form</h1>
    <form action="#" @submit.prevent="createMessage()">
      <div class="form-group">
        <label>Name</label>
        <input v-model="message.name" type="text" name="name" class="form-control" required>
      </div>
      <div class="form-group">
        <label>Email</label>
        <input v-model="message.email" type="text" name="email" class="form-control" required>
      </div>
      <div class="form-group">
        <label>Message</label>
        <input v-model="message.message" type="textarea" name="message" class="form-control" required>
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-primary">Send Message</button>
        <a href="/login" class="btn btn-primary" role="button">Login</a>
      </div>
    </form>
  </div>
</template>

<script>
import axios from 'axios';
  export default {
    data: function(){
      return {
        list:[],
        message:{
          name:'',
          email:'',
          message:''
        }
      }
    },
    methods: {
      createMessage: function(){
        axios.post('api/messages', this.message).then(response => {
          alert("Your contact form created succesfully! :)");
          window.location.reload();
        })
      }
    }
  }
</script>