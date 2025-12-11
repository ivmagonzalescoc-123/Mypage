          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Floating labels Form</h5>

              <!-- Floating Labels Form -->
              <form class="row g-3" method="POST" action="submit.php">
  <div class="col-md-12">
    <div class="form-floating">
      <input type="text" class="form-control" id="floatingName" name="floatingName" placeholder="Your Name" required>
      <label for="floatingName">Your Name</label>
    </div>
  </div>

  <div class="col-md-6">
    <div class="form-floating">
      <input type="email" class="form-control" id="floatingEmail" name="floatingEmail" placeholder="Your Email" required>
      <label for="floatingEmail">Your Email</label>
    </div>
  </div>

  <div class="col-md-6">
    <div class="form-floating">
      <input type="password" class="form-control" id="floatingPassword" name="floatingPassword" placeholder="Password" required>
      <label for="floatingPassword">Password</label>
    </div>
  </div>

  <div class="col-12">
    <div class="form-floating">
      <textarea class="form-control" id="floatingTextarea" name="floatingTextarea" placeholder="Address" style="height: 100px;"></textarea>
      <label for="floatingTextarea">Address</label>
    </div>
  </div>

  <div class="col-md-6">
    <div class="form-floating">
      <input type="text" class="form-control" id="floatingCity" name="floatingCity" placeholder="City">
      <label for="floatingCity">City</label>
    </div>
  </div>

  <div class="col-md-4">
    <div class="form-floating mb-3">
      <select class="form-select" id="floatingSelect" name="floatingSelect" aria-label="State">
        <option selected>Philippines</option>
        <option value="Thailand">Thailand</option>
        <option value="South Korea">South Korea</option>
      </select>
      <label for="floatingSelect">State</label>
    </div>
  </div>

  <div class="col-md-2">
    <div class="form-floating">
      <input type="text" class="form-control" id="floatingZip" name="floatingZip" placeholder="Zip">
      <label for="floatingZip">Zip</label>
    </div>
  </div>

  <div class="text-center">
    <button type="submit" class="btn btn-primary">Submit</button>
    <button type="reset" class="btn btn-secondary">Reset</button>
  </div>
</form>

            </div>
          </div>