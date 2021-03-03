<div class="container">
    <div class="row">
        <div class="col-lg-6 mx-auto">
            <div class="card card-body bg-light m-5">
                <h2>Login</h2>
                <form action="" method="post">
                    <div class="form-group">
                        <label for="email">Email:<sup>*</sup></label>
                        <input type="email" name="email" id="email" class="<?php echo (!empty($errors['emailErr'])) ? 'is-invalid' : ''; ?> form-control form-control-lg" value="<?php echo $email ?>">
                        <span class='invalid-feedback'><?php echo $errors['emailErr'] ?></span>
                    </div>
                    <div class="form-group">
                        <label for="password">Password:<sup>*</sup></label>
                        <input type="password" name="password" id="password" class="<?php echo (!empty($errors['passwordErr'])) ? 'is-invalid' : ''; ?> form-control form-control-lg" value="<?php echo $password ?>">
                        <span class='invalid-feedback'><?php echo $errors['passwordErr'] ?></span>
                    </div>

                    <div class="row">
                        <div class="col">
                            <input type="submit" value="Login" class="btn btn-primary btn-block">
                        </div>
                        <div class="col">
                            <a href="/register" class='btn btn-light btn-block '>No account? Register</a>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script>
    const login = document.getElementById('login')
    login.classList.add('active')
</script>