<div id="tab-personal-details" role="tabpanel" class="content" aria-labelledby="stepper1trigger1">
    <div class="row">
        <div class="col-12 col-lg-6">
            <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                for="first_name">{{ localize('First Name') }} <span class="text-danger">*</span>
            </label>
            <input type="text" name="first_name" id="first_name"
                class="custom-form-control form-control @error('first_name') is-invalid @enderror"
                placeholder="{{ localize('enter first name') }}" required />
            <div class="invalid-feedback" role="alert">
                @error('first_name')
                    {{ $message }}
                @enderror
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                for="last_name">{{ localize('Last Name') }} <span class="text-danger">*</span>
            </label>
            <input type="text" name="last_name" id="last_name"
                class="custom-form-control form-control @error('last_name') is-invalid @enderror"
                placeholder="{{ localize('enter last name') }}" required />
            <div class="invalid-feedback" role="alert">
                @error('last_name')
                    {{ $message }}
                @enderror
            </div>
        </div>

        <div class="col-12 col-md-6">
            <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                for="gender">{{ localize('Gender') }} <span class="text-danger">*</span>
            </label>
            <select name="gender" id="gender" data-allowClear="true" data-placeholder="{{ localize('Gender') }}"
                class="custom-form-control placeholder-single @error('gender') is-invalid @enderror" required>
                @foreach ($genders as $gender => $genderType)
                    <option value="{{ $genderType }}">{{ enum_ucfirst_case($gender) }}</option>
                @endforeach
            </select>
            <div class="invalid-feedback" role="alert">
                @error('status')
                    {{ $message }}
                @enderror
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                for="country">{{ localize('Country') }} <span class="text-danger">*</span>
            </label>
            <input type="text" name="country" id="country"
                class="custom-form-control form-control @error('country') is-invalid @enderror"
                placeholder="{{ localize('enter country') }}" required />
            <div class="invalid-feedback" role="alert">
                @error('country')
                    {{ $message }}
                @enderror
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                for="state">{{ localize('State') }}
            </label>
            <input type="text" name="state" id="state"
                class="custom-form-control form-control @error('state') is-invalid @enderror"
                placeholder="{{ localize('enter state') }}" />
            <div class="invalid-feedback" role="alert">
                @error('state')
                    {{ $message }}
                @enderror
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <label class="col-form-label text-start text-color-1 fs-16 fw-medium" for="city">
                {{ localize('City') }} <span class="text-danger">*</span>
            </label>
            <input type="text" name="city" id="city"
                class="custom-form-control form-control @error('city') is-invalid @enderror"
                placeholder="{{ localize('enter city') }}" required />
            <div class="invalid-feedback" role="alert">
                @error('city')
                    {{ $message }}
                @enderror
            </div>
        </div>
        <div class="col-12 mt-4 d-flex justify-content-end">
            <button type="button" class="btn btn-save py-2" onclick="stepper1.next()">
                {{ localize('Next') }}
            </button>
        </div>
    </div>
</div>
