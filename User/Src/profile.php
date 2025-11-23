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
    <a href="index.php" class="btn btn-dark mt-3">Kembali</a>
    <div class="d-flex">
        <?php
        if (isset($_SESSION['role'])) {
        ?>
            <h1 class="Username"><?= $_SESSION['username'] ?></h1>
        <?php
        } else {
        ?>
        <?php
        }
        ?>
    </div>
    </nav>

    <!-- Profile Section -->
    <section id="profile-hero">
        <div class="profile-banner">
            <div class="banner-overlay"></div>
        </div>
    </section>

    <section id="profile-content">
        <div class="container">
            <div class="row">
                <!-- Profile Card -->
                <div class="col-lg-4 col-md-12 mb-4">
                    <div class="profile-card">
                        <div class="profile-image-wrapper">
                            <img src="https://images.unsplash.com/photo-1511367461989-f85a21fda167?w=400&h=400&fit=crop" alt="Profile Picture" class="profile-image">
                        </div>
                    </div>
                </div>

                <!-- Profile Details & Forms -->
                <div class="col-lg-8 col-md-12">
                    <!-- Personal Information -->
                    <div class="detail-card mb-4">
                        <div class="card-header-custom">
                            <h3>Personal Information</h3>
                            <button class="btn-edit btn btn-secondary" id="editPersonalBtn">Edit</button>
                        </div>
                        <form id="personalInfoForm" class="profile-form">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="firstName" class="form-label">First Name</label>
                                    <input type="text" class="form-control" id="firstName" value="John" disabled>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="lastName" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" id="lastName" value="Doe" disabled>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="email" value="johndoe@email.com" disabled>
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="tel" class="form-control" id="phone" value="+62 812 3456 7890" disabled>
                            </div>
                            <div class="mb-3">
                                <label for="birthdate" class="form-label">Date of Birth</label>
                                <input type="date" class="form-control" id="birthdate" value="1990-01-15" disabled>
                            </div>
                            <div class="form-actions" style="display: none;">
                                <button type="button" class="btn btn-secondary" id="cancelPersonalBtn">Cancel</button>
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </div>
                        </form>
                        <a href="logout.php" class="btn btn-danger">Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        // Edit Personal Information
        const editBtn = document.getElementById('editPersonalBtn');
        const cancelBtn = document.getElementById('cancelPersonalBtn');
        const formInputs = document.querySelectorAll('#personalInfoForm input');
        const formActions = document.querySelector('.form-actions');

        editBtn.addEventListener('click', () => {
            formInputs.forEach(input => input.disabled = false);
            formActions.style.display = 'flex';
            editBtn.style.display = 'none';
        });

        cancelBtn.addEventListener('click', () => {
            formInputs.forEach(input => input.disabled = true);
            formActions.style.display = 'none';
            editBtn.style.display = 'block';
        });

        // Form submission
        document.getElementById('personalInfoForm').addEventListener('submit', (e) => {
            e.preventDefault();
            formInputs.forEach(input => input.disabled = true);
            formActions.style.display = 'none';
            editBtn.style.display = 'block';
            alert('Profile updated successfully!');
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>