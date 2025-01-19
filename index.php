<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Crew Management</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link rel="icon" href="assets/images/logo.png">
  <link rel="stylesheet" href="css/index.css">

  <style>
    body {
      background: url('assets/background/background.jpg') no-repeat center center fixed;
      background-size: cover;
    }
  </style>
</head>

<body>
  <div class="nav-container">
    <nav class="navbar navbar-expand-lg navbar-dark">
      <a class="navbar-brand" href="#">
        <img src="assets/images/logo.png" alt="Logo">
      </a>
      <div class="ml-auto">
        <button class="btn btn-outline-light mr-2" data-toggle="modal" data-target="#loginModal">Login</button>
        <button class="btn btn-outline-light" data-toggle="modal" data-target="#registerModal">Register</button>
      </div>
    </nav>
  </div>

  <div class="container text-center text-white" style="margin-top: 15%;">
    <h1>Welcome to the Crew Management</h1>
    <p>Manage your crew with ease and efficiency.</p>
  </div>

  <!-- Login Modal -->
  <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="loginModalLabel">Login</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="login.php" method="POST">
            <div class="form-group">
              <label for="loginEmail">Email address</label>
              <input type="email" class="form-control" id="loginEmail" name="email" placeholder="Enter email" required>
            </div>
            <div class="form-group">
              <label for="loginPassword">Password</label>
              <input type="password" class="form-control" id="loginPassword" name="password" placeholder="Password"
                required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Login</button>
          </form>
          <div class="text-center mt-3">
            <a href="#" data-toggle="modal" data-target="#forgotPasswordModal">Forgot Password?</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Register Modal -->
  <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="registerModalLabel">Register</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="register.php" method="POST" enctype="multipart/form-data">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="registerName">Full Name</label>
                  <input type="text" class="form-control" id="registerName" name="name" placeholder="Enter full name"
                    required>
                </div>
                <div class="form-group">
                  <label for="registerPhone">Phone Number</label>
                  <input type="text" class="form-control" id="registerPhone" name="phone_number"
                    placeholder="Enter phone number" required>
                </div>
                <div class="form-group">
                  <label for="registerAddress">Address</label>
                  <input type="text" class="form-control" id="registerAddress" name="address"
                    placeholder="Enter address" required>
                </div>
                <div class="form-group">
                  <label for="registerGender">Gender</label>
                  <select class="form-control" id="registerGender" name="gender" required>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="registerEmail">Email address</label>
                  <input type="email" class="form-control" id="registerEmail" name="email" placeholder="Enter email"
                    required>
                </div>
                <div class="form-group">
                  <label for="registerPassword">Password</label>
                  <input type="password" class="form-control" id="registerPassword" name="password"
                    placeholder="Password" required>
                </div>
                <div class="form-group">
                  <label for="registerDob">Date of Birth</label>
                  <input type="date" class="form-control" id="registerDob" name="date_of_birth" required>
                </div>
                <div class="form-group">
                  <label for="profilePicture">Profile Picture</label>
                  <input style="background-color: rgb(0,0,0,0) !important;" type="file" class="form-control"
                    id="profilePicture" name="profile_picture" accept="image/*" required>
                </div>
              </div>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Register</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Forgot Password Modal -->
  <div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-labelledby="forgotPasswordModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="forgotPasswordModalLabel">Forgot Password</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form>
            <div class="form-group">
              <label for="forgotEmail">Email address</label>
              <input type="email" class="form-control" id="forgotEmail" placeholder="Enter your email">
            </div>
            <button type="submit" class="btn btn-primary btn-block">Reset Password</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>