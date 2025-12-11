<?php
require_once __DIR__ . '/../db.php';

// Query payments
$result = $conn->query("SELECT * FROM patients ORDER BY created_at DESC");
?>

<div class="container mt-4">
  <h4>Patients</h4>

  <div class="table-responsive">
    <table id="patientsTable" class="table table-striped">
      <thead>
        <tr>
          <th>ID</th>
          <th>Patient</th>
          <th>Email</th>
          <th>Address</th>
          <th>City</th>
          <th>State</th>
          <th>Zip</th>
          <th>Created At</th>
        </tr>
      </thead>
      <tbody>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= htmlspecialchars($row['id']) ?></td>
          <td><?= htmlspecialchars($row['name']) ?></td>
          <td><?= htmlspecialchars($row['email']) ?></td>
          <td><?= htmlspecialchars($row['address']) ?></td>
          <td><?= htmlspecialchars($row['city']) ?></td>
          <td><?= htmlspecialchars($row['state']) ?></td>
          <td><?= htmlspecialchars($row['zip']) ?></td>
          <td><?= htmlspecialchars($row['created_at']) ?></td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>

<?php $conn->close(); ?>