<footer class="home-footer">
        <p>Light Mode</p>
        <div style="display:flex; align-items: center;">
            <label class="switch">
                <input type="checkbox" id="light-mode-toggle">
                    <span class="slider round"></span>
            </label>
        </div>
</footer>

<?php
    include("server_error_handler.php");
?>

<script >

const checkbox = document.getElementById('light-mode-toggle');

// Add an event listener for the 'change' event
checkbox.addEventListener('change', function() {
    // Call your function with the checkbox state
    changeColor(this.checked);
    if (this.checked)
        var status = "true";
    else
        var status = "false";
    document.cookie = "lightmode=" + status;
});

// Your function to handle checkbox state change
function changeColor(checked) {
    // Get the root element (:root) to access CSS variables
    const root = document.documentElement;

    const darkbg = getComputedStyle(root).getPropertyValue('--dark-bg');
    const darkheader = getComputedStyle(root).getPropertyValue('--dark-header');
    const darkfooter = getComputedStyle(root).getPropertyValue('--dark-footer');
    const darkaccent = getComputedStyle(root).getPropertyValue('--dark-accent');
    const darktext = getComputedStyle(root).getPropertyValue('--dark-text');

    const lightbg = getComputedStyle(root).getPropertyValue('--light-bg');
    const lightheader = getComputedStyle(root).getPropertyValue('--light-header');
    const lightfooter = getComputedStyle(root).getPropertyValue('--light-footer');
    const lightaccent = getComputedStyle(root).getPropertyValue('--light-accent');
    const lighttext = getComputedStyle(root).getPropertyValue('--light-text');


    if (checked) {
        root.style.setProperty('--bg', lightbg);
        root.style.setProperty('--header', lightheader);
        root.style.setProperty('--footer', lightfooter);
        root.style.setProperty('--accent', lightaccent);
        root.style.setProperty('--text', lighttext);

        root.style.setProperty('--opp-bg', darkbg);
        root.style.setProperty('--opp-header', darkheader);
        root.style.setProperty('--opp-footer', darkfooter);
        root.style.setProperty('--opp-accent', darkaccent);
        root.style.setProperty('--opp-text', darktext);

    } else {
        root.style.setProperty('--opp-bg', lightbg);
        root.style.setProperty('--opp-header', lightheader);
        root.style.setProperty('--opp-footer', lightfooter);
        root.style.setProperty('--opp-accent', lightaccent);
        root.style.setProperty('--opp-text', lighttext);

        root.style.setProperty('--bg', darkbg);
        root.style.setProperty('--header', darkheader);
        root.style.setProperty('--footer', darkfooter);
        root.style.setProperty('--accent', darkaccent);
        root.style.setProperty('--text', darktext);
    }
}


<?php
    $isLight = 'true';
    if (isset($_COOKIE['lightmode'])) {
        $_SESSION['lightmode'] = $_COOKIE['lightmode'];
        $isLight = $_COOKIE['lightmode'];
    } else {
        $_SESSION['lightmode'] = $isLight;
        $_COOKIE['lightmode'] =  $isLight;
    }

    if ($isLight == 'true') {
        echo 
        "
            window.addEventListener('load', function() {
                changeColor(true);
            });
            checkbox.checked = true;
        ";
    }
?>

</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
