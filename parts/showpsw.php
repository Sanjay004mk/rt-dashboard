<script>
    const pinput = document.getElementById("password");
    const peye = document.getElementById("p-eye");
    if (peye)
        peye.addEventListener("click", function() {
            if (pinput.type === "password") {
                peye.classList.add("fa-eye-slash");
                peye.classList.remove("fa-eye");
                pinput.type = "text";
            } else {
                peye.classList.remove("fa-eye-slash");
                peye.classList.add("fa-eye");
                pinput.type = "password";
            }
        });

    var cinput = document.getElementById("confirmPassword");
    var ceye = document.getElementById("c-eye");
    if (ceye)
        ceye.addEventListener("click", function() {
            if (cinput.type === "password") {
                ceye.classList.add("fa-eye-slash");
                ceye.classList.remove("fa-eye");
                cinput.type = "text";
            } else {
                ceye.classList.remove("fa-eye-slash");
                ceye.classList.add("fa-eye");
                cinput.type = "password";
            }
        });
</script>