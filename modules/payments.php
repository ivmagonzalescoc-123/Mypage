<?php
require_once __DIR__ . '/../db.php';

// fetch patients
$patients = [];
$res = $conn->query("SELECT id, name FROM patients ORDER BY name");
if ($res) {
    while ($row = $res->fetch_assoc()) {
        $patients[] = $row;
    }
}
?>
<div class="card">
  <div class="card-body">
    <h5 class="card-title">Payments / New Transaction</h5>

    <form id="payment-form" class="row g-3 ajax-submit" method="POST" action="submit_payment.php">
      <div class="col-md-6">
        <label for="patient_id" class="form-label">Select Patient</label>
        <select id="patient_id" name="patient_id" class="form-select" required>
          <option value="">-- Select patient --</option>
          <?php foreach ($patients as $p): ?>
            <option value="<?php echo (int)$p['id']; ?>"><?php echo htmlspecialchars($p['name']); ?></option>
          <?php endforeach; ?>
          <option value="new">+ Add New Patient</option>
        </select>
      </div>

      <div class="col-md-6 new-patient-fields" style="display:none;">
        <label for="new_patient_name" class="form-label">New Patient Name</label>
        <input type="text" id="new_patient_name" name="new_patient_name" class="form-control" placeholder="Full name">
        <label for="new_patient_email" class="form-label mt-2">New Patient Email</label>
        <input type="email" id="new_patient_email" name="new_patient_email" class="form-control" placeholder="email@example.com">
        <div class="form-text">Email is required when creating a new patient.</div>
      </div>

      <div class="col-md-6">
        <label for="service" class="form-label">Service</label>
        <select id="service" name="service" class="form-select">
          <option value="Consultation">Consultation</option>
          <option value="Cleaning">Cleaning</option>
          <option value="Filling">Filling</option>
          <option value="Extraction">Extraction</option>
          <option value="Other">Other</option>
        </select>
      </div>

      <div class="col-md-3">
        <label for="total_due" class="form-label">Total Due</label>
        <input type="number" step="0.01" min="0" class="form-control" id="total_due" name="total_due" value="0.00" required>
      </div>

      <div class="col-md-3">
        <label for="amount_given" class="form-label">Amount Given</label>
        <input type="number" step="0.01" min="0" class="form-control" id="amount_given" name="amount_given" value="0.00" required>
      </div>

      <div class="col-md-4">
        <label for="change" class="form-label">Change</label>
        <input type="number" step="0.01" min="0" class="form-control" id="change" name="change" value="0.00" readonly>
      </div>

      <div class="col-md-4">
        <label for="payment_type" class="form-label">Payment Type</label>
        <select id="payment_type" name="payment_type" class="form-select">
          <option value="Cash">Cash</option>
          <option value="Card">Card</option>
          <option value="Mobile">Mobile</option>
          <option value="Other">Other</option>
        </select>
      </div>

      <div class="col-md-4">
        <label for="tx_date" class="form-label">Date</label>
        <input type="date" id="tx_date" name="tx_date" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
      </div>

      <div class="col-md-3">
        <label for="tx_time" class="form-label">Time</label>
        <input type="time" id="tx_time" name="tx_time" class="form-control" value="<?php echo date('H:i'); ?>" required>
      </div>

      <!-- reference is auto-generated on server; no input -->

      <div class="col-12">
        <label for="note" class="form-label">Note</label>
        <textarea id="note" name="note" class="form-control" rows="3" placeholder="Optional"></textarea>
      </div>

      <div class="text-end mt-2 col-12">
        <button type="submit" class="btn btn-primary">Save Transaction</button>
        <button type="reset" class="btn btn-secondary">Reset</button>
      </div>
    </form>

  </div>
</div>

<script>
// small inline helper to toggle new patient fields when loaded directly (AJAX loader will call initAfterAjax)
(function(){
  const patientSelect = document.getElementById('patient_id');
  const newFields = document.querySelector('.new-patient-fields');
  function toggleNewPatient() {
    if (!patientSelect) return;
    if (patientSelect.value === 'new') {
      newFields.style.display = 'block';
      document.getElementById('new_patient_name').required = true;
      document.getElementById('new_patient_email').required = true;
    } else {
      newFields.style.display = 'none';
      document.getElementById('new_patient_name').required = false;
      document.getElementById('new_patient_email').required = false;
    }
  }
  if (patientSelect) {
    patientSelect.addEventListener('change', toggleNewPatient);
    // init visibility
    toggleNewPatient();
  }
})();
</script>