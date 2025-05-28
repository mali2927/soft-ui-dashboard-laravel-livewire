<section class="bg-light py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-7">
                <div class="card shadow-lg border-0 rounded-lg overflow-hidden">
                    <div class="card-header bg-primary text-white py-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <h3 class="mb-0"><i class="bi bi-person-gear me-2"></i>Edit Employee</h3>
                            <a href="{{ route('employee.index') }}" class="btn btn-sm btn-light">
                                <i class="bi bi-arrow-left me-1"></i> Back to List
                            </a>
                        </div>
                    </div>

                    <div class="card-body p-5">
                        @if (session()->has('error'))
                            <div class="alert alert-danger alert-dismissible fade show mb-4">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        @if (session()->has('message'))
                            <div class="alert alert-success alert-dismissible fade show mb-4">
                                <i class="bi bi-check-circle-fill me-2"></i> {{ session('message') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        <form wire:submit.prevent="update" class="needs-validation" novalidate>
                            <div class="row g-4">
                                <!-- Personal Information Section -->
                                <div class="col-12">
                                    <h5 class="text-primary mb-4"><i class="bi bi-person-badge me-2"></i>Personal
                                        Information</h5>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text"
                                            class="form-control @error('biometric_id') is-invalid @enderror"
                                            id="biometric_id" wire:model.defer="biometric_id" placeholder=" " required>
                                        <label for="biometric_id">Biometric ID</label>
                                        @error('biometric_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            id="name" wire:model.defer="name" placeholder=" " required>
                                        <label for="name">Full Name</label>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control @error('cnic') is-invalid @enderror"
                                            id="cnic" wire:model.defer="cnic" placeholder=" " required>
                                        <label for="cnic">CNIC</label>
                                        @error('cnic')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="date"
                                            class="form-control @error('date_of_birth') is-invalid @enderror"
                                            id="date_of_birth" wire:model.defer="date_of_birth" placeholder=" "
                                            required>
                                        <label for="date_of_birth">Date of Birth</label>
                                        @error('date_of_birth')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select class="form-select @error('gender') is-invalid @enderror" id="gender"
                                            wire:model.defer="gender" required>
                                            <option value="" selected disabled>Select Gender</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                        <label for="gender">Gender</label>
                                        @error('gender')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="tel"
                                            class="form-control @error('contact_number') is-invalid @enderror"
                                            id="contact_number" wire:model.defer="contact_number" placeholder=" "
                                            required>
                                        <label for="contact_number">Contact Number</label>
                                        @error('contact_number')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-floating">
                                        <input type="text"
                                            class="form-control @error('address') is-invalid @enderror" id="address"
                                            wire:model.defer="address" placeholder=" " required>
                                        <label for="address">Address</label>
                                        @error('address')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="tel"
                                            class="form-control @error('emergency_contact') is-invalid @enderror"
                                            id="emergency_contact" wire:model.defer="emergency_contact"
                                            placeholder=" " required>
                                        <label for="emergency_contact">Emergency Contact</label>
                                        @error('emergency_contact')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Employment Information Section -->
                                <div class="col-12 mt-5">
                                    <h5 class="text-primary mb-4"><i class="bi bi-briefcase me-2"></i>Employment
                                        Information</h5>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text"
                                            class="form-control @error('department') is-invalid @enderror"
                                            id="department" wire:model.defer="department" placeholder=" " required>
                                        <label for="department">Department</label>
                                        @error('department')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text"
                                            class="form-control @error('designation') is-invalid @enderror"
                                            id="designation" wire:model.defer="designation" placeholder=" " required>
                                        <label for="designation">Designation</label>
                                        @error('designation')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="date"
                                            class="form-control @error('joining_date') is-invalid @enderror"
                                            id="joining_date" wire:model.defer="joining_date" placeholder=" "
                                            required>
                                        <label for="joining_date">Joining Date</label>
                                        @error('joining_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select class="form-select @error('employment_status') is-invalid @enderror"
                                            id="employment_status" wire:model.defer="employment_status" required>
                                            <option value="" selected disabled>Select Status</option>
                                            <option value="Active">Active</option>
                                            <option value="Inactive">Inactive</option>
                                            <option value="Suspended">Suspended</option>
                                        </select>
                                        <label for="employment_status">Employment Status</label>
                                        @error('employment_status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text"
                                            class="form-control @error('employment_type') is-invalid @enderror"
                                            id="employment_type" wire:model.defer="employment_type" placeholder=" "
                                            required>
                                        <label for="employment_type">Employment Type</label>
                                        @error('employment_type')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="number" step="0.01"
                                            class="form-control @error('base_salary') is-invalid @enderror"
                                            id="base_salary" wire:model.defer="base_salary" placeholder=" " required>
                                        <label for="base_salary">Base Salary</label>
                                        @error('base_salary')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Bank Information Section -->
                                <div class="col-12 mt-5">
                                    <h5 class="text-primary mb-4"><i class="bi bi-bank me-2"></i>Bank Information</h5>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text"
                                            class="form-control @error('bank_name') is-invalid @enderror"
                                            id="bank_name" wire:model.defer="bank_name" placeholder=" " required>
                                        <label for="bank_name">Bank Name</label>
                                        @error('bank_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text"
                                            class="form-control @error('bank_account_number') is-invalid @enderror"
                                            id="bank_account_number" wire:model.defer="bank_account_number"
                                            placeholder=" " required>
                                        <label for="bank_account_number">Account Number</label>
                                        @error('bank_account_number')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="col-12 mt-5">
                                    <button type="submit" class="btn btn-primary btn-lg w-100 py-3"
                                        wire:loading.attr="disabled">
                                        <span wire:loading.class="d-none">
                                            <i class="bi bi-save-fill me-2"></i> Update Employee
                                        </span>
                                        <span wire:loading>
                                            <span class="spinner-border spinner-border-sm me-2" role="status"
                                                aria-hidden="true"></span>
                                            Updating...
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
