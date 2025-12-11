<?php
// submit_payment.php - handler for AJAX payment form, inserts into dental_payments
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo '<div class="card"><div class="card-body"><h5>Invalid request</h5></div></div>';
    exit;
}

require_once __DIR__ . '/db.php';

$patient_id_raw = isset($_POST['patient_id']) ? trim($_POST['patient_id']) : '';
$new_patient_name  = isset($_POST['new_patient_name']) ? trim($_POST['new_patient_name']) : '';
$new_patient_email = isset($_POST['new_patient_email']) ? trim($_POST['new_patient_email']) : '';

$service       = isset($_POST['service']) ? trim($_POST['service']) : '';
$total_due     = isset($_POST['total_due']) ? floatval($_POST['total_due']) : 0.0;
$amount_given  = isset($_POST['amount_given']) ? floatval($_POST['amount_given']) : 0.0;
$payment_type  = isset($_POST['payment_type']) ? trim($_POST['payment_type']) : '';
$tx_date       = isset($_POST['tx_date']) ? trim($_POST['tx_date']) : '';
$tx_time       = isset($_POST['tx_time']) ? trim($_POST['tx_time']) : '';
$note          = isset($_POST['note']) ? trim($_POST['note']) : '';

$errors = [];

// patient handling: either existing id or 'new' + new_patient_name + new_patient_email
$patient_id = null;
if ($patient_id_raw === '' ) {
    $errors[] = 'Please select or add a patient.';
} elseif ($patient_id_raw === 'new') {
    if ($new_patient_name === '') $errors[] = 'New patient name is required.';
    if ($new_patient_email === '') $errors[] = 'New patient email is required.';
} else {
    // numeric id
    $patient_id = (int)$patient_id_raw;
    if ($patient_id <= 0) $errors[] = 'Invalid patient selected.';
}

// other validations
if ($total_due <= 0) $errors[] = 'Total due must be greater than 0.';
if ($amount_given < 0) $errors[] = 'Amount given cannot be negative.';
if ($amount_given < $total_due) $errors[] = 'Amount given is less than total due.';
if ($tx_date === '') $errors[] = 'Date is required.';
if ($tx_time === '') $errors[] = 'Time is required.';

if (!empty($errors)) {
    echo '<div class="card"><div class="card-body">';
    echo '<h5>Validation errors</h5><ul>';
    foreach ($errors as $err) {
        echo '<li>' . htmlspecialchars($err) . '</li>';
    }
    echo '</ul></div></div>';
    exit;
}

// if new patient, insert into patients table (email unique constraint might cause error)
if ($patient_id_raw === 'new') {
    $stmt = $conn->prepare("INSERT INTO patients (name, email, password, created_at) VALUES (?, ?, ?, NOW())");
    // create a random password hash placeholder (user can reset later) - using password_hash with random string
    $randomPass = bin2hex(random_bytes(8));
    $passHash = password_hash($randomPass, PASSWORD_DEFAULT);
    if (!$stmt) {
        echo '<div class="card"><div class="card-body"><h5>Database error (prepare patient)</h5><p>' . htmlspecialchars($conn->error) . '</p></div></div>';
        exit;
    }
    $stmt->bind_param('sss', $new_patient_name, $new_patient_email, $passHash);
    if (!$stmt->execute()) {
        // likely email duplicate; return friendly error
        echo '<div class="card"><div class="card-body"><h5>Could not create patient</h5><p>' . htmlspecialchars($stmt->error) . '</p></div></div>';
        $stmt->close();
        exit;
    }
    $patient_id = $stmt->insert_id;
    $stmt->close();
}

// compute change
$change = $amount_given - $total_due;
if ($change < 0) $change = 0.0;

// auto-generate reference
$reference = 'PAY-' . date('YmdHis') . '-' . substr(uniqid(), -5);

// combine date/time
$tx_datetime = $tx_date . ' ' . $tx_time . ':00';

// insert into dental_payments
$insert_sql = "INSERT INTO dental_payments
    (patient_id, service, total_due, amount_given, change_amount, payment_type, tx_datetime, reference, note, created_at)
  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";

$stmt = $conn->prepare($insert_sql);
if (!$stmt) {
    echo '<div class="card"><div class="card-body"><h5>Database error (prepare payment)</h5><p>' . htmlspecialchars($conn->error) . '</p></div></div>';
    exit;
}

$stmt->bind_param('issddssss', $patient_id, $service, $total_due, $amount_given, $change, $payment_type, $tx_datetime, $reference, $note);

if (!$stmt->execute()) {
    echo '<div class="card"><div class="card-body"><h5>Could not save transaction</h5><p>' . htmlspecialchars($stmt->error) . '</p></div></div>';
    $stmt->close();
    exit;
}

$payment_id = $stmt->insert_id;
$stmt->close();

// fetch patient name to display
$patient_name = '';
$pstmt = $conn->prepare("SELECT name FROM patients WHERE id = ? LIMIT 1");
if ($pstmt) {
    $pstmt->bind_param('i', $patient_id);
    $pstmt->execute();
    $pstmt->bind_result($patient_name_res);
    if ($pstmt->fetch()) $patient_name = $patient_name_res;
    $pstmt->close();
}

// Success fragment
?>
<div class="card">
  <div class="card-body">
    <h5 class="card-title">Transaction Saved</h5>

    <div class="table-responsive">
      <table class="table">
        <tr><th>Patient</th><td><?php echo htmlspecialchars($patient_name ?: $new_patient_name); ?></td></tr>
        <tr><th>Service</th><td><?php echo htmlspecialchars($service); ?></td></tr>
        <tr><th>Total Due</th><td><?php echo number_format($total_due,2); ?></td></tr>
        <tr><th>Amount Given</th><td><?php echo number_format($amount_given,2); ?></td></tr>
        <tr><th>Change</th><td><?php echo number_format($change,2); ?></td></tr>
        <tr><th>Payment Type</th><td><?php echo htmlspecialchars($payment_type); ?></td></tr>
        <tr><th>Date / Time</th><td><?php echo htmlspecialchars($tx_datetime); ?></td></tr>
        <tr><th>Reference</th><td><?php echo htmlspecialchars($reference); ?></td></tr>
        <tr><th>Note</th><td><?php echo nl2br(htmlspecialchars($note)); ?></td></tr>
      </table>
    </div>

    <div class="mt-3">
      <a href="index.php?page=payments" class="btn btn-primary" id="new-transaction-btn">New Transaction</a>
      <a href="index.php" class="btn btn-secondary">Back to Dashboard</a>
    </div>
  </div>
</div>

<script>
// If loaded into #module-content via AJAX, re-open payments form when clicking New Transaction.
(function(){
  var btn = document.getElementById('new-transaction-btn');
  if (btn) {
    btn.addEventListener('click', function(e){
      e.preventDefault();
      history.pushState({page:'payments'}, '', '?page=payments');
      fetch('ajax.php?page=payments', { credentials: 'same-origin' })
        .then(r => r.text())
        .then(html => {
          var container = document.getElementById('module-content');
          if (container) container.innerHTML = html;
          if (window.initAfterAjax) window.initAfterAjax();
        });
    });
  }
})();
</script>