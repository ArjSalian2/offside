<?php
    if (isset($success_message)) {
        foreach ($success_message as $success_message) {
            echo '<script>swal("'.$success_message. '", "", "success");</script>';
        }
    }
    if (isset($error_message)) {
        foreach ($error_message as $error_message) {
            echo '<script>swal("'.$error_message. '", "", "success");</script>';
        }
    }

    if (isset($info_message)) {
        foreach ($info_message as $info_message) {
            echo '<script>swal("'.$info_message. '", "", "success");</script>';
        }
    }
    if (isset($warning_message)) {
        foreach ($warning_message as $warning_message) {
            echo '<script>swal("'.$warning_message. '", "", "success");</script>';
        }
    }   

?>