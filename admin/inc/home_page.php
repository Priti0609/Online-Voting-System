<div class="col-12 my-3">
        <h3>Elections</h3>
    <table class="table">
     <thead>
        <tr>
          <th scope="col mr-3">S_No</th>
          <th scope="col mr-3">Election Name</th>
          <th scope="col mr-3"># Candidates</th>
          <th scope="col mr-3">Starting Date</th>
          <th scope="col mr-3">Ending Date</th>
          <th scope="col mr-3">Status</th>
          <th scope="col mr-3">Action</th>
        </tr>
      </thead>
      <tbody>
      <?php
           $query="SELECT * FROM election";
           $fetchdata=mysqli_query($db,$query);
           $is_any_election = mysqli_num_rows($fetchdata);

           if($is_any_election)
           {
             $s_no=1;
             while($row = mysqli_fetch_assoc($fetchdata))
             {
               $election_id = $row['id'];
        ?>
              <tr>
                 <td><?php echo $s_no++;?> </td>
                 <td><?php echo $row['election_topic'];?> </td>
                 <td><?php echo $row['no_of_candidtes'];?> </td>
                 <td><?php echo $row['starting_date'];?> </td>
                 <td><?php echo $row['ending_date'];?> </td>
                 <td><?php echo $row['status'];?> </td>
                 <td>
                    <a href="index.php?viewResults=<?php echo $election_id; ?>"  class="btn btn-sm btn-success"> View Results </a>
                    
             </td>



             </tr>
        <?php
             }

           }
           else
           {
         ?>
             <tr>
                <td colspan="4"><b>Any election is not yet added</b> </td>
            </tr>
         <?php

           }

        ?>
        
    
       </tbody>
       
    </table>
   </div>

</div>
