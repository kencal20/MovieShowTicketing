<?php
    include 'inc/header.php';

?>
<main>
  <div class="container d-flex flex-column align-items-center">
    <img src="logo.png" class="w-25 mb-3" alt="">
    <h2>Movie Show Ticketing System</h2>
    <p class="lead text-center">Add New Movie Show</p>
    <form action="" class="mt-4 w-75">
      <div class="mb-3">
        <label for="name" class="form-label">Movie Show Name</label>
        <input type="text" class="form-control" id="ms_name" name="ms_name" placeholder="Enter your Movie Show">
      </div>
      <div class="mb-3">
        <label for="Date" class="form-label">Show Date</label>
        <input type="Date" class="form-control" id="ms_date" name="ms_date" placeholder="Select your Date">
      </div>
      
      <div class="mb-3">
        <input type="submit" name="Create Show" value="Create Show" class="btn btn-dark w-100">
      </div>
    </form>
    </div>
</main>

<?php
    include 'inc/footer.php';

?>