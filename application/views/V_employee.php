<div>
  <table border="1">
    <tr>
      <th>NIP</th>
      <th>User ID</th>
      <th>User Name</th>
      <th>Full Name</th>
    </tr>
    <?php
      foreach($employee as $k=>$v) {
    ?>
    <tr>
      <td><?php echo $v['NIP'];?></td>
      <td><?php echo $v['USER_ID'];?></td>
      <td><?php echo $v['USER_NAME'];?></td>
      <td><?php echo $v['FULL_NAME'];?></td> 
    </tr>
    <?php } ?>
  </table>
</div>
