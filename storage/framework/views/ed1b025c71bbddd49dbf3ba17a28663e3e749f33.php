<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Welcome to RMP</title>
        <link href="/css/app2.css" rel="stylesheet">
    </head>

    <body>

        <form action="/export" method="post" id="student_form">
            <?php echo e(csrf_field()); ?>


            <div class="header">
                <div><img src="/images/logo.png" alt="RMP Logo" title="RMP logo" width="100%"></div>
                <?php if(session('alert')): ?>
                    <div class="alert alert-warning">
                        <?php echo e(session('alert')); ?>

                    </div>
                <?php endif; ?>
            </div>

            <div style='margin: 10px; text-align: center;'>
                <table class="student-table">
                    <tr>
                        <th>Filename</th>
                        <th>Size(bytes)</th>
                        <th>Last Modified</th>
                        <th>Download</th>
                    </tr>

                    <?php if(  count($files) > 0 ): ?>
                    <?php $__currentLoopData = $files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($file['name']); ?></td>
                        <td><?php echo e($file['size']); ?></td>
                        <td><?php echo e($file['last_modified']); ?></td>
                        <td><a target="_blank" href="/download?file=<?php echo e($file['name']); ?>">Download</a></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="6" style="text-align: center">Oh dear, no data found.</td>
                    </tr>
                    <?php endif; ?>
                </table>
            </div>

        </form>

        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
        <script>
          $(document).ready(function() {


          });
        </script>
    </body>

</html>
