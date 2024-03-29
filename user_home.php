<?php
// Start the session
session_start();

// Check if the 'User' cookie is set
if (!isset($_COOKIE['User']) && !isset($_SESSION['User'])) {
  // Redirect to the login page if the user is not logged in
  header("Location: login.php");
  exit();
}

// Database connection details
$servername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "users";

// Connect to MySQL
$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbName);

// Check the connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Fetch user details
$uid = $_COOKIE['User'];
$stmtUser = $conn->prepare("SELECT Name, Type FROM `user details` WHERE UID = ?");
$stmtUser->bind_param("s", $uid);
$stmtUser->execute();
$stmtUser->bind_result($userName, $type);
$stmtUser->fetch();
$stmtUser->close();

if ($type == 1) {
  header("Location: viewer_home.php");
  exit();
}

// Database connection details for construction_projects
$constructionProjectsDB = "construction_projects";
$constructionProjectsConn = new mysqli($servername, $dbUsername, $dbPassword, $constructionProjectsDB);

// Check the connection
if ($constructionProjectsConn->connect_error) {
  die("Connection failed: " . $constructionProjectsConn->connect_error);
}

// Fetch user's projects from the construction_projects database
$stmtProjects = $constructionProjectsConn->prepare("SELECT ProjectID, Name FROM `projects` WHERE UID = ?");
$stmtProjects->bind_param("s", $uid);
$stmtProjects->execute();
$stmtProjects->bind_result($projectID, $projectName);
$stmtProjects->store_result();

// Close the connection to the construction_projects database
$constructionProjectsConn->close();

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>User Home -
    <?php echo $userName; ?>
  </title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <style>
    /* Custom styles for the sidebar */
    .sidebar {
      color: #333;
      /* Dark grey text color */
    }

    .sidebar a {
      color: #333;
      /* Dark grey text color for links */
    }

    .sidebar a:hover {
      color: #000;
      /* Black text color on hover */
    }
  </style>


</head>

