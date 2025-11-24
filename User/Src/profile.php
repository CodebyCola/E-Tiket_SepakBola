    <?php
    include __DIR__ . "/../Connection/koneksi.php";
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header("Location: Auth/login.php");
        exit();
    } else {
        $stmt = $koneksi->prepare("SELECT * FROM users where id_user = ?");
        $stmt->bind_param("i", $_SESSION['user_id']);
        $stmt->execute();
        $result = $stmt->get_result();

        $data = $result->fetch_assoc();
    }

    $errors = [
        'fullname' => "",
        'email' => "",
        'telp' => "",
        'date' => ""
    ];
    $fullname = $data['nama_lengkap'];
    $email = $data['email'];
    $telp = $data['telp'];
    $date = $data['tanggal_lahir'];

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $fullname = trim(filter_input(INPUT_POST, 'fullname', FILTER_SANITIZE_STRING));
        $email    = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
        $telp     = trim(filter_input(INPUT_POST, 'telp', FILTER_SANITIZE_STRING));
        $date     = trim($_POST['date']);

        if (empty($fullname)) {
            $errors['fullname'] = "Please fill in your full name";
        } elseif (strlen($fullname) < 3) {
            $errors['fullname'] = "Name is too short";
        }

        if (empty($email)) {
            $errors['email'] = "Please fill in your email";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Invalid email format";
        }

        if (empty($telp)) {
            $errors['telp'] = "Please fill in your phone number";
        } elseif (!preg_match('/^\+?[0-9]{7,15}$/', $telp)) {
            $errors['telp'] = "Invalid phone number";
        }

        if (empty($date)) {
            $errors['date'] = "Please fill in your date of birth";
        } elseif (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            $errors['date'] = "Invalid date format";
        }

        if (!array_filter($errors)) {
            $updateStmt = $koneksi->prepare("UPDATE users SET nama_lengkap = ?, email = ?, telp = ?, tanggal_lahir = ? WHERE id_user = ?");
            $updateStmt->bind_param("ssssi", $fullname, $email, $telp, $date, $_SESSION['user_id']);
            $updateStmt->execute();
            header("location: profile.php");
            exit();
        }
    }



    ?>


    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Profile - Premier League</title>
        <link rel="stylesheet" href="../Assets/Style/profile.css">
        <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    </head>

    <body>
        <a href="index.php" class="btn btn-dark mt-3">Back</a>

        <section id="profile-content">
            <div class="container">
                <div class="row">
                    <!-- Profile Details & Forms -->
                    <div class="col-lg-8 col-md-12">
                        <!-- Personal Information -->
                        <div class="detail-card mb-4">
                            <div class="card-header-custom">
                                <h3>Personal Information</h3>
                                <button class="btn-edit btn btn-secondary" id="editPersonalBtn">Edit</button>
                            </div>
                            <form id="personalInfoForm" class="profile-form" action="" method="POST">
                                <div class="row">
                                    <div class="mb-3">
                                        <label for="fullname" class="form-label">Full Name</label>
                                        <input type="text" class="form-control" id="fullname" name="fullname" value="<?= $data['nama_lengkap'] ?>" disabled>
                                        <span class="
                                        errors"><?= $errors['fullname'] ?></span>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" class="form-control" id="email" name="email" value="<?= $data['email'] ?>" disabled>
                                    <span class="
                                    errors"><?= $errors['email'] ?></span>
                                </div>
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <input type="tel" class="form-control" id="phone" name="telp" value="<?= $data['telp'] ?>" disabled>
                                    <span class="
                                    errors"><?= $errors['telp'] ?></span>
                                </div>
                                <div class="mb-3">
                                    <label for="birthdate" class="form-label">Date of Birth</label>
                                    <input type="date" class="form-control" id="birthdate" name="date" value="<?= !empty($data['tanggal_lahir']) ? date('Y-m-d', strtotime($data['tanggal_lahir'])) : '' ?>" disabled>
                                    <span class="
                                    errors"><?= $errors['date'] ?></span>
                                </div>
                                <div class="form-actions" style="display: none;">
                                    <button type="button" class="btn btn-secondary me-3" id="cancelPersonalBtn">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <script src="../Assets/Script/profileSC.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>

    </html>