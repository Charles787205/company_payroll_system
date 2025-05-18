<div class="card rounded-lg shadow-sm overflow-hidden bg-white hover:shadow-md transition-shadow duration-300">
  <div class="card-body p-6">
    <h2 class="font-bold text-lg mb-6 text-gray-700">{{ $title }}</h2>

    @if ($payrolls->isEmpty())
    <div class="py-8 text-center text-gray-500 bg-gray-50 rounded-lg">
      <span class="material-symbols-outlined text-4xl mb-2">payments_off</span>
      <p>No payroll data available.</p>
    </div>
    @else
    <!-- start a table -->
    <div class="overflow-x-auto">
      <table class="min-w-full">
        <thead class="text-left bg-gray-50">
          <tr>
            <th class="px-4 py-3 text-sm font-semibold tracking-wide text-gray-600">Employee</th>
            <th class="px-4 py-3 text-sm font-semibold tracking-wide text-gray-600">Position</th>
            <th class="px-4 py-3 text-sm font-semibold tracking-wide text-gray-600 text-center">Days Worked</th>
            <th class="px-4 py-3 text-sm font-semibold tracking-wide text-gray-600 text-right">Base Salary</th>
            <th class="px-4 py-3 text-sm font-semibold tracking-wide text-gray-600 text-right">Deductions</th>
            <th class="px-4 py-3 text-sm font-semibold tracking-wide text-gray-600 text-right">Net Salary</th>
            <th class="px-4 py-3 text-sm font-semibold tracking-wide text-gray-600 text-center">Status</th>
            <th class="px-4 py-3 text-sm font-semibold tracking-wide text-gray-600 text-center">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
          @foreach ($payrolls as $payroll)
          <tr class="hover:bg-gray-50">
            <!-- Employee Name -->
            <td class="px-4 py-4">
              <div class="flex items-center">
                <div class="w-8 h-8 flex-shrink-0 mr-3 rounded-full bg-purple-100 flex items-center justify-center text-purple-500">
                  <span class="material-symbols-outlined text-sm">person</span>
                </div>
                <div>
                  <div class="font-medium text-gray-700">{{ $payroll->employee->user->getFullName() }}</div>
                  <div class="text-xs text-gray-500">ID: {{ $payroll->employee->id }}</div>
                </div>
              </div>
            </td>

            <!-- Position -->
            <td class="px-4 py-4 text-sm">
              <span class="inline-flex items-center">
                <span class="material-symbols-outlined text-blue-400 mr-1 text-sm">work</span>
                {{ $payroll->employee->position->title }}
              </span>
            </td>

            <!-- Days Worked -->
            <td class="px-4 py-4 text-sm text-center">
              <span class="inline-flex items-center justify-center">
                <span class="material-symbols-outlined text-blue-400 mr-1 text-sm">event_available</span>
                {{ $payroll->getWorkedAttendances()->count() }}
              </span>
            </td>

            <!-- Base Salary -->
            <td class="px-4 py-4 text-sm text-right">
              ₱{{ number_format($payroll->employee->salary, 2) }}
            </td>

            <!-- Deductions -->
            <td class="px-4 py-4 text-sm text-right">
              <span class="text-red-500">-₱{{ number_format($payroll->employee->loansAndDeductions->sum('amount'), 2) }}</span>
            </td>

            <!-- Net Salary -->
            <td class="px-4 py-4 font-medium text-right">
              <span class="text-green-600">₱{{ number_format($payroll->amount - $payroll->employee->loansAndDeductions->sum('amount'), 2) }}</span>
            </td>

            <!-- Status -->
            <td class="px-4 py-4 text-sm text-center">
              @if ($payroll->status === 'paid')
              <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                <span class="material-symbols-outlined text-sm mr-1">check_circle</span>
                PAID
              </span>
              @elseif ($payroll->status === 'approved')
              <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                <span class="material-symbols-outlined text-sm mr-1">verified</span>
                APPROVED
              </span>
              @else
              <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                <span class="material-symbols-outlined text-sm mr-1">pending</span>
                PENDING
              </span>
              @endif
            </td>

            <!-- Actions -->
            <td class="px-4 py-4 text-sm text-center">
              <div class="flex justify-center space-x-2">
                <!-- View Attendance Button -->
                <button class="p-1.5 rounded-full bg-blue-50 text-blue-500 hover:bg-blue-100 transition-colors view-attendance-btn" 
                        data-id="{{ $payroll->id }}"
                        data-status="{{ $payroll->status }}"
                        title="View Attendance">
                  <span class="material-symbols-outlined" style="font-size: 20px;">calendar_view_week</span>
                </button>

                <!-- Pay Salary Button -->
                @if ($payroll->status !== 'paid')
                <form action="{{ route('payrolls.setPaid', $payroll->id) }}" method="POST">
                  @csrf
                  <button type="submit" 
                          class="p-1.5 rounded-full bg-green-50 text-green-500 hover:bg-green-100 transition-colors"
                          title="Process Payment">
                    <span class="material-symbols-outlined" style="font-size: 20px;">payments</span>
                  </button>
                </form>
                @endif
                
                <!-- Download PDF Button -->
                <a href="{{ route('payroll.download-pdf', $payroll->id) }}" 
                   class="p-1.5 rounded-full bg-purple-50 text-purple-500 hover:bg-purple-100 transition-colors inline-flex items-center justify-center"
                   title="Download Payslip">
                  <span class="material-symbols-outlined" style="font-size: 20px;">download</span>
                </a>
              </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    @endif
  </div>
