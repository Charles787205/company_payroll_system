<x-app-layout>
  <h1 class="text-2xl font-bold mb-4">Attendance Input</h1>

  @php
  $currentDay = now()->day; // Get the current day
  $currentMonth = now()->month; // Get the current month
  $currentYear = now()->year; // Get the current year

  if ($currentDay >= 1 && $currentDay <= 15) { // First payroll period: 1–15 $startDate=now()->
    startOfMonth()->format('Y-m-d'); // 1st of the month
    $endDate = now()->startOfMonth()->addDays(14)->format('Y-m-d'); // 15th of the month
    } else {
    // Second payroll period: 16–end of the month
    $startDate = now()->startOfMonth()->addDays(15)->format('Y-m-d'); // 16th of the month
    $endDate = now()->endOfMonth()->format('Y-m-d'); // Last day of the month
    }
    @endphp

    <form method="POST" action="{{ route('employee-view.store-attendances') }}"
      class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
      @csrf
      <input type="hidden" name="employee_id" value="{{Auth::user()->employee->id}}">
      <div class="mb-4">
        <label for="payroll_period" class="block text-gray-700 text-sm font-bold mb-2">Payroll Period</label>
        <input type="text" id="payroll_period" name="payroll_period" value="{{ $startDate }} to {{ $endDate }}" readonly
          class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        <input type="hidden" name="from_date" value="{{$startDate }}">
        <input type="hidden" name="to_date" value="{{ $endDate}}">
      </div>
      <div class="mb-4">
        <button type="button" id="replicate-button"
          class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
          Replicate Time In/Out
        </button>
      </div>
      <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2">Attendance</label>
        <table class="table-auto w-full border-collapse border border-gray-300">
          <thead>
            <tr>
              <th class="border border-gray-300 px-4 py-2">Date</th>
              <th class="border border-gray-300 px-4 py-2">Time In</th>
              <th class="border border-gray-300 px-4 py-2">Time Out</th>
              <th class="border border-gray-300 px-4 py-2">Actions</th>
            </tr>
          </thead>
          <tbody>
            @for ($date = \Carbon\Carbon::parse($startDate); $date->lte(\Carbon\Carbon::parse($endDate));
            $date->addDay())
            <tr>
              <td class="border border-gray-300 px-4 py-2">
                <input type="hidden" name="dates[]" value="{{ $date->format('Y-m-d') }}">
                {{ $date->format('Y-m-d') }}
              </td>
              <td class="border border-gray-300 px-4 py-2">
                <input type="time" name="time_in[{{ $date->format('Y-m-d') }}]"
                  class="time-in shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
              </td>
              <td class="border border-gray-300 px-4 py-2">
                <input type="time" name="time_out[{{ $date->format('Y-m-d') }}]"
                  class="time-out shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
              </td>
              <td class="border border-gray-300 px-4 py-2 text-center">
                <button type="button"
                  class="clear-button bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded focus:outline-none focus:shadow-outline">
                  Clear
                </button>
              </td>
            </tr>
            @endfor
          </tbody>
        </table>
      </div>



      <div class="flex items-center justify-between">
        <button type="submit"
          class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
          Submit Attendance
        </button>
      </div>
    </form>

    <script>
      // Replicate Time In/Out
      document.getElementById('replicate-button').addEventListener('click', function () {
        const firstTimeIn = document.querySelector('.time-in').value;
        const firstTimeOut = document.querySelector('.time-out').value;

        const timeInInputs = document.querySelectorAll('.time-in');
        const timeOutInputs = document.querySelectorAll('.time-out');

        timeInInputs.forEach((input, index) => {
          if (index !== 0) {
            input.value = firstTimeIn;
          }
        });

        timeOutInputs.forEach((input, index) => {
          if (index !== 0) {
            input.value = firstTimeOut;
          }
        });
      });

      // Clear Time In/Out for a Row
      document.querySelectorAll('.clear-button').forEach((button, index) => {
        button.addEventListener('click', function () {
          const row = button.closest('tr');
          row.querySelector('.time-in').value = '';
          row.querySelector('.time-out').value = '';
        });
      });
    </script>
</x-app-layout>