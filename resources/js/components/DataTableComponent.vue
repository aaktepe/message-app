<template>
  <div class="container">
      <table id="datatable" class="display" cellspacing="0" width="100%">
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Message</th>
            <th>Delete</th>
            <th>Link</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>    
  </div>
</template>
 
<script>
//Bootstrap and jQuery libraries
import 'bootstrap/dist/css/bootstrap.min.css';
import 'jquery/dist/jquery.min.js';
//Datatable Modules
import "datatables.net-dt/js/dataTables.dataTables"
import "datatables.net-dt/css/jquery.dataTables.min.css"
import $ from 'jquery'; 
 
 
import axios from 'axios';

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
const TOKEN = getCookie('token')
export default {
  created(){
    $(document).ready( function () {

      //$.noConflict();
      var table = $('#datatable').DataTable({
          "processing": true,
          "serverSide": true,
          "ajax": {
            "url": "api/messages/",
            "dataType": "json",
            "type": "get",
            "headers": {
              "Authorization": TOKEN
            },
            },
          "columns": [
              { "data": "id" },
              { "data": "name" },
              { "data": "email" },
              { "data": "message" },
              {
                "targets": -1,
                "data": null,
                "defaultContent": '<button class="btn btn-danger">Delete</button>',
                "searchable": false
              },
              {
                "targets": -1,
                "data": null,
                "defaultContent": '<a class="btn btn-primary" href="#" role="button">Link</a>',
                "searchable": false
              }
          ]
      });

        $('#datatable tbody').on( 'click', 'button', function () {
        var data = table.row( $(this).parents('tr') ).data();
        console.log(data);
        axios.delete('api/messages/'+data.id, {
        headers: {
          'Content-Type': 'application/json',
          'Authorization': TOKEN
        }
      }).then(response => {
        console.log(response);
        alert("Message deleted succesfully! :)");
        window.location.reload();
      })
      .catch(function(error) {
          alert(error);
      })
    } );

      $('#datatable tbody').on( 'click', 'a', function () {
        var data = table.row( $(this).parents('tr') ).data();
        console.log(data);
        window.location.replace('messages/'+ data.id);
    });
    });

  },
  data: function() {
        return {
        }
  }

}
</script>

    