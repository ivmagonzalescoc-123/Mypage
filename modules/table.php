<?php
require_once __DIR__ . '/../db.php';

// Query payments
$result = $conn->query("SELECT * FROM dental_payments ORDER BY tx_datetime DESC");
?>

<div class="container mt-4">
  <h4>Payment Transactions</h4>

  <div class="table-responsive">
    <table id="paymentsTable" class="table table-striped">
      <thead>
        <tr>
          <th>ID</th>
          <th>Patient</th>
          <th>Service</th>
          <th>Total Due</th>
          <th>Amount Given</th>
          <th>Change</th>
          <th>Payment Type</th>
          <th>Date Time</th>
          <th>Note</th>
          <th>Reference</th>
        </tr>
      </thead>
      <tbody>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= htmlspecialchars($row['id']) ?></td>
          <td><?= htmlspecialchars($row['patient_id']) ?></td>
          <td><?= htmlspecialchars($row['service']) ?></td>
          <td><?= htmlspecialchars($row['total_due']) ?></td>
          <td><?= htmlspecialchars($row['amount_given']) ?></td>
          <td><?= htmlspecialchars($row['change_amount']) ?></td>
          <td><?= htmlspecialchars($row['payment_type']) ?></td>
          <td><?= htmlspecialchars($row['tx_datetime']) ?></td>
          <td><?= htmlspecialchars($row['note']) ?></td>
          <td><?= htmlspecialchars($row['reference']) ?></td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>

<?php $conn->close(); ?>