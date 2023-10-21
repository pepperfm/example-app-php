<?php
require 'views/layouts/main.php'
?>
    <header>
        <div class="container">
            <h1 class="h1 text-center">Create new Task</h1>
        </div>
    </header>

    <section>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-6">
                    <form action="/tasks/store" method="post">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input
                                type="text"
                                name="name"
                                id="name"
                                class="form-control"
                                placeholder="name"
                                required="required"
                            >
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input
                                type="email"
                                name="email"
                                id="email"
                                class="form-control"
                                placeholder="email"
                            >
                        </div>
                        <div class="form-group">
                            <label for="text">Text</label>
                            <textarea
                                type="text"
                                name="text"
                                id="text"
                                class="form-control"
                                placeholder="text"
                                rows="4"
                                style="resize: none"
                            ></textarea>
                        </div>
                        <div class="form-group">
                            <input class="btn btn-block btn-outline-success" type="submit" value="Submit">
                        </div>
                        <div class="form-group mt-4">
                            <a class="btn btn-block btn-info" href="/tasks">Back To List</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

<?php require 'views/layouts/bottom.php' ?>
