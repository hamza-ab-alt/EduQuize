<?php
require_once "../../config/database.php";
$D=new Database();
$conn=$D->getConnection();
try {
    $sql="SELECT * FROM quizzes WHERE user_id=?";
    $stm=$conn->prepare($sql);
    $stm->execute([1]);
    $quizes=$stm->fetchAll();
} catch (PDOException $e) {
    echo  $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Weclcome in Home Page Prof</h1>
    <h3>Your quiz that you created</h3>
    <?php
    foreach ($quizes as $quiz) {
       ?>
       <div>
        <h1><?=$quiz["title"]?></h1>
        <p><?=$quiz["description"]?></p>
       </div>
       <?php
    }
    ?>
    <h1>create a new quiz</h1>
    <form action="#" method="post">
        <button>Add Quiz</button>
    </form>
    <table>
      <th>
        <td>id</td>
        <td>titre</td>
        <td>description</td>
        <td>Actions</td>
      </th>
      <tr>
      <?php
      foreach ($quizes as $quiz) {
        ?>
        <td><?=$quiz["id"]?></td>
        <td><?=$quiz["title"]?></td>
        <td><?=$quiz["description"]?></td>
        <button name="delete" value="<?=$quiz["id"]?>">delete</button>
        <button name="update" value="<?=$quiz["id"]?>">upadte</button>
        <?php
      }
      ?>
    </table>
</body>
</html>