<template>
    <div>
         <main>
            <!-- end of insights-->
            <div class="recent-orders">
                <h2>Users</h2>
              
              <div class="control-panel">
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Orders</th>
                            <th>Joined</th>
                            <th></th>
                         
                        </tr>
                    </thead>
                   
  <tbody>
     <tr v-for="user in users.data" :key="user.id">
   
      <td>{{user.name}}</td>
        <td>{{user.email}}</td>
      <td>{{user.phone}}</td>
      <td>{{user.orders}}</td>
        <td>{{user.joined_at}}</td>

     
     
         <td style="cursor: pointer; color: #209cf0;">
         <button style="background: transparent;" type="button">
             <span style="cursor: pointer;" class="danger material-icons-sharp">person_off</span></button>



      </td>
      
      
    </tr>
                     
                    </tbody>
                </table>
              </div>
              <div class="pagination">
              <Pagination  :data="users" @pagination-change-page="getUsers" />
              </div>
            </div>
        </main>
    </div>
</template>

<script>
import LaravelVuePagination from 'laravel-vue-pagination';

export default {
     components: {
        'Pagination': LaravelVuePagination

    },
    data() {
        return {
            users : {},
            user: {},

        }
    },
    methods: {
      getUsers() {
          
            axios.get('/api/users').then(res => {
                this.users = res.data;
            }).catch(err => console.log(err));
        },
        getUser(id)
            {
                 axios.get('/api/users/' + id)
                .then(res => {
                  
                    this.user = res.data.data;
                }).catch(error => console.log(error));
            },
    },
    mounted() {
        this.getUsers();
    }

}
</script>