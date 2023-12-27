<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<?php 
    include("parts/html_head.php");
?>

<body>

    <?php
        if ((!isset($_SESSION['User'])) || (!isset($_COOKIE['User']))) {
            header("Location: login.php");
        }
        else {

        }
    ?>

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

        const all_views = ['overview', 'worker', 'material', 'cost', 'machinery', 'env-impact'];

        function showView(view) {
            document.getElementById(view).style.display = 'flex';

            var others = all_views.filter(item => item !== view);
            for (let v of others)
                document.getElementById(v).style.display = 'none';
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

        <div class="db-sidebar">
            <button onclick="showView('overview')">Overview</button>
            <button onclick="showView('worker')">Workers</button>
            <button onclick="showView('material')">Materials</button>
            <button onclick="showView('cost')">Cost</button>
            <button onclick="showView('machinery')">Machinery</button>
            <button onclick="showView('env-impact')">Environment</button>
            <button>Account</button>
        </div>

        <div class="db-view">

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

            <div id="worker" class="db-worker-view">

                <!-- select and update worker details -->
                <div class="db-worker-tab">
                    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        
                        <label>Worker Type:</label>
                        <select name="worker-type" id="type">
                            <option value="present">Full time</option>
                            <option value="present">Part time</option>
                            <option value="on-leave">Contract</option>
                        </select>

                        <label for="name">Search Worker:</label>
                        <input type="text" id="name" name="name" placeholder="Name" required>
                        
                        <label>Status:</label>
                        <select name="woker-status" id="status">
                            <option value="present">Present</option>
                            <option value="on-leave">On Leave</option>
                        </select>

                        <label for="task">Assign task:</label>
                        <input type="text" id="itask" name="wo-task" placeholder="Task" required>

                        <button>Update</button>
                    </form>
                </div>

                <!-- display selected workers history and tasks assigned -->
                <div class="db-worker-tab">
                    <label>Task History:</label>
                    <p>Current task: Some work</p>
                    <p>From: 00-00 to 00-00</p>
                    <p>Some other work</p>
                    <hr class="dashboard-hr">

                    <label>Days present:</label>
                    <p>00-00-00</p>
                    <p>00-00-00</p>
                    <p>00-00-00</p>
                    <p>00-00-00</p>
                    <p>00-00-00</p>
                    <p>00-00-00</p>
                    <p>00-00-00</p>
                    <p>00-00-00</p>
                    <p>00-00-00</p>
                    <p>00-00-00</p>
                    <p>00-00-00</p>
                    <p>00-00-00</p>
                    <p>00-00-00</p>

                </div>

                <!-- display all workers in selected field -->
                <div class="db-worker-tab">
                    <label>Other workers:</label>
                    <p>Worker1</p>
                    <p>Worker1</p>
                    <p>Worker1</p>
                    <p>Worker1</p>
                    <p>Worker1</p>
                    <p>Worker1</p>
                </div>
            </div>
            
            <div id="material" class="db-material-view">
                <div class="db-material-tab-left">
                    <label>Materials:</label>
                    <button>Bricks</button>
                    <button>Stone</button>
                    <button>Sand</button>
                    <button>Steel</button>
                    <button>Cement</button>
                    <button>Paint</button>
                    <button>Plumbing material</button>
                    <button>Wiring</button>
                </div>    
                <div class="db-material-tab-right">
                    <label>Supplier:</label>
                    <p>ABC Co.</p>
                    <label>Cost:</label>
                    <p>$999.99</p>
                    <label>Quantity Bought:</label>
                    <p>5000kg</p>
                    <label>Quantity Used:</label>
                    <p>3000kg</p>
                    <label>Quantity Available:</label>
                    <p>2000kg</p>
                </div>
            </div>

            <div id="cost" class="db-cost-view">COST</div>
            <div id="overview" class="db-overview">HELLO</div>
            <div id="machinery" class="db-machine-view">MACHINERY</div>
            <div id="env-impact" class="db-env-view">ENV IMPACT</div>
        </div>
    </div>

    <script>
        showView('worker');
    </script>

    <?php
        include("parts/footer.php");
    ?>

</body>

</html>
