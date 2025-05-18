<x-app-layout>
  <div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-700 mb-2">Attendance Management</h1>
    <p class="text-gray-500 text-sm">Record your daily time entries for the current payroll period</p>
  </div>

  <div class="bg-white shadow-sm rounded-lg overflow-hidden hover:shadow-md transition-shadow duration-300">
    <form method="POST" action="{{ route('employee-view.store-attendances') }}" class="px-8 pt-6 pb-8">
      @csrf
      <input type="hidden" name="employee_id" value="{{Auth::user()->employee->id}}">
      
      <!-- Payroll Period Section -->
      <div class="mb-6">
        <div class="flex items-center mb-2">
          <span class="material-symbols-outlined text-purple-500 mr-2">date_range</span>
          <label for="payroll_period" class="text-gray-700 font-medium">Payroll Period</label>
        </div>
        <input type="text" id="payroll_period" name="payroll_period" value="{{ $startDate }} to {{ $endDate }}" readonly
          class="bg-gray-50 border-0 rounded-md w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-purple-200">
        <input type="hidden" name="from_date" value="{{ $startDate }}">
        <input type="hidden" name="to_date" value="{{ $endDate }}">
      </div>
      
      <!-- Replicate and Clear Buttons -->
      <div class="flex space-x-4 mb-6">
        <button id="replicate-button" class="bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2 rounded shadow flex items-center">
          <span class="material-symbols-outlined mr-1">content_copy</span>
          Replicate First Day
        </button>
        <button id="clear-all-button" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded shadow flex items-center">
          <span class="material-symbols-outlined mr-1">delete_sweep</span>
          Clear All
        </button>
      </div>
      
      <!-- Attendance Table -->
      <div class="mb-6">
        <div class="flex items-center mb-4">
          <span class="material-symbols-outlined text-purple-500 mr-2">schedule</span>
          <h2 class="text-gray-700 font-medium">Daily Attendance Records</h2>
        </div>
        
        <div class="overflow-x-auto">
          <table class="min-w-full border-collapse">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time In</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time Out</th>
                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
              @for ($date = \Carbon\Carbon::parse($startDate); $date->lte(\Carbon\Carbon::parse($endDate)); $date->addDay())
              <tr class="hover:bg-gray-50">
                <td class="px-4 py-3 whitespace-nowrap">
                  <input type="hidden" name="dates[]" value="{{ $date->format('Y-m-d') }}">
                  <div class="flex items-center">
                    <span class="material-symbols-outlined text-blue-400 mr-2 text-sm">event</span>
                    <span class="text-sm text-gray-700">{{ $date->format('D, M d, Y') }}</span>
                  </div>
                </td>
                <td class="px-4 py-3 whitespace-nowrap">
                  <div class="relative mt-1 rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                      <span class="material-symbols-outlined text-gray-400 text-sm">login</span>
                    </div>
                    <input type="time" name="time_in[{{ $date->format('Y-m-d') }}]"
                      class="time-in block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-300 transition-all">
                  </div>
                </td>
                <td class="px-4 py-3 whitespace-nowrap">
                  <div class="relative mt-1 rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                      <span class="material-symbols-outlined text-gray-400 text-sm">logout</span>
                    </div>
                    <input type="time" name="time_out[{{ $date->format('Y-m-d') }}]"
                      class="time-out block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-300 transition-all"
                      readonly>
                    <div class="text-red-500 text-xs mt-1 error-message hidden">Time in required first</div>
                  </div>
                </td>
                <td class="px-4 py-3 whitespace-nowrap text-center">
                  <button type="button"
                    class="clear-button p-1.5 rounded-full bg-red-50 text-red-500 hover:bg-red-100 transition-colors" title="Clear">
                    <span class="material-symbols-outlined" style="font-size: 18px;">backspace</span>
                  </button>
                </td>
              </tr>
              @endfor
            </tbody>
          </table>
        </div>
      </div>

      <div class="flex justify-end">
        <button type="submit"
          class="flex items-center bg-purple-600 hover:bg-purple-700 text-white font-medium py-2 px-6 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-300 focus:ring-opacity-50 transition-colors duration-200">
          <span class="material-symbols-outlined mr-2">check_circle</span>
          Submit Attendance
        </button>
      </div>
    </form>
  </div>

  <script>
    // Handle time in/out validation for each row
    document.addEventListener('DOMContentLoaded', function () {
      const rows = document.querySelectorAll('tbody tr');

      rows.forEach(row => {
        const timeInInput = row.querySelector('.time-in');
        const timeOutInput = row.querySelector('.time-out');
        const errorMessage = row.querySelector('.error-message');

        // Initial check
        validateTimeInputs(timeInInput, timeOutInput, errorMessage);

        // Check whenever time in changes
        timeInInput.addEventListener('change', function () {
          validateTimeInputs(timeInInput, timeOutInput, errorMessage);
          // Add visual feedback
          if (this.value) {
            this.classList.add('border-green-300', 'bg-green-50');
            this.classList.remove('border-gray-200');
          } else {
            this.classList.remove('border-green-300', 'bg-green-50');
            this.classList.add('border-gray-200');
          }
        });

        // Check whenever time out changes
        timeOutInput.addEventListener('change', function() {
          if (this.value) {
            this.classList.add('border-green-300', 'bg-green-50');
            this.classList.remove('border-gray-200');
          } else {
            this.classList.remove('border-green-300', 'bg-green-50');
            this.classList.add('border-gray-200');
          }
        });

        // Handle focus on time out
        timeOutInput.addEventListener('focus', function (e) {
          if (!timeInInput.value) {
            e.target.blur();
            errorMessage.classList.remove('hidden');
            // Show animation for error
            timeInInput.classList.add('ring-2', 'ring-red-300');
            setTimeout(() => {
              timeInInput.classList.remove('ring-2', 'ring-red-300');
            }, 1000);
          }
        });
      });

      function validateTimeInputs(timeInInput, timeOutInput, errorMessage) {
        if (!timeInInput.value) {
          timeOutInput.setAttribute('readonly', true);
          timeOutInput.value = ''; // Clear any existing value
          timeOutInput.classList.add('bg-gray-100');
          errorMessage.classList.remove('hidden');
        } else {
          timeOutInput.removeAttribute('readonly');
          timeOutInput.classList.remove('bg-gray-100');
          errorMessage.classList.add('hidden');
        }
      }
    });

    // Replicate Time In/Out
    document.getElementById('replicate-button').addEventListener('click', function () {
      const firstTimeIn = document.querySelector('.time-in').value;
      const firstTimeOut = document.querySelector('.time-out').value;

      if (!firstTimeIn) {
        alert('Please enter a time in value for the first day before replicating.');
        return;
      }

      const timeInInputs = document.querySelectorAll('.time-in');
      const timeOutInputs = document.querySelectorAll('.time-out');
      const errorMessages = document.querySelectorAll('.error-message');

      // Add animation to button
      this.classList.add('bg-indigo-200');
      setTimeout(() => {
        this.classList.remove('bg-indigo-200');
      }, 300);

      timeInInputs.forEach((input, index) => {
        if (index !== 0) {
          input.value = firstTimeIn;
          input.classList.add('border-green-300', 'bg-green-50');
          input.classList.remove('border-gray-200');
        }
      });

      timeOutInputs.forEach((input, index) => {
        if (index !== 0) {
          if (firstTimeIn) {
            input.value = firstTimeOut;
            input.removeAttribute('readonly');
            input.classList.remove('bg-gray-100');
            errorMessages[index].classList.add('hidden');
            
            if (firstTimeOut) {
              input.classList.add('border-green-300', 'bg-green-50');
              input.classList.remove('border-gray-200');
            }
          } else {
            input.value = '';
            input.setAttribute('readonly', true);
            input.classList.add('bg-gray-100');
            errorMessages[index].classList.remove('hidden');
          }
        }
      });
    });

    // Clear Time In/Out for a Row
    document.querySelectorAll('.clear-button').forEach((button, index) => {
      button.addEventListener('click', function () {
        const row = button.closest('tr');
        const timeIn = row.querySelector('.time-in');
        const timeOut = row.querySelector('.time-out');
        const errorMessage = row.querySelector('.error-message');

        // Add animation to button
        this.classList.add('bg-red-200');
        setTimeout(() => {
          this.classList.remove('bg-red-200');
        }, 300);

        timeIn.value = '';
        timeOut.value = '';
        timeOut.setAttribute('readonly', true);
        timeOut.classList.add('bg-gray-100');
        errorMessage.classList.remove('hidden');
        
        // Remove success styling
        timeIn.classList.remove('border-green-300', 'bg-green-50');
        timeIn.classList.add('border-gray-200');
        timeOut.classList.remove('border-green-300', 'bg-green-50');
        timeOut.classList.add('border-gray-200');
      });
    });
  </script>
</x-app-layout>