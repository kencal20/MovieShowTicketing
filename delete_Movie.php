<?php
    include 'inc/header.php';

    $_SESSION['delete'] =$_GET['delete'];
    $delete = $_SESSION['delete'];
    $msg = '';

    $sql = "delete from movies where movie_ID='$delete'";
    var_dump($sql);
    if(mysqli_query($con, $sql))
    {
      $msg ='Record deleted Successfully';
    }
    else{$msg ='Record not deleted';}



?>

<main>
  <div class="container d-flex flex-column align-items-center">
   
      <?php echo $msg; ?>
</div>
</main>

<?php
    include 'inc/footer.php';

?>
