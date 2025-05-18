<x-app-layout>


  <h2 class="h4">
    {{ __('Create Employee') }}
  </h2>
  <form method="POST" action="{{ route('employees.store') }}"
    class="bg-white max-w-[750px] shadow-md rounded px-8 pt-6 pb-8 mb-4">
    @csrf

    @if ($errors->any())
    <div class="mb-4">
      <ul class="text-red-500 text-sm">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif

    <div class="mb-4 flex space-x-4">
      <div class="w-1/3">
        <label for="first_name" class="block text-gray-700 text-sm font-bold mb-2 px-2">First Name</label>
        <input type="text" name="first_name" id="first_name"
          class="border border-gray-300 rounded-md shadow-sm focus:ring outline-none focus:ring-opacity-50 focus:ring-blue-500 focus:border-blue-500 px-2 w-full"
          required>
      </div>
      <div class="w-1/3">
        <label for="middle_name" class="block text-gray-700 text-sm font-bold mb-2 px-2">Middle Name</label>
        <input type="text" name="middle_name" id="middle_name"
          class="border border-gray-300 rounded-md shadow-sm focus:ring outline-none focus:ring-opacity-50 focus:ring-blue-500 focus:border-blue-500 px-2 w-full">
      </div>
      <div class="w-1/3">
        <label for="last_name" class="block text-gray-700 text-sm font-bold mb-2 px-2">Last Name</label>
        <input type="text" name="last_name" id="last_name"
          class="border border-gray-300 rounded-md shadow-sm focus:ring outline-none focus:ring-opacity-50 focus:ring-blue-500 focus:border-blue-500 px-2 w-full"
          required>
      </div>
    </div>
    <div class="mb-4">
      <label for="email" class="block text-gray-700 text-sm font-bold mb-2 px-2">Email</label>
      <input type="email" name="email" id="email"
        class="border border-gray-300 rounded-md shadow-sm focus:ring outline-none focus:ring-opacity-50 focus:ring-blue-500 focus:border-blue-500 px-2 w-full"
        placeholder="Enter email address" required>
    </div>
    <div class="mb-4">
      <label for="position" class="block text-gray-700 text-sm font-bold mb-2 px-2">Position</label>

      <select name="position_id" id="position_id" default="1"
        class="border border-gray-300 rounded-md shadow-sm outline-none focus:ring focus:ring-opacity-50 focus:ring-blue-500 focus:border-blue-500 px-2  w-full"
        required>
        @foreach ($positions as $position)
        <option value="{{ $position->id }}">{{ $position->title }}</option>
        @endforeach

      </select>
    </div>

    <div class="mb-4">
      <label for="salary" class="block text-gray-700 text-sm font-bold mb-2 px-2">Salary</label>
      <input type="number" name="salary" id="salary"
        class="border border-gray-300 rounded-md shadow-sm outline-none focus:ring focus:ring-opacity-50 focus:ring-blue-500 focus:border-blue-500 px-2  w-full"
        required>
    </div>

    <div class="mb-4">
      <label for="hire_date" class="block text-gray-700 text-sm font-bold mb-2 px-2">Hire Date</label>
      <input type="date" name="hire_date" id="hire_date"
        class="border border-gray-300 rounded-md shadow-sm outline-none focus:ring focus:ring-opacity-50 focus:ring-blue-500 focus:border-blue-500 px-2  w-full"
        required />
    </div>

    <div class="mb-4">
      <label for="birthdate" class="block text-gray-700 text-sm font-bold mb-2">Birthdate</label>
      <input type="date" name="birthdate" id="birthdate" class="border border-gray-300 rounded-md w-full" required>
    </div>

    <div class="mb-4">
      <label for="age" class="block text-gray-700 text-sm font-bold mb-2">Age</label>
      <input type="number" name="age" id="age" class="border border-gray-300 rounded-md w-full" placeholder="Enter age">
    </div>

    <div class="mb-4">
      <label for="address" class="block text-gray-700 text-sm font-bold mb-2">Address</label>
      <input type="text" name="address" id="address" class="border border-gray-300 rounded-md w-full"
        placeholder="Enter address">
    </div>

    <div class="mb-4">
      <label for="sss_number" class="block text-gray-700 text-sm font-bold mb-2 px-2">SSS Number</label>
      <input type="text" name="sss_number" id="sss_number"
        class="border border-gray-300 rounded-md shadow-sm outline-none focus:ring focus:ring-opacity-50 focus:ring-blue-500 focus:border-blue-500 px-2 w-full"
        placeholder="001-234-5678-9">
    </div>

    <div class="mb-4">
      <label for="pagibig_number" class="block text-gray-700 text-sm font-bold mb-2 px-2">Pag-IBIG Number</label>
      <input type="text" name="pagibig_number" id="pagibig_number"
        class="border border-gray-300 rounded-md shadow-sm outline-none focus:ring focus:ring-opacity-50 focus:ring-blue-500 focus:border-blue-500 px-2 w-full"
        placeholder="01234567">
    </div>

    <div class="mb-4">
      <label for="philhealth_number" class="block text-gray-700 text-sm font-bold mb-2 px-2">PhilHealth Number</label>
      <input type="text" name="philhealth_number" id="philhealth_number"
        class="border border-gray-300 rounded-md shadow-sm outline-none focus:ring focus:ring-opacity-50 focus:ring-blue-500 focus:border-blue-500 px-2 w-full"
        placeholder="123-456-789-012">
    </div>

    <button type="submit" class="btn-bs-primary ml-auto flex items-center">
      <span class="material-symbols-outlined mr-1">person_add</span>
      Create Employee
    </button>
  </form>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const birthdateInput = document.getElementById('birthdate');
      const ageInput = document.getElementById('age');
      const form = document.querySelector('form');

      // Calculate and validate age when birthdate changes
      birthdateInput.addEventListener('change', function () {
        const birthdate = new Date(this.value);
        const today = new Date();

        // Calculate age
        let age = today.getFullYear() - birthdate.getFullYear();
        const monthDiff = today.getMonth() - birthdate.getMonth();

        // Adjust age if birthday hasn't occurred yet this year
        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthdate.getDate())) {
          age--;
        }

        // Set the calculated age
        ageInput.value = age;

        // Show warning if under 18
        if (age < 18) {
          alert('Employee must be at least 18 years old.');
          this.value = ''; // Clear the birthdate field
          ageInput.value = ''; // Clear the age field
        }
      });

      // Validate form submission
      form.addEventListener('submit', function (event) {
        const birthdate = new Date(birthdateInput.value);
        const today = new Date();

        // Calculate age
        let age = today.getFullYear() - birthdate.getFullYear();
        const monthDiff = today.getMonth() - birthdate.getMonth();

        // Adjust age if birthday hasn't occurred yet this year
        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthdate.getDate())) {
          age--;
        }

        // Check if employee is at least 18
        if (age < 18) {
          event.preventDefault();
          alert('Employee must be at least 18 years old.');
          return false;
        }

        // Check if age field matches calculated age
        if (parseInt(ageInput.value) !== age) {
          event.preventDefault();
          alert('Age does not match the calculated age from birthdate.');
          ageInput.value = age; // Set the correct age
          return false;
        }
      });

      // Update age when user manually changes it
      ageInput.addEventListener('change', function () {
        if (!birthdateInput.value) return;

        const birthdate = new Date(birthdateInput.value);
        const today = new Date();

        // Calculate age
        let age = today.getFullYear() - birthdate.getFullYear();
        const monthDiff = today.getMonth() - birthdate.getMonth();

        // Adjust age if birthday hasn't occurred yet this year
        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthdate.getDate())) {
          age--;
        }

        // Check if age matches calculated age
        if (parseInt(this.value) !== age) {
          alert('Age does not match the calculated age from birthdate. Auto-correcting.');
          this.value = age;
        }
      });
    });
  </script>
</x-app-layout>