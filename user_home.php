<?php session_start() ?>
<!DOCTYPE html>
<html lang="en">

<?php 
    include("parts/html_head.php");
?>

<body>
    <?php
        $extra_buttons = array(
            array("name"=>"Logout", "href"=>"login.php", "class"=>"button")
        );
        include("parts/header.php");
    ?>

    <script>
        function toggleProjectList() {
            var list = document.getElementById('project-dropdown');
            if (list.style.display == "block")
                list.style.display = "none";
            else
                list.style.display = "block";
            
        }

        // Close the dropdown menu if the user clicks outside of it
        window.onclick = function(event) {{
            if (event.target.id == 'prjTitle' || event.target.id == 'prjListDD') 
                toggleProjectList();
            else
                document.getElementById('project-dropdown').style.display = "none";
        }}

    </script>

    <div class="dashboard">
        <div class="dashboard-header">
            <div class="prj-title-holder">                    
                <span id="prjTitle" class="db-prj-title">Current Project</span><i class="fa fa-thin fa-chevron-down" id="prjListDD"></i>
                <div id="project-dropdown" class="project-list" >
                    <a href="#">Project Other</a><hr>
                    <a href="#">Yet another project</a><hr>
                    <a href="#">YOLO</a>
                </div>
            </div>
            
            <span class="db-header-end">Status: In progress</span>
            <hr class="db-vl">
            <span class="db-header-item">Start Date: 00-00-0000</span>
        </div>
        <hr class="dashboard-hr">
        
        <div class="db-sidebar">

        </div>
        
    </div>

    <?php
        include("parts/footer.php");
    ?>

</body>

</html>
