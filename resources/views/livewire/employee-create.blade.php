<section>
    <div class="page-header section-height-75">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 col-lg-7 col-md-8 d-flex flex-column mx-auto">
                    <div class="card card-plain mt-4">
                        <div class="card-header pb-0 text-left bg-transparent">
                            <h4 class="font-weight-bolder text-info text-gradient">Create Employee</h4>
                            <p class="mb-0">Fill in the details below</p>
                        </div>
                        <div class="card-body">
                            @if (session()->has('message'))
                                <div class="alert alert-success">{{ session('message') }}</div>
                            @endif

                            <form wire:submit.prevent="save">
                                <div class="mb-3">
                                    <label>Biometric ID</label>
                                    <input type="text" class="form-control" wire:model="biometric_id">
                                    @error('biometric_id') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="mb-3">
                                    <label>Name</label>
                                    <input type="text" class="form-control" wire:model="name">
                                    @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="mb-3">
                                    <label>CNIC</label>
                                    <input type="text" class="form-control" wire:model="cnic">
                                    @error('cnic') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="mb-3">
                                    <label>Date of Birth</label>
                                    <input type="date" class="form-control" wire:model="date_of_birth">
                                    @error('date_of_birth') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="mb-3">
                                    <label>Gender</label>
                                    <select class="form-control" wire:model="gender">
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                    @error('gender') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="mb-3">
                                    <label>Contact Number</label>
                                    <input type="number" class="form-control" wire:model="contact_number">
                                    @error('contact_number') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="mb-3">
                                    <label>Address</label>
                                    <input type="text" class="form-control" wire:model="address">
                                    @error('address') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="mb-3">
                                    <label>Emergency Contact</label>
                                    <input type="number" class="form-control" wire:model="emergency_contact">
                                    @error('emergency_contact') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="mb-3">
                                    <label>Department</label>
                                    <input type="text" class="form-control" wire:model="department">
                                    @error('department') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="mb-3">
                                    <label>Designation</label>
                                    <input type="text" class="form-control" wire:model="designation">
                                    @error('designation') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="mb-3">
                                    <label>Joining Date</label>
                                    <input type="date" class="form-control" wire:model="joining_date">
                                    @error('joining_date') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="mb-3">
                                    <label>Employment Status</label>
                                    <select class="form-control" wire:model="employment_status">
                                        <option value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>
                                        <option value="Suspended">Suspended</option>
                                    </select>
                                    @error('employment_status') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="mb-3">
                                    <label>Employment Type</label>
                                    <input type="text" class="form-control" wire:model="employment_type">
                                    @error('employment_type') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="mb-3">
                                    <label>Base Salary</label>
                                    <input type="number" step="0.01" class="form-control" wire:model="base_salary">
                                    @error('base_salary') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="mb-3">
                                    <label>Bank Account Number</label>
                                    <input type="number" class="form-control" wire:model="bank_account_number">
                                    @error('bank_account_number') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="mb-3">
                                    <label>Bank Name</label>
                                    <input type="text" class="form-control" wire:model="bank_name">
                                    @error('bank_name') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-info w-100 mt-4 mb-0">Save Employee</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
