<template>
<div>
 <main>
            <!-- end of insights-->
            <div class="recent-orders">
                <h2>Notifications</h2>
              
              <div class="control-panel">
               
                <table>
                    <thead>
                        <tr>
                            <th></th>
                            <th>Notification</th>
                            <th>Type</th>
                            <th>Date</th>
                            <th></th>
                         
                        </tr>
                    </thead>
                   
  <tbody>
     <tr v-for="notification in unreadNotifications" :key="order.id">
   
      <td>#{{notification.label}}</td>
        <td>{{notification.type}}</td>
      <td>{{notification.created.at}}</td>

     
     
         <td style="cursor: pointer; color: #209cf0;">
         <router-link  :to="{ name: notification.data.link}">
                Details
                </router-link>


      </td>
      
      
    </tr>
                     
                    </tbody>
                </table>
              </div>
</div>
</main>
</div>
</template>

<script>
export default {
    data() {
        return {
            unreadNotifications : {},
        };
    },
    methods : {
         getNotifications() {
      axios.get('/api/dashbord/notifications').then(res => {
          this.unreadNotifications = res.data;
       
      }).catch(err => console.log(err));
  }
    }
}
</script>