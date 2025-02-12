<x-customer-guest-layout id="login-bg" class="login-bg"
    >
    <div class="form-container my-4">
        <div class="panel">
          
            <div class="panel-header mb-4">
                <h3 class="fs-30 text-black">{{ localize('Sign Up') }}</h3>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (session()->has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (session()->has('warning'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('warning') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <p class="text-black fs-16 fw-normal mb-0">
                    {{ localize('Access using your email and password.') }}
                </p>
            </div>

<form action="{{ route('customer.register.submit') }}" method="POST" novalidate>
    @csrf
   <div class="row">
      <div class="col-md-6 mb-3">
         <label for="first-name" class="form-label">First Name *</label>
         <input type="text" class="form-control" id="first-name" name="first-name" placeholder="First Name" required>
         <div class="invalid-feedback">Please enter your first name.</div>
      </div>
      <div class="col-md-6 mb-3">
         <label for="last-name" class="form-label">Last Name *</label>
         <input type="text" class="form-control" id="last-name" name="last-name" placeholder="Last Name" required>
         <div class="invalid-feedback">Please enter your last name.</div>
      </div>
   </div>
   <div class="mb-3">
      <label for="username" class="form-label">User Name *</label>
      <input type="text" class="form-control" id="username" name="username" placeholder="User Name" required>
      <div class="invalid-feedback">Please enter a username.</div>
   </div>
   <div class="row">
      <div class="col-md-6 mb-3">
         <label for="country" class="form-label">Select Country *</label>
         <select class="form-select" id="country" name="country" required>
            <option selected disabled>Select Country</option>
            <!-- Options dynamically generated -->
         </select>
         <div class="invalid-feedback">Please select a country.</div>
      </div>
      <div class="col-md-6 mb-3">
         <label for="phone" class="form-label">Phone *</label>
         <input type="number" class="form-control" id="phone" name="phone" placeholder="Phone" required>
         <div class="invalid-feedback">Please enter a valid phone number.</div>
      </div>
   </div>
   <div class="mb-3">
      <label for="email" class="form-label">Email *</label>
      <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
      <div class="invalid-feedback">Please enter a valid email address.</div>
   </div>
   <div class="row">
      <div class="col-md-6 mb-3">
         <label for="password" class="form-label">Password *</label>
         <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
         <div class="invalid-feedback">Password must meet requirements.</div>
      </div>
      <div class="col-md-6 mb-3">
         <label for="password-confirmation" class="form-label">Confirm Password *</label>
         <input type="password" class="form-control" id="password-confirmation" name="password_confirmation" placeholder="Confirm Password" required>
         <div class="invalid-feedback">Passwords must match.</div>
      </div>
   </div>

   <p style="color:black">Already have an account? <a href="{{url('customer/login')}}">Login</a> </p>
   <div class="d-flex justify-content-center mt-4">
      <button class="btn btn-primary" type="submit">Register</button>
   </div>
</form>
</div>
    </div>

    @push('css')
        <link rel="stylesheet" href="{{ assets('css/login.min.css') }}">
    @endpush
    @push('js')
        <script src="{{ assets('js/login.min.js') }}"></script>
    @endpush

</x-customer-guest-layout>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        fetch("https://restcountries.com/v3.1/all")
            .then(response => response.json())
            .then(data => {
                let select = document.getElementById("country");

                // Sort countries alphabetically
                let sortedCountries = data.sort((a, b) => 
                    a.name.common.localeCompare(b.name.common)
                );

                sortedCountries.forEach(country => {
                    let option = document.createElement("option");
                    option.value = country.cca2; // Use country code as value
                    option.textContent = country.name.common; // Country name as text
                    select.appendChild(option);
                });
            })
            .catch(error => console.error("Error fetching countries:", error));
    });
</script>

<script>
   (function () {
      'use strict';
      var forms = document.querySelectorAll('.needs-validation');
      Array.prototype.slice.call(forms).forEach(function (form) {
         form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
               event.preventDefault();
               event.stopPropagation();
            }
            form.classList.add('was-validated');
         }, false);
      });
   })();
</script>
