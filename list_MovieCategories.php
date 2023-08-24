<?php
include 'inc/header.php';

//View or Show all Movie categories
$sql = "Select * from movie_categories";
$exec = mysqli_query($con, $sql);
$result = mysqli_fetch_all($exec, MYSQLI_ASSOC) //Store all data from category table into $result



?>
<div class="container d-flex flex-column align-items-center">

    <h2>List of Movie Categories </h2>
    <?php if (empty($result)); ?>
    <h3>
        <?php echo "No Movies found"; ?></h3>
    <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th width="33%">Category Id</th>
                <th width="33%">Category Name </th>


            </tr>
        </thead>
        <?php foreach ($result as $Cat) : ?>
            <tr>
                <td> <?php echo $Cat['Category_ID']; ?> </td>
                <td> <?php echo $Cat['Category_Name']; ?></td>

            </tr>
        <?php endforeach ?>
    </table>
</div>

<?php
include 'inc/footer.php';

?>