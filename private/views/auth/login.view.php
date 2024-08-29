<?php $this->view('includes/header') ?>

<div class="container-fluid">

    <div class="p-4 mx-auto mr-4 shadow rounded" style="margin-top: 50px;width:100%;max-width: 340px;">
        <h2 class="mb-3 text-center">Impact School</h2>
        <img src="<?= ASSETS ?>/images/school_logo.png" class="d-block mx-auto rounded-circle" style="width:100px;">
        <h3>Login</h3>
        <input class="mb-3 form-control" type="email" name="email" placeholder="Email">
        <input class="mb-3 form-control" type="password" name="password" placeholder="Password">
        <button class="mb-3 btn btn-primary">Login</button>
    </div>
</div>

<?php $this->view('includes/footer') ?>