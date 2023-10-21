<?php
/**
 * @var array<array-key, \App\Models\Task> $tasks
 * @var ?\App\Models\User $user
 */
require 'views/layouts/main.php';
?>
    <header class="mt-4 mb-4">
        <div class="container">
            <h1 class="h1 text-center">To Do List</h1>
            <div class="row mt-4">
                <div class="col-6">
                    <a class="btn btn-block btn-outline-primary" href="/tasks/create">Create New Task</a>
                </div>
                <div class="col-6">
                    <?php if($user?->isAdmin): ?>
                    <a class="btn btn-block btn-outline-info" href="/logout">Logout</a>
                    <?php else: ?>
                    <a class="btn btn-block btn-outline-info" href="/login">Login</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </header>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div style="height: 400px; overflow: auto;">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>
                                    <a href="?sort=id&order=asc">ID</a>
                                </th>
                                <th>
                                    <a href="?sort=name&order=asc">Name</a>
                                </th>
                                <th>
                                    <a href="?sort=email&order=asc">Email</a>
                                </th>
                                <th>Text</th>
                                <th>
                                    <a href="?sort=status&order=asc">Status</a>
                                </th>
                                <?php if($user?->isAdmin): ?>
                                <th>Actions</th>
                                <?php endif; ?>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($tasks as $index => $task) : ?>
                                <tr>
                                    <td><?= $task->id ?></td>
                                    <td><?= $task->name ?></td>
                                    <td><?= $task->email ?></td>
                                    <td><?= $task->text ?></td>
                                    <td><?= $task->statusLabel() ?></td>
                                    <?php if($user?->isAdmin): ?>
                                    <td>
                                        <a href="/tasks/edit?id=<?= $task->id ?>" class="btn btn-success">Edit</a>
                                        <a href="/tasks/delete?id=<?= $task->id ?>" class="btn btn-danger delete-task">Delete</a>
                                    </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; ?>

                            </tbody>
                        </table>
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <li class="page-item">
                                    <a class="page-link" href="?page=1" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                <?php for($page = 1; $page < $total; $page++): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="?page=<?= $page ?>&sort=<?= $sortField ?>&order=<?= $order ?>"">
                                            <?= $page ?>
                                        </a>
                                    </li>
                                <?php endfor; ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?= $lastPage ?>" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php require 'views/layouts/bottom.php' ?>
