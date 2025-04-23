<x-guest-layout>
  <h2 class="h4">
    {{ __('First Time Registration') }}
  </h2>
  <form method="POST" action="{{ route('first-time-user.registration') }}"
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

    <!-- Name Fields -->
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

    <!-- Email -->
    <div class="mb-4">
      <label for="email" class="block text-gray-700 text-sm font-bold mb-2 px-2">Email</label>
      <input type="email" name="email" id="email"
        class="border border-gray-300 rounded-md shadow-sm focus:ring outline-none focus:ring-opacity-50 focus:ring-blue-500 focus:border-blue-500 px-2 w-full"
        placeholder="Enter email address" required>
    </div>

    <!-- Password -->
    <div class="mb-4">
      <label for="password" class="block text-gray-700 text-sm font-bold mb-2 px-2">Password</label>
      <input type="password" name="password" id="password"
        class="border border-gray-300 rounded-md shadow-sm outline-none focus:ring focus:ring-opacity-50 focus:ring-blue-500 focus:border-blue-500 px-2 w-full"
        placeholder="Enter password" required>
    </div>

    <!-- Confirm Password -->
    <div class="mb-4">
      <label for="password_confirmation" class="block text-gray-700 text-sm font-bold mb-2 px-2">Confirm
        Password</label>
      <input type="password" name="password_confirmation" id="password_confirmation"
        class="border border-gray-300 rounded-md shadow-sm outline-none focus:ring focus:ring-opacity-50 focus:ring-blue-500 focus:border-blue-500 px-2 w-full"
        placeholder="Confirm password" required>
    </div>

    <!-- Salary -->
    <div class="mb-4">
      <label for="salary" class="block text-gray-700 text-sm font-bold mb-2 px-2">Salary</label>
      <input type="number" name="salary" id="salary"
        class="border border-gray-300 rounded-md shadow-sm outline-none focus:ring focus:ring-opacity-50 focus:ring-blue-500 focus:border-blue-500 px-2 w-full"
        required>
    </div>

    <!-- Hire Date -->
    <div class="mb-4">
      <label for="hire_date" class="block text-gray-700 text-sm font-bold mb-2 px-2">Hire Date</label>
      <input type="date" name="hire_date" id="hire_date"
        class="border border-gray-300 rounded-md shadow-sm outline-none focus:ring focus:ring-opacity-50 focus:ring-blue-500 focus:border-blue-500 px-2 w-full"
        required>
    </div>

    <!-- Birthdate -->
    <div class="mb-4">
      <label for="birthdate" class="block text-gray-700 text-sm font-bold mb-2">Birthdate</label>
      <input type="date" name="birthdate" id="birthdate" class="border border-gray-300 rounded-md w-full" required>
    </div>

    <!-- Age -->
    <div class="mb-4">
      <label for="age" class="block text-gray-700 text-sm font-bold mb-2">Age</label>
      <input type="number" name="age" id="age" class="border border-gray-300 rounded-md w-full" placeholder="Enter age">
    </div>

    <!-- Address -->
    <div class="mb-4">
      <label for="address" class="block text-gray-700 text-sm font-bold mb-2">Address</label>
      <input type="text" name="address" id="address" class="border border-gray-300 rounded-md w-full"
        placeholder="Enter address">
    </div>

    <!-- SSS Number -->
    <div class="mb-4">
      <label for="sss_number" class="block text-gray-700 text-sm font-bold mb-2">SSS Number</label>
      <input type="text" name="sss_number" id="sss_number" class="border border-gray-300 rounded-md w-full"
        placeholder="Enter SSS number">
    </div>

    <!-- Pag-IBIG Number -->
    <div class="mb-4">
      <label for="pagibig_number" class="block text-gray-700 text-sm font-bold mb-2">Pag-IBIG Number</label>
      <input type="text" name="pagibig_number" id="pagibig_number" class="border border-gray-300 rounded-md w-full"
        placeholder="Enter Pag-IBIG number">
    </div>

    <!-- PhilHealth Number -->
    <div class="mb-4">
      <label for="philhealth_number" class="block text-gray-700 text-sm font-bold mb-2">PhilHealth Number</label>
      <input type="text" name="philhealth_number" id="philhealth_number"
        class="border border-gray-300 rounded-md w-full" placeholder="Enter PhilHealth number">
    </div>

    <button type="submit" class="btn-bs-primary ml-auto">
      Create Account
    </button>
  </form>
</x-guest-layout>