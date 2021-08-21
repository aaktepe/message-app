<template>
  <div class="py-5">
    <div class="container">
      <div class="row hidden-md-up">
        <div class="col-md-4">
          <div class="card">
            <div class="card-block" style="margin: 8px">
              <h4 class="card-title">Message {{ message.id }}</h4><br>
              <h6 class="card-subtitle text-muted">Name: {{ message.name }}</h6><br>
              <h6 class="card-subtitle text-muted">Email: {{ message.email }}</h6><br>
              <p class="card-text p-y-1">Message: {{ message.message }}</p>
            </div>
          </div>
        </div>
      </div>  
    </div>
  </div>
</template>
<script>

  function getCookie(cname) {
  let name = cname + "=";
  let decodedCookie = decodeURIComponent(document.cookie);
  let ca = decodedCookie.split(';');
  for(let i = 0; i <ca.length; i++) {
    let c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
  }
  const TOKEN = getCookie('token');
  var url = window.location.pathname;
  var id = url.substring(url.lastIndexOf('/') + 1);
    export default {
        mounted() {
             axios
              .get("http://127.0.0.1:8000/api/messages/"+ id, {
                headers: {
                  'Content-Type': 'application/json',
                  'Authorization': TOKEN
                }
              })
              .then((response)=>
              {
                this.message = response.data;
                console.log(response.data);
              })
            },
        data: function() {
            return {
              message:[]
            }
        },
    }
</script>
