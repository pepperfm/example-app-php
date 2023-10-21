<?php
/**
 * @var \App\Models\Task $task
 */
require 'views/layouts/main.php'
?>
<header>
    <div class="container">
        <h1 class="h1 text-center">Update Task</h1>
    </div>
</header>

<section>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-6">
                <form action="/tasks/edit?id=<?php echo $task->id ?>" method="post">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input
                            type="text"
                            name="name"
                            id="name"
                            class="form-control"
                            placeholder="Name..."
                            required="required" value="<?php echo $task->name; ?>"
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
                            value="<?php echo $task->email; ?>"
                        >
                    </div>
                    <div class="form-group">
                        <label for="text">Text</label>
                        <input
                            type="text"
                            name="text"
                            id="text"
                            class="form-control"
                            placeholder="text"
                            value="<?php echo $task->text; ?>">
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="0" <?= !$task->status ? 'selected' : '' ?>>New</option>
                            <option value="1" <?= $task->status ? 'selected' : '' ?>>Done</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input class="btn btn-block btn-success" type="submit" value="Update">
                    </div>
                    <div class="form-group mt-4">
                        <a class="btn btn-block btn-warning" href="/tasks">Back To List</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<?php require 'views/layouts/bottom.php' ?>
