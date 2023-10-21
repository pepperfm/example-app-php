<?php
require 'views/layouts/main.php';
?>

<section>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-6">
                <form action="/login" method="post">
                    <div class="form-group">
                        <label for="login">Login</label>
                        <input
                            type="text"
                            name="login"
                            id="login"
                            class="form-control"
                            placeholder="login"
                            required="required"
                        >
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input
                            type="password"
                            name="password"
                            id="password"
                            class="form-control"
                            placeholder="password"
                            required="required"
                        >
                    </div>
                    <div class="form-group">
                        <input class="btn btn-block btn-primary" type="submit" value="Login">
                    </div>
                    <div class="form-group mt-4">
                        <a class="btn btn-block btn-warning" href="/tasks">Back To List</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php require 'views/layouts/bottom.php' ?>