<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">CipherSphere</a>
      <!-- Navbar toggle button for mobile -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link" href="index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="logout.php">Logout</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>


  <div class="container-fluid">
    <div class="row">
      <!-- Sidebar -->
      <nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse" id="navbarNav">
        <div id="sidebar" class="position-sticky pt-3">
          <div class="sidebar-header">
            <h3>Dashboard</h3>
          </div>
          <ul class="nav flex-column">
            <li class="nav-item">
              <a class="nav-link active" href="#home" data-bs-toggle="collapse" aria-expanded="false">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#overview" data-bs-toggle="collapse" aria-expanded="false">Overview</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#workers" data-bs-toggle="collapse" aria-expanded="false">Workers</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#materials" data-bs-toggle="collapse" aria-expanded="false">Materials</a>
            </li>
            <!-- Add other sections as needed -->
          </ul>
        </div>
      </nav>
      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <div class="container-fluid">

            <div class="navbar-brand">
              <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                  <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="projects"
                      data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Choose a project
                    </button>
                    <div class="dropdown-menu" aria-labelledby="projects" id="prj-list-dd">
                      <?php
                      while ($stmtProjects->fetch()) {
                        echo '<a class="dropdown-item" href="#" id="prj' . $projectID . '">' . $projectName . '</a>';
                      }
                      ?>
                      <button type="button" class="dropdown-item btn btn-primary" id="sel-new-proj"
                        data-bs-toggle="modal" data-bs-target="#create-new-proj">Create a new Project</button>
                    </div>
                  </div>
                </li>
              </ul>
            </div>
            <div class="collapse navbar-collapse" id="navbarNav">
              <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                  <a class="nav-link" href="#">Start Time</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="logout.php">Status</a>
                </li>
              </ul>
            </div>
          </div>
        </nav>

        <!-- Modal -->
        <div class="modal fade" id="create-new-proj" tabindex="-1" aria-labelledby="create-new-proj-label"
          aria-hidden="false">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="create-new-proj-label">Create or join a project</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">


                <div class="mb-3">
                  <label for="name" class="form-label">Project Name</label>
                  <input type="text" class="form-control" id="new-prj-name" name="name" placeholder="Enter project name"
                    required>
                </div>



              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="create-prj-btn">Create /
                  Join</button>
              </div>
            </div>
          </div>
        </div>

        <div class="container-fluid" id="db-content">
          <div id="db-workers" class="container row">

            <div class="col-sm-3 mt-5">
              <div class="mb-3">
                <label for="type" class="form-label">Type</label>
                <select class="form-select" id="type" name="type">
                  <option value="0">Full-time</option>
                  <option value="1">Part-time</option>
                  <option value="2">Contract</option>
                </select>
              </div>

              <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status">
                  <option value="1">Present</option>
                  <option value="0">On Leave</option>
                </select>
              </div>

              <div class="mb-3">
                <label for="task" class="form-label">Task</label>
                <input type="text" class="form-control" id="task" name="task" placeholder="Enter task" required>
              </div>

              <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter name" required>
              </div>

              <button onclick="UpdateWorker()" class="btn btn-primary">Update</button>
            </div>
            <div class="col-sm-9 mt-5" id="worker-table">

            </div>
          </div>
          <div id="db-materials" class="container row">

            <div class="col-sm-3 mt-5">
              <div class="mb-3">
                <label for="resource" class="form-label">Resource</label>
                <input type="text" class="form-control" id="resource" name="resource" placeholder="Enter resource"
                  required>
              </div>

              <div class="mb-3">
                <label for="name" class="form-label">Supplier</label>
                <input type="text" class="form-control" id="supplier" name="supplier" placeholder="Enter supplier"
                  required>
              </div>

              <div class="mb-3">
                <label for="rcos" class="form-label">Cost</label>
                <input type="number" class="form-control" id="rcost" name="rcost" placeholder="Enter cost"
                  required>
              </div>

              <div class="mb-3">
                <label for="quantity" class="form-label">Quantity</label>
                <input type="number" class="form-control" id="quantity" name="quantity" placeholder="Enter quantity"
                  required>
              </div>


              <button onclick="UpdateMaterial()" class="btn btn-primary">Update</button>
            </div>
            <div class="col-sm-9 mt-5" id="material-table">

            </div>
          </div>
        </div>
      </main>
    </div>
  </div>


  <!-- Bootstrap JS and jQuery (Make sure to include Popper.js if using Bootstrap's JS) -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <!-- AJAX script to handle content loading -->
  <script>
    // Add event listeners to all sidebar links
    var projectId = null;
    $(document).ready(function () {
      $('#sidebar a.nav-link').on('click', function (e) {
        //  e.preventDefault();
        var section = $(this).text();
        loadContent(section);
      });

      $('[id^="prj"]').each(function () {
        var numericPart = $(this).attr('id').match(/\d+/);

        if (numericPart !== null && $(this).attr('id') === 'prj' + numericPart[0]) {
          // Add event listener only to valid IDs
          $(this).on('click', function () {
            // Event listener action
            projectId = parseInt(numericPart[0], 10);
            $('#projects').html($(this).text());
          });
        }
      });

      $('#create-prj-btn').on('click', createProject);
      loadContent(null);
    });

    function loadContent(section) {
      $('#db-content').children().hide();

      if (section === "Workers") {
        $('#db-workers').show();
        loadWorkerTable();
      } else if (section === "Materials") {
        $('#db-materials').show();
        loadMaterialTable();
      }
    }

    function UpdateMaterial() {
      // Get form data
      var formData = {
        "resource": $('#resource').val(),
        "supplier": $('#supplier').val(),
        "rcost": $('#rcost').val(),
        "quantity": $('#quantity').val(),
        "projectId": projectId,
        "RequestType": 'UpdateMaterial'
      };

      // Send data to update_dashboard.php using Ajax
      $.ajax({
        type: 'POST',
        url: 'update_dashboard.php',
        data: formData,
        success: function (response) {
          // Handle the response from the server
          console.log(response);
          loadMaterialTable();
          // Add your code here to handle the success response
        },
        error: function (error) {
          // Handle the error from the server
          console.error(error);
          // Add your code here to handle the error response
        }
      });
    }

    function UpdateWorker() {
      // Get form data
      var formData = {
        "type": $('#type').val(),
        "task": $('#task').val(),
        "name": $('#name').val(),
        "status": $('#status').val(),
        "projectId": projectId,
        "RequestType": 'UpdateWorker'
      };

      // Send data to update_dashboard.php using Ajax
      $.ajax({
        type: 'POST',
        url: 'update_dashboard.php',
        data: formData,
        success: function (response) {
          // Handle the response from the server
          
          loadWorkerTable();
          // Add your code here to handle the success response
        },
        error: function (error) {
          // Handle the error from the server
          console.error(error);
          // Add your code here to handle the error response
        }
      });
    }

    function loadWorkerTable() {
      // Send data to update_dashboard.php using Ajax
      $.ajax({
        type: 'POST',
        url: 'update_dashboard.php',
        data: {
          "projectId": projectId,
          "RequestType": 'Workers'
        },
        success: function (response) {
          // Handle the response from the server
          $('#worker-table').html(response);
          // Add your code here to handle the success response
        },
        error: function (error) {
          // Handle the error from the server
          console.error(error);
          // Add your code here to handle the error response
        }
      });
    }

    function loadMaterialTable() {
      // Send data to update_dashboard.php using Ajax
      $.ajax({
        type: 'POST',
        url: 'update_dashboard.php',
        data: {
          "projectId": projectId,
          "RequestType": 'Materials'
        },
        success: function (response) {
          // Handle the response from the server
          
          $('#material-table').html(response);
          // Add your code here to handle the success response
        },
        error: function (error) {
          // Handle the error from the server
          console.error(error);
          // Add your code here to handle the error response
        }
      });
    }

    function createProject() {

      var prjDetails = {
        Uid: <?php echo $uid; ?>,
        Project: $('#new-prj-name').val(),
        RequestType: 'ProjectSelect'
      };
      $.ajax({
        type: 'POST',
        url: 'update_dashboard.php',
        data: prjDetails,
        success: function (response) {
          console.log(response);
          // Handle the response from the server
          if (!isNaN(response)) {
            projectId = response;
            $('#projects').html($('#prj' + response).text());
          } else {
            var parts = response.split(' ');
            var prjName = parts.slice(0, -1).join(' '); // Join all parts except the last one to get the name
            var prjId = parts.slice(-1)[0];

            var newDropdownItem = '<a class="dropdown-item" href="#" id="prj' + prjId + '">' + prjName + '</a>';
            // Find the last element inside an element with a specific ID
            var lastElement = $('#prj-list-dd').children().last();
            // Add the new dropdown item before the last element
            lastElement.before(newDropdownItem);

            var pid = '#prj' + prjId;
            $(pid).on('click', function () {
              // Event listener action
              projectId = prjId;
              $('#projects').html($(pid).text());
            });
          }
          // Add your code here to handle the success response
        },
        error: function (error) {
          // Handle the error from the server
          console.error(error);
          // Add your code here to handle the error response
        }
      });
    }

  </script>

</body>

</html>