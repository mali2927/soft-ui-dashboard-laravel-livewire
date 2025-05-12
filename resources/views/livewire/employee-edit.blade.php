<section>
    <div class="page-header section-height-75">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 col-lg-7 col-md-10 d-flex flex-column mx-auto">
                    <div class="card card-plain mt-5">
                        <div class="card-header pb-0 text-left bg-transparent">
                            <h3 class="font-weight-bolder text-info text-gradient">Edit Employee</h3>
                        </div>
                        <div class="card-body">
                            @if (session()->has('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif

                            <form wire:submit.prevent="update">
                                <!-- Biometric ID -->
                                <div class="mb-3">
                                    <label>Biometric ID</label>
                                    <input type="text" class="form-control @error('biometric_id') is-invalid @enderror" wire:model.defer="biometric_id">
                                    @error('biometric_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <!-- Name -->
                                <div class="mb-3">
                                    <label>Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" wire:model.defer="name">
                                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <!-- CNIC -->
                                <div class="mb-3">
                                    <label>CNIC</label>
                                    <input type="text" class="form-control @error('cnic') is-invalid @enderror" wire:model.defer="cnic">
                                    @error('cnic') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <!-- Date of Birth -->
                                <div class="mb-3">
                                    <label>Date of Birth</label>
                                    <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror" wire:model.defer="date_of_birth">
                                    @error('date_of_birth') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <!-- Gender -->
                                <div class="mb-3">
                                    <label>Gender</label>
                                    <select class="form-control @error('gender') is-invalid @enderror" wire:model.defer="gender">
                                        <option value="">Select Gender</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                    @error('gender') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <!-- Contact Number -->
                                <div class="mb-3">
                                    <label>Contact Number</label>
                                    <input type="number" class="form-control @error('contact_number') is-invalid @enderror" wire:model.defer="contact_number">
                                    @error('contact_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <!-- Address -->
                                <div class="mb-3">
                                    <label>Address</label>
                                    <input type="text" class="form-control @error('address') is-invalid @enderror" wire:model.defer="address">
                                    @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <!-- Emergency Contact -->
                                <div class="mb-3">
                                    <label>Emergency Contact</label>
                                    <input type="number" class="form-control @error('emergency_contact') is-invalid @enderror" wire:model.defer="emergency_contact">
                                    @error('emergency_contact') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <!-- Department -->
                                <div class="mb-3">
                                    <label>Department</label>
                                    <input type="text" class="form-control @error('department') is-invalid @enderror" wire:model.defer="department">
                                    @error('department') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <!-- Designation -->
                                <div class="mb-3">
                                    <label>Designation</label>
                                    <input type="text" class="form-control @error('designation') is-invalid @enderror" wire:model.defer="designation">
                                    @error('designation') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <!-- Joining Date -->
                                <div class="mb-3">
                                    <label>Joining Date</label>
                                    <input type="date" class="form-control @error('joining_date') is-invalid @enderror" wire:model.defer="joining_date">
                                    @error('joining_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <!-- Employment Status -->
                                <div class="mb-3">
                                    <label>Employment Status</label>
                                    <select class="form-control @error('employment_status') is-invalid @enderror" wire:model.defer="employment_status">
                                        <option value="">Select Status</option>
                                        <option value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>
                                        <option value="Suspended">Suspended</option>
                                    </select>
                                    @error('employment_status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <!-- Employment Type -->
                                <div class="mb-3">
                                    <label>Employment Type</label>
                                    <input type="text" class="form-control @error('employment_type') is-invalid @enderror" wire:model.defer="employment_type">
                                    @error('employment_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <!-- Base Salary -->
                                <div class="mb-3">
                                    <label>Base Salary</label>
                                    <input type="number" step="0.01" class="form-control @error('base_salary') is-invalid @enderror" wire:model.defer="base_salary">
                                    @error('base_salary') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <!-- Bank Account Number -->
                                <div class="mb-3">
                                    <label>Bank Account Number</label>
                                    <input type="number" class="form-control @error('bank_account_number') is-invalid @enderror" wire:model.defer="bank_account_number">
                                    @error('bank_account_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <!-- Bank Name -->
                                <div class="mb-3">
                                    <label>Bank Name</label>
                                    <input type="text" class="form-control @error('bank_name') is-invalid @enderror" wire:model.defer="bank_name">
                                    @error('bank_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-info btn-block">
                                        <span wire:loading.remove>Update Employee</span>
                                        <span wire:loading>Updating...</span>
                                    </button>
                                </div>
                            </form>

                            @if (session()->has('message'))
                                <div class="alert alert-success mt-3">
                                    {{ session('message') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>    
</section>