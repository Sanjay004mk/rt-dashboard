<?php
// fetch_workers.php
if (!isset($_POST["projectId"]) && !isset($_POST["RequestType"])) {
    // Handle the case when project ID is not set in the POST request
    echo 'Error: Project not set.';
    exit;
}

// Database connection details
$servername = "localhost";
$dbUsername = "root";
$dbPassword = "";

// Database connection details for construction_projects
$constructionProjectsDB = "construction_projects";
$usersDB = "users";
$constructionProjectsConn = new mysqli($servername, $dbUsername, $dbPassword, $constructionProjectsDB);
$usersConn = new mysqli($servername, $dbUsername, $dbPassword, $usersDB);

// Check the connection
if ($constructionProjectsConn->connect_error) {
    die("Connection failed: " . $constructionProjectsConn->connect_error);
}

if ($usersConn->connect_error) {
    die("Connection failed: " . $usersConn->connect_error);
}

// Check if the project ID is set in the POST request
if (isset($_POST['projectId']) && isset($_POST['RequestType']) && $_POST['projectId'] != null) {

    $projectId = $_POST['projectId'];
    $requestType = $_POST['RequestType'];

    $stmtPrjName = $constructionProjectsConn->prepare("SELECT Name FROM `projects` WHERE ProjectID = ?");
    $stmtPrjName->bind_param("s", $projectId);
    $stmtPrjName->execute();
    $stmtPrjName->bind_result($projectName);
    $stmtPrjName->fetch();
    $stmtPrjName->close();

    if ($requestType === "Workers") {

        // Fetch user's projects from the construction_projects database
        $stmtProjects = $constructionProjectsConn->prepare("SELECT Name, Task, Status, Type FROM `workers` WHERE ProjectID = ?");
        $stmtProjects->bind_param("s", $projectId);
        $stmtProjects->execute();
        $stmtProjects->bind_result($wname, $task, $status, $type);
        $stmtProjects->store_result();

        $types = ['Full-time', 'Part-time', 'Contract'];
        $statii = ['Present', 'On leave'];
        // Close the connection to the construction_projects database

        // Echo the fetched worker information as HTML (replace this with your actual fetched data)
        echo '<h2>Workers\' Information for Project "' . $projectName . '"</h2>';
        echo '<table class="table table-striped table-sm">';
        echo '<thead><tr><th>Name</th><th>WorkerType</th><th>Task</th><th>Status</th></tr></thead>';
        echo '<tbody>';
        // Fetch and display worker information (replace this with your actual data retrieval logic)
        while ($stmtProjects->fetch())
            echo '<tr><td>' . $wname . '</td><td>' . $types[$type] . '</td><td>' . $task . '</td><td>' . $statii[$status] . '</td></tr>';
        // ... (additional rows based on fetched data)
        echo '</tbody></table>';
    }
    else if ($requestType === 'Materials') {
        // Fetch user's projects from the construction_projects database
        $stmtProjects = $constructionProjectsConn->prepare("SELECT Name, Supplier, Cost, QuantityAvail FROM `material` WHERE ProjectID = ?");
        $stmtProjects->bind_param("i", $projectId);
        $stmtProjects->execute();
        $stmtProjects->bind_result($mname, $supplier, $cost, $avail);
        $stmtProjects->store_result();

        // Close the connection to the construction_projects database

        // Echo the fetched worker information as HTML (replace this with your actual fetched data)
        echo '<h2>Materials\' Information for Project "' . $projectName . '"</h2>';
        echo '<table class="table table-striped table-sm">';
        echo '<thead><tr><th>Material</th><th>Supplier</th><th>Cost</th><th>Qty. Avail.</th></tr></thead>';
        echo '<tbody>';
        // Fetch and display worker information (replace this with your actual data retrieval logic)
        while ($stmtProjects->fetch())
            echo '<tr><td>' . $mname . '</td><td>' . $supplier . '</td><td>' . $cost . '</td><td>' . $avail . '</td></tr>';
        // ... (additional rows based on fetched data)
        echo '</tbody></table>';
    }
    else if ( $requestType === 'UpdateWorker') {
        $type = $_POST['type'];
        $task = $_POST['task'];
        $name = $_POST['name'];
        $status = $_POST['status'];
            

        $stmt = $constructionProjectsConn->prepare("SELECT Id FROM `workers` WHERE ProjectID = ? and Name = ?");
        $stmt->bind_param("ss", $projectId, $name);
        $stmt->execute();
        $stmt->bind_result($id);
        if ($stmt->fetch()) {
            echo "Altering";
            $stmt->close();
            $stmt = $constructionProjectsConn->prepare("UPDATE  workers SET Task=?, Type=?, Status=? WHERE Id=?");
            $stmt->bind_param("siii", $task, $type, $status, $id);
            $stmt->execute();
        } else {
            echo "inserting";
            $id = crc32($name . $type);
            $stmt->close();
            $stmt = $constructionProjectsConn->prepare("INSERT INTO workers(Task, Type, ProjectId, Name, Status, Id) VALUES(?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("siisii", $task, $type, $projectId, $name,  $status, $id);
            $stmt->execute();
        }

    }
    else if ( $requestType === 'UpdateMaterial') {
        $quantity = $_POST['quantity'];
        $supplier = $_POST['supplier'];
        $resource = $_POST['resource'];
        $rcost = $_POST['rcost'];

        $stmt = $constructionProjectsConn->prepare("SELECT * FROM `material` WHERE ProjectID = ?");
        $stmt->bind_param("s", $projectId);
        $stmt->execute();
        if ($stmt->fetch()) {
            $stmt->close();
            $stmt = $constructionProjectsConn->prepare("UPDATE  `material` SET Supplier=?, Cost=?, QuantityAvail=? WHERE ProjectID=?");
            $stmt->bind_param("siii", $supplier, $rcost, $quantity, $projectId);
            $stmt->execute();
        } else {
            $stmt->close();
            $stmt = $constructionProjectsConn->prepare("INSERT INTO material(Name, Supplier, Cost, QuantityAvail, ProjectID) VALUES(?, ?, ?, ?, ?)");
            $stmt->bind_param("ssiii", $resource, $supplier, $rcost, $quantity,  $projectId);
            $stmt->execute();
        }

    }
    
} else if (isset($_POST["RequestType"]) && $_POST["RequestType"] === 'ProjectSelect') {
    $uid = $_POST['Uid'];
    $project = $_POST['Project'];

    $stmtUserType = $usersConn->prepare('SELECT Type FROM `user details` WHERE UID = ?');
    $stmtUserType->bind_param('i', $uid);
    $stmtUserType->execute();
    $stmtUserType->bind_result($type);
    $stmtUserType->fetch();
    $stmtUserType->close();
    
    $col = $type === 0 ? "UID":"StkUID";
    $stmtPrjName = $constructionProjectsConn->prepare("SELECT ProjectId FROM `projects` WHERE Name = ?");
    $stmtPrjName->bind_param("s", $project);
    $stmtPrjName->execute();
    $stmtPrjName->bind_result($prjID);
    if ($stmtPrjName->fetch()) {
        $stmtPrjName->close();
        $stmtPrjName = $constructionProjectsConn->prepare("UPDATE `projects` SET ". $col ."=".$uid." WHERE ProjectId = ?");
        $stmtPrjName->bind_param("i",$prjID);
        $stmtPrjName->execute();
        echo $project ." ".$prjID;
    } else {
        $prjID = crc32($project . date("Y-m-d H:i:s"));

        $stmtPrjName = $constructionProjectsConn->prepare("INSERT INTO `projects` (Name, ProjectID, ".$col.") values (?, ?, ?)");
        $stmtPrjName->bind_param("sii", $project, $prjID, $uid);
        $stmtPrjName->execute();
        echo $project ." ". $prjID;
    }
    $stmtPrjName->close();
    
} else {
    
}

$constructionProjectsConn->close();
?>