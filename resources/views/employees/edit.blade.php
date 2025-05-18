<x-app-layout>
  <h1 class="text-2xl font-bold mb-4">Edit Employee</h1>

  @if ($errors->any())
  <div class="bg-red-100 text-red-700 p-4 mb-4">
    <ul>
      @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
  @endif

  <form action="{{ route('employees.update', $employee->id) }}" method="POST">
    @csrf
    @method('PATCH')

    <!-- User Details -->
    <div class="mb-4">
      <label for="first_name" class="block text-sm font-medium">First Name</label>
      <input type="text" name="first_name" id="first_name" value="{{ old('first_name', $employee->user->first_name) }}"
        class="form-input w-full">
    </div>

    <div class="mb-4">
      <label for="middle_name" class="block text-sm font-medium">Middle Name</label>
      <input type="text" name="middle_name" id="middle_name"
        value="{{ old('middle_name', $employee->user->middle_name) }}" class="form-input w-full">
    </div>

    <div class="mb-4">
      <label for="last_name" class="block text-sm font-medium">Last Name</label>
      <input type="text" name="last_name" id="last_name" value="{{ old('last_name', $employee->user->last_name) }}"
        class="form-input w-full">
    </div>

    <div class="mb-4">
      <label for="email" class="block text-sm font-medium">Email</label>
      <input type="email" name="email" id="email" value="{{ old('email', $employee->user->email) }}"
        class="form-input w-full">
    </div>

    <!-- Employee Details -->
    <div class="mb-4">
      <label for="position_id" class="block text-sm font-medium">Position</label>
      <select name="position_id" id="position_id" class="form-select w-full">
        @foreach ($positions as $position)
        <option value="{{ $position->id }}" {{ $employee->position_id == $position->id ? 'selected' : '' }}>
          {{ $position->title }}
        </option>
        @endforeach
      </select>
    </div>

    <div class="mb-4">
      <label for="salary" class="block text-sm font-medium">Salary</label>
      <input type="number" name="salary" id="salary" value="{{ old('salary', $employee->salary) }}"
        class="form-input w-full">
    </div>

    <div class="mb-4">
      <label for="hire_date" class="block text-sm font-medium">Hire Date</label>
      <input type="date" name="hire_date" id="hire_date" value="{{ old('hire_date', $employee->hire_date) }}"
        class="form-input w-full">
    </div>

    <div class="mb-4">
      <label for="birthdate" class="block text-sm font-medium">Birthdate</label>
      <input type="date" name="birthdate" id="birthdate" value="{{ old('birthdate', $employee->birthdate) }}"
        class="form-input w-full">
    </div>

    <div class="mb-4">
      <label for="age" class="block text-sm font-medium">Age</label>
      <input type="number" name="age" id="age" value="{{ old('age', $employee->age) }}" class="form-input w-full">
    </div>

    <div class="mb-4">
      <label for="address" class="block text-sm font-medium">Address</label>
      <input type="text" name="address" id="address" value="{{ old('address', $employee->address) }}"
        class="form-input w-full">
    </div>

    <div class="mb-4">
      <label for="sss_number" class="block text-sm font-medium">SSS Number</label>
      <input type="text" name="sss_number" id="sss_number" value="{{ old('sss_number', $employee->sss_number) }}"
        class="form-input w-full">
    </div>

    <div class="mb-4">
      <label for="pagibig_number" class="block text-sm font-medium">Pag-IBIG Number</label>
      <input type="text" name="pagibig_number" id="pagibig_number"
        value="{{ old('pagibig_number', $employee->pagibig_number) }}" class="form-input w-full">
    </div>

    <div class="mb-4">
      <label for="philhealth_number" class="block text-sm font-medium">PhilHealth Number</label>
      <input type="text" name="philhealth_number" id="philhealth_number"
        value="{{ old('philhealth_number', $employee->philhealth_number) }}" class="form-input w-full">
    </div>

    <div class="flex gap-4">
      <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded flex items-center">
        <span class="material-symbols-outlined mr-1">save</span>
        Update Employee
      </button>
      
      <a href="{{ route('employees.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded flex items-center">
        <span class="material-symbols-outlined mr-1">arrow_back</span>
        Back to List
      </a>
    </div>
  </form>
</x-app-layout>