</div>

<x-payroll.attendance-modal :payrolls="$payrolls" />

<script>
  document.addEventListener('DOMContentLoaded', function () {
    // Search functionality
    const searchInput = document.getElementById('search-payroll');
    const statusFilter = document.getElementById('status-filter');
    const tableRows = document.querySelectorAll('tbody tr');
    
    function filterTable() {
      const searchTerm = searchInput.value.toLowerCase();
      const statusValue = statusFilter.value.toLowerCase();
      
      tableRows.forEach(row => {
        const employeeName = row.querySelector('td:first-child').textContent.toLowerCase();
        const statusCell = row.querySelector('td:nth-child(7)').textContent.toLowerCase();
        
        const matchesSearch = employeeName.includes(searchTerm);
        const matchesStatus = statusValue === 'all' || statusCell.includes(statusValue);
        
        if (matchesSearch && matchesStatus) {
          row.classList.remove('hidden');
        } else {
          row.classList.add('hidden');
        }
      });
    }
    
    searchInput.addEventListener('input', filterTable);
    statusFilter.addEventListener('change', filterTable);
    
    // Attendance modal functionality
    function updateButtonState(status) {
      const approveButton = document.getElementById('approve-attendance');
      const rejectButton = document.getElementById('reject-attendance');

      if (status.toLowerCase() != 'pending') {
        approveButton.disabled = true;
        rejectButton.disabled = true;
        approveButton.classList.add('opacity-50', 'cursor-not-allowed');
        rejectButton.classList.add('opacity-50', 'cursor-not-allowed');
      } else {
        approveButton.disabled = false;
        rejectButton.disabled = false;
        approveButton.classList.remove('opacity-50', 'cursor-not-allowed');
        rejectButton.classList.remove('opacity-50', 'cursor-not-allowed');
      }
    }
    
    function setStatusAndSubmit(status) {
      document.getElementById('attendance-status').value = status;
      document.getElementById('update-status-form').submit();
    }
    
    const modal = document.getElementById('attendance-modal');
    const closeModal = document.getElementById('close-modal');
    const attendanceTable = document.getElementById('attendance-table');
    const payrollIdSpan = document.getElementById('payroll-id');

    // Open modal and fetch attendance data
    document.querySelectorAll('.view-attendance-btn').forEach(button => {
      button.addEventListener('click', function () {
        const payrollId = this.getAttribute('data-id');
        const status = this.getAttribute('data-status');
        
        // Set the payroll ID in the modal title
        payrollIdSpan.textContent = payrollId;

        // Fetch attendance data
        fetch(`/payrolls/${payrollId}/attendances`)
          .then(response => response.json())
          .then(data => {
            // Clear existing table rows
            attendanceTable.innerHTML = '';

            // Populate table with attendance data
            data.attendances.forEach(attendance => {
              const row = `
                <tr class="hover:bg-gray-50">
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">${attendance.date}</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 ${attendance.time_in ? 'text-green-600' : 'text-gray-400'}">${attendance.time_in || 'Not recorded'}</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 ${attendance.time_out ? 'text-green-600' : 'text-gray-400'}">${attendance.time_out || 'Not recorded'}</td>
                </tr>
              `;
              attendanceTable.insertAdjacentHTML('beforeend', row);
            });
            
            updateButtonState(status);

            modal.classList.remove('hidden');
            const updateForm = document.getElementById('update-status-form');
            updateForm.action = `/payrolls/${payrollId}/update-status`;
            updateForm.addEventListener("submit", function (event) {
              event.preventDefault(); // Prevent the default form submission
              const status = document.getElementById('attendance-status').value;

              if (status) {
                setStatusAndSubmit(status);
              }
            });
          })
          .catch(error => {
            console.error('Error fetching attendance data:', error);
          });
      });
    });

    // Close modal
    closeModal.addEventListener('click', function () {
      modal.classList.add('hidden');
    });
    
    // Close modal when clicking outside
    window.addEventListener('click', function(event) {
      if (event.target === modal) {
        modal.classList.add('hidden');
      }
    });
  });
</script>