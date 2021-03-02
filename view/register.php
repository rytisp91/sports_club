<div class="container">
    <div class="row">
        <div class="col-lg-6 mx-auto">
            <div class="card card-body bg-light mt-5">
                <h2>Create an account</h2>
                <form action="" method="post">
                    <div class="form-group">
                        <label for="name">Name:<sup>*</sup></label>
                        <input type="text" name="name" id="name" class="<?php echo (!empty($errors['nameErr'])) ? 'is-invalid' : ''; ?> form-control form-control-lg" value="<?php echo $name ?>">
                        <span class='invalid-feedback'><?php echo $errors['nameErr'] ?></span>
                    </div>
                    <div class="form-group">
                        <label for="name">Surname:<sup>*</sup></label>
                        <input type="text" name="surname" id="surname" class="<?php echo (!empty($errors['surnameErr'])) ? 'is-invalid' : ''; ?> form-control form-control-lg" value="<?php echo $surname ?>">
                        <span class='invalid-feedback'><?php echo $errors['surnameErr'] ?></span>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:<sup>*</sup></label>
                        <input type="text" name="email" id="email" class="<?php echo (!empty($errors['emailErr'])) ? 'is-invalid' : ''; ?> form-control form-control-lg" value="<?php echo $email ?>">
                        <span class='invalid-feedback'><?php echo $errors['emailErr'] ?></span>
                    </div>
                    <div class="form-group">
                        <label for="password">Password:<sup>*</sup></label>
                        <input type="password" name="password" id="password" class="<?php echo (!empty($errors['passwordErr'])) ? 'is-invalid' : ''; ?> form-control form-control-lg" value="<?php echo $password ?>">
                        <span class='invalid-feedback'><?php echo $errors['passwordErr'] ?></span>
                    </div>
                    <div class="form-group">
                        <label for="confirmPassword">Confirm Password:<sup>*</sup></label>
                        <input type="password" name="confirmPassword" id="confirmPassword" class="<?php echo (!empty($errors['confirmPasswordErr'])) ? 'is-invalid' : ''; ?> form-control form-control-lg" value="<?php echo $confirmPassword ?>">
                        <span class='invalid-feedback'><?php echo $errors['confirmPasswordErr'] ?></span>
                    </div>
                    <div class="form-group">
                        <label for="phone">Your phone number:</label>
                        <input type="text" name="number" id="number" class="form-control form-control-lg" value="<?php echo $number ?>">
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="password" name="address" id="address" class="form-control form-control-lg" value="<?php echo $address ?>">
                    </div>

                    <div class="row">
                        <div class="col">
                            <input type="submit" value="Register" class="btn btn-primary btn-block">
                        </div>
                        <div class="col">
                            <a href="/login" class='btn btn-light btn-block '>Have an account? Login</a>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script>
    const register = document.getElementById('register')
    register.classList.add('active')
</script>