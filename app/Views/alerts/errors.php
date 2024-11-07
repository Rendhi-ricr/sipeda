<?php if (isset($validation) || isset($error) || session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show p-3" role="alert">
        <?php
        echo session()->getFlashdata('error');
        echo $error ?? '';
        ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif ?>