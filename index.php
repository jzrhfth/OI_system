<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Assuming this file exists as per your example
include('./admin/includes/dbconnection.php');

if (isset($_POST['submit_request'])) {
    $form_date = $_POST['form_date'] ?? null;
    $department_name = $_POST['department'] ?? null;
    $mrs_no = $_POST['mrs_no'];
    $req_name = $_POST['req_name'] ?? null;

    if (!empty($form_date) && !empty($department_name) && !empty($mrs_no) && !empty($req_name)) {
        try {
            $dbh->beginTransaction();

            // 1. Get department_id from department name
            $sql_dept = "SELECT id FROM departments WHERE name = :name LIMIT 1";
            $query_dept = $dbh->prepare($sql_dept);
            $query_dept->execute([':name' => $department_name]);
            $department_id = $query_dept->fetchColumn();

            if (!$department_id) {
                throw new PDOException("Department '$department_name' not found in the database.");
            }

            // 2. Get requested_by_user_id from user's full name
            $sql_user = "SELECT id FROM users WHERE full_name = :name LIMIT 1";
            $query_user = $dbh->prepare($sql_user);
            $query_user->execute([':name' => $req_name]);
            $user_id = $query_user->fetchColumn();

            if (!$user_id) {
                // A more robust system might create the user. Here, we require the user to exist.
                throw new PDOException("User '$req_name' not found. Please ensure the requester's full name is correct and exists in the system.");
            }

            // 3. Insert Main Request into `requests` table
            $sql = "INSERT INTO requests (mrs_no, request_date, department_id, requested_by_user_id) 
                    VALUES (:mrs, :rdate, :dept_id, :user_id)";
            $query = $dbh->prepare($sql);
            $query->execute([
                ':mrs' => $mrs_no,
                ':rdate' => $form_date,
                ':dept_id' => $department_id,
                ':user_id' => $user_id
            ]);
            $request_id = $dbh->lastInsertId();

            // 4. Insert Items into `request_items`
            if (isset($_POST['description']) && is_array($_POST['description'])) {
                $descriptions = $_POST['description'];
                $quantities = $_POST['quantity'];
                // Note: 'unit' and 'purpose' from the form are ignored as they are not in the `request_items` schema.

                $sql_find_item = "SELECT id FROM items WHERE name = :name LIMIT 1";
                $query_find_item = $dbh->prepare($sql_find_item);

                $sql_insert_item = "INSERT INTO items (name) VALUES (:name)";
                $query_insert_item = $dbh->prepare($sql_insert_item);

                $sql_req_item = "INSERT INTO request_items (request_id, item_id, quantity) VALUES (:rid, :item_id, :qty)";
                $query_req_item = $dbh->prepare($sql_req_item);

                for ($i = 0; $i < count($descriptions); $i++) {
                    // Only process rows where a description is provided
                    if (!empty($descriptions[$i])) {
                        // Find item_id by description
                        $query_find_item->execute([':name' => $descriptions[$i]]);
                        $item_id = $query_find_item->fetchColumn();

                        // If item doesn't exist in the main `items` table, create it
                        if (!$item_id) {
                            $query_insert_item->execute([':name' => $descriptions[$i]]);
                            $item_id = $dbh->lastInsertId();
                        }

                        // Insert into request_items
                        $query_req_item->execute([
                            ':rid' => $request_id,
                            ':item_id' => $item_id,
                            ':qty' => !empty($quantities[$i]) ? $quantities[$i] : 1 // Default quantity to 1
                        ]);
                    }
                }
            }

            $dbh->commit();
            echo "<script>alert('Request submitted successfully.'); window.location.href='index.php';</script>";
        } catch (PDOException $e) {
            $dbh->rollBack();
            echo "<script>alert('Error submitting request: " . addslashes($e->getMessage()) . "');</script>";
        }
    } else {
        echo "<script>alert('Please fill in all required fields: Date, Department, and Requester Name.');</script>";
    }
}

// Fetch departments for the dropdown to ensure it's in sync with the database.
// Note: You must have data in your `departments` table for this to work.
$departments_list = [];
try {
    $departments_list = $dbh->query("SELECT name FROM departments ORDER BY name ASC")->fetchAll(PDO::FETCH_COLUMN);
} catch (PDOException $e) {
    // Silently fail if the table doesn't exist yet, the form will be empty.
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Office Supplies Request Form - HOKU</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
    <style>
        .btn-submit {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        .btn-submit:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div id="root"></div>
    <div class="container">
        <div class="header">
            <div class="header-content">
                <div class="header-left">
                    <h1>Office Supplies Request Form</h1>
                    <p>L. Jayme Street, Mandaue City, Cebu</p>
                </div>
                <div class="logo-section">
                     <img src="images/logo 1.png" alt="HOKU Logo" style="height: 100px; margin-right: -20px;">
                    <div class="logo-tagline">
                        <h1>HOKU</h1>
                        PROPERTY<br>
                        MANAGEMENT<br>
                        SERVICES
                    </div>
                </div>
            </div>
        </div>

        <form class="form-body" method="post" action="index.php">
            <div class="info-grid">
                <div class="form-group">
                    <label>Date</label>
                    <input type="date" id="formDate" name="form_date" required>
                </div>
                <div class="form-group">
                    <label>Department</label>
                    <select id="department" name="department" required>
                        <option value="">Select Department</option>
                        <?php foreach ($departments_list as $dept_name): ?>
                            <option value="<?php echo htmlspecialchars($dept_name); ?>">
                                <?php echo htmlspecialchars($dept_name); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>MRS Number</label>
                    <input type="text" id="mrsNo" name="mrs_no" value="MRS-2026-000" readonly>
                </div>  
            </div>
            
            <div class="button-group">
                <button type="button" class="btn-add" onclick="addRow()"><span>+ Add Row</span></button>
                <button type="button" class="btn-clear" onclick="clearForm()"><span>↻ Clear Form</span></button>
                <button type="button" class="btn-print" onclick="window.print()"><span>🖨 Print Form</span></button>
                <button type="submit" name="submit_request" class="btn-submit"><span>✓ Submit Request</span></button>
            </div>

            <h2 class="section-title">Item Details</h2>
                
            <div class="table-container">
                <table id="itemsTable">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Items Description</th>
                            <th style="width: 120px;">Quantity</th>
                            <th style="width: 120px;">Unit</th>
                            <th>Purpose</th>
                            <th style="width: 60px;">Action</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                    </tbody>
                </table>
            </div>

            <div class="form-group" style="max-width: 400px; margin-top: 30px;">
                <label for="reqName">Requested By (Full Name)</label>
                <input type="text" id="reqName" name="req_name" required placeholder="Enter full name registered in system">
                <small style="color: #666;">This must match a user in the database.</small>
            </div>
        </form>

        <div class="footer">
            <p>© 2026 HOKU Innovative Professional Services. All rights reserved.</p>
        </div>
    </div>

</body>
<script src="js/script.js"></script>
</html>