<div class="card">
  <div class="card-body">
    <h2 class="font-bold text-lg mb-10">{{ $title }}</h2>

    @if ($payrolls->isEmpty())
    <p class="text-center text-gray-500">No payroll data available.</p>
    @else
    <!-- start a table -->
    <table class="table-fixed w-full">
      <thead class="text-left">
        <tr>
          <th class="w-1/4 pb-10 text-sm font-extrabold tracking-wide">From Date</th>
          <th class="w-1/4 pb-10 text-sm font-extrabold tracking-wide text-right">To Date</th>
          <th class="w-1/4 pb-10 text-sm font-extrabold tracking-wide text-right">Days Worked</th>
          <th class="w-1/4 pb-10 text-sm font-extrabold tracking-wide text-right">Base Salary</th>
          <th class="w-1/4 pb-10 text-sm font-extrabold tracking-wide text-right">Deductions</th>
          <th class="w-1/4 pb-10 text-sm font-extrabold tracking-wide text-right">Net Salary</th>
          <th class="w-1/4 pb-10 text-sm font-extrabold tracking-wide text-right">Status</th>
          <th class="w-1/4 pb-10 text-sm font-extrabold tracking-wide text-right">Actions</th>
        </tr>
      </thead>
      <tbody class="text-left text-gray-600">
        @foreach ($payrolls as $payroll)
        <tr>
          <!-- From Date -->
          <th class="w-1/4 mb-4 text-xs font-extrabold tracking-wider">
            {{ $payroll->from_date}}
          </th>

          <!-- To Date -->
          <th class="w-1/4 mb-4 text-xs font-extrabold tracking-wider text-right">
            {{ $payroll->to_date}}
          </th>

          <!-- Days Worked -->
          <th class="w-1/4 mb-4 text-xs font-extrabold tracking-wider text-right">
            {{ $payroll->getWorkedAttendances()->count() }}
          </th>

          <!-- Base Salary -->
          <th class="w-1/4 mb-4 text-xs font-extrabold tracking-wider text-right">
            ₱{{ number_format($payroll->employee->salary, 2) }}
          </th>

          <!-- Deductions -->
          <th class="w-1/4 mb-4 text-xs font-extrabold tracking-wider text-right">
            ₱{{ number_format($payroll->employee->loansAndDeductions->sum('amount'), 2) }}
          </th>

          <!-- Net Salary -->
          <th class="w-1/4 mb-4 text-xs font-extrabold tracking-wider text-right">
            ₱{{ number_format($payroll->amount - $payroll->employee->loansAndDeductions->sum('amount'), 2) }}
          </th>

          <!-- Status -->
          <th class="w-1/4 mb-4 text-xs font-extrabold tracking-wider text-right">
            {{ strtoupper($payroll->status) }}
          </th>

          <!-- Actions -->
          <th class="w-1/4 mb-4 text-xs font-extrabold tracking-wider text-right">
            <div class="flex justify-end space-x-2">
              <button class="text-blue-500 hover:text-blue-700 view-attendance-btn" data-id="{{ $payroll->id }}">
                View
              </button>

              @if ($payroll->status === 'paid')
              <a href="{{ route('payroll.download-pdf', $payroll->id) }}" class="text-green-500 hover:text-green-700">
                Print
              </a>
              @endif
            </div>
          </th>
        </tr>
        @endforeach
      </tbody>
    </table>
    @endif
  </div>
</div>

<x-employee-view.attendance-modal />

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('attendance-modal');
    const closeModal = document.getElementById('close-modal');
    const attendanceTable = document.getElementById('attendance-table');
    const payrollIdSpan = document.getElementById('payroll-id');

    // Open modal and fetch payroll data
    document.querySelectorAll('.view-attendance-btn').forEach(button => {
      button.addEventListener('click', function () {
        const payrollId = this.getAttribute('data-id');
        console.log(`/employee-view/${payrollId}/attendances`)
        payrollIdSpan.textContent = payrollId;

        // Fetch payroll data
        fetch(`/employee-view/${payrollId}/attendances`)
          .then(response => response.json())
          .then(data => {
            // Clear existing table rows
            attendanceTable.innerHTML = '';

            // Populate table with attendance data
            data.attendances.forEach(attendance => {
              const row = `
                <tr>
                  <td class="border border-gray-300 px-4 py-2">${attendance.date}</td>
                  <td class="border border-gray-300 px-4 py-2">${attendance.time_in || 'N/A'}</td>
                  <td class="border border-gray-300 px-4 py-2">${attendance.time_out || 'N/A'}</td>
                </tr>
              `;
              attendanceTable.insertAdjacentHTML('beforeend', row);
            });

            modal.classList.remove('hidden');
          })
          .catch(error => {
            console.error('Error fetching payroll data:', `/employee-view/${payrollId} / attendances`);
          });
      });
    });

    // Close modal
    closeModal.addEventListener('click', function () {
      modal.classList.add('hidden');
    });
  });
</script>