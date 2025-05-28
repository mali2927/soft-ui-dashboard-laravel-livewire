<section class="bg-light py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-7">
                <div class="card shadow-lg border-0 rounded-lg overflow-hidden">
                    <div class="card-header bg-primary text-white py-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <h3 class="mb-0"><i class="bi bi-person-plus me-2"></i>Create New Employee</h3>
                            <a href="{{ route('employee.index') }}" class="btn btn-sm btn-light">
                                <i class="bi bi-arrow-left me-1"></i> Back
                            </a>
                        </div>
                        <p class="mb-0 mt-2 opacity-75">Fill in all required details below</p>
                    </div>

                    <div class="card-body p-5">
                        @if (session()->has('message'))
                            <div class="alert alert-success alert-dismissible fade show mb-4">
                                <i class="bi bi-check-circle-fill me-2"></i> {{ session('message') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        <form wire:submit.prevent="save" class="needs-validation" novalidate>
                            <div class="row g-4">
                                <!-- Personal Information Section -->
                                <div class="col-12">
                                    <h5 class="text-primary mb-4"><i class="bi bi-person-badge me-2"></i>Personal
                                        Information</h5>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="biometric_id"
                                            wire:model="biometric_id" placeholder=" " required>
                                        <label for="biometric_id">Biometric ID</label>
                                        @error('biometric_id')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="name" wire:model="name"
                                            placeholder=" " required>
                                        <label for="name">Full Name</label>
                                        @error('name')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="cnic" wire:model="cnic"
                                            placeholder=" " required>
                                        <label for="cnic">CNIC</label>
                                        @error('cnic')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="date" class="form-control" id="date_of_birth"
                                            wire:model="date_of_birth" placeholder=" " required>
                                        <label for="date_of_birth">Date of Birth</label>
                                        @error('date_of_birth')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select class="form-select" id="gender" wire:model="gender" required>
                                            <option value="" selected disabled>Select Gender</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                        <label for="gender">Gender</label>
                                        @error('gender')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="tel" class="form-control" id="contact_number"
                                            wire:model="contact_number" placeholder=" " required>
                                        <label for="contact_number">Contact Number</label>
                                        @error('contact_number')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="address" wire:model="address"
                                            placeholder=" " required>
                                        <label for="address">Address</label>
                                        @error('address')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="tel" class="form-control" id="emergency_contact"
                                            wire:model="emergency_contact" placeholder=" " required>
                                        <label for="emergency_contact">Emergency Contact</label>
                                        @error('emergency_contact')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
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
                                        <input type="text" class="form-control" id="department"
                                            wire:model="department" placeholder=" " required>
                                        <label for="department">Department</label>
                                        @error('department')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="designation"
                                            wire:model="designation" placeholder=" " required>
                                        <label for="designation">Designation</label>
                                        @error('designation')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="date" class="form-control" id="joining_date"
                                            wire:model="joining_date" placeholder=" " required>
                                        <label for="joining_date">Joining Date</label>
                                        @error('joining_date')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select class="form-select" id="employment_status"
                                            wire:model="employment_status" required>
                                            <option value="" selected disabled>Select Status</option>
                                            <option value="Active">Active</option>
                                            <option value="Inactive">Inactive</option>
                                            <option value="Suspended">Suspended</option>
                                        </select>
                                        <label for="employment_status">Employment Status</label>
                                        @error('employment_status')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="employment_type"
                                            wire:model="employment_type" placeholder=" " required>
                                        <label for="employment_type">Employment Type</label>
                                        @error('employment_type')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="number" step="0.01" class="form-control" id="base_salary"
                                            wire:model="base_salary" placeholder=" " required>
                                        <label for="base_salary">Base Salary</label>
                                        @error('base_salary')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Bank Information Section -->
                                <div class="col-12 mt-5">
                                    <h5 class="text-primary mb-4"><i class="bi bi-bank me-2"></i>Bank Information</h5>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="bank_name"
                                            wire:model="bank_name" placeholder=" " required>
                                        <label for="bank_name">Bank Name</label>
                                        @error('bank_name')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="bank_account_number"
                                            wire:model="bank_account_number" placeholder=" " required>
                                        <label for="bank_account_number">Account Number</label>
                                        @error('bank_account_number')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="col-12 mt-5">
                                    <button type="submit" class="btn btn-primary btn-lg w-100 py-3">
                                        <i class="bi bi-save-fill me-2"></i> Save Employee Details
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
