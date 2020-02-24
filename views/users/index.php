<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
?>
<h4>List of all Users</h4>

   
<style>
table.GeneratedTable {
  width: 100%;
  background-color: #ffffff;
  border-collapse: collapse;
  border-width: 2px;
  border-color: #57a877;
  border-style: solid;
  color: #000000;
}

table.GeneratedTable td, table.GeneratedTable th {
  border-width: 2px;
  border-color: #57a877;
  border-style: solid;
  padding: 3px;
}

table.GeneratedTable thead {
  background-color: #2e67d1;
  color: #ffffff;
}
</style>

<table class="GeneratedTable">
  <thead>
    <tr>
      <th>id User</th>
      <th>Name</th>
      <th>Surname</th>
      <th>E-mail</th>
      <th>Date of birth</th>
      <th>Date of created</th>
      <th>Date of update</th>
    </tr>
  </thead>
  <tbody>
  	<?php foreach ($users as $user): ?>
    <tr>
      <td><?= $user->id_User ?></td>
      <td><?= $user->firstname ?></td>
      <td><?= $user->surname ?></td>
      <td><?= $user->email ?></td>
      <td><?= $user->birthdate ?></td>
      <td><?= $user->dateOnCreate ?></td>
      <td><?= $user->dateUpdateEntry ?></td>
       </tr>
       <?php endforeach; ?>
  </tbody>
</table>

<?= LinkPager::widget(['pagination' => $pagination]) ?>