<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.9/dist/sweetalert2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function bildirimGoster(text, state = true) {

        if (state != true) {
            bildirimiconu = "error";
        } else {
            bildirimiconu = "success";
        }
        Swal.fire({
            position: "center",
            icon: bildirimiconu,
            title: text,
            showConfirmButton: false,
            timer: 3500
        });
    }
</script>
<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
};
if (isset($_GET['success']) && isset($_GET['mesaj'])) {
    echo "<script>";
    echo " bildirimGoster(" . json_encode($_GET['mesaj']) . ", true); ";
    echo "</script>";
} elseif (isset($_GET['error']) && isset($_GET['mesaj'])) {
    echo "<script>";
    echo " bildirimGoster(" . json_encode($_GET['mesaj']) . ", false); ";
    echo "</script>";
}
if (isset($_SESSION['success'])) {
    echo "<script>";
    echo " bildirimGoster(" . json_encode($_SESSION['success']) . ", true); ";
    echo "</script>";

    unset($_SESSION["success"]);
} elseif (isset($_SESSION['error'])) {
    echo "<script>";
    echo " bildirimGoster(" . json_encode($_SESSION['error']) . ", false); ";
    echo "</script>";
    unset($_SESSION["error"]);
}

?>