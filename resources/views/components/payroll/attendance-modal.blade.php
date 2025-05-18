<!-- Modal -->
<div id="attendance-modal" class="fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center hidden z-50">
  <div class="bg-white rounded-lg shadow-lg w-full max-w-3xl mx-4 overflow-hidden">
    <div class="flex justify-between items-center p-4 border-b bg-gray-50">
      <h3 class="font-semibold text-gray-700 flex items-center">
        <span class="material-symbols-outlined text-purple-600 mr-2">calendar_month</span>
        Attendance Records for Payroll #<span id="payroll-id"></span>
      </h3>
      <button id="close-modal" class="text-gray-400 hover:text-gray-500 focus:outline-none">
        <span class="material-symbols-outlined">close</span>
      </button>
    </div>
    
    <div class="p-6">
      <div class="mb-4">
        <div class="flex items-center justify-between mb-4">
          <div class="flex items-center">
            <span class="material-symbols-outlined text-blue-500 mr-2">event_available</span>
            <span class="font-medium text-gray-700">Daily Time Records</span>
          </div>
          <div class="bg-blue-50 text-blue-600 text-xs px-2 py-1 rounded-full font-medium flex items-center">
            <span class="material-symbols-outlined text-xs mr-1">info</span>
            Times shown in 24-hour format
          </div>
        </div>
        
        <div class="overflow-x-auto rounded-lg border border-gray-200">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time In</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time Out</th>
              </tr>
            </thead>
            <tbody id="attendance-table" class="bg-white divide-y divide-gray-200">
              <!-- Attendance records will be dynamically inserted here -->
            </tbody>
          </table>
        </div>
      </div>
      
      <div class="bg-gray-50 p-4 rounded-lg mt-6">
        <div class="flex items-center mb-4">
          <span class="material-symbols-outlined text-purple-600 mr-2">pending_actions</span>
          <span class="font-medium text-gray-700">Attendance Approval</span>
        </div>
        
        <form action="/payrolls/{$payroll->id}/update-status" id="update-status-form" method="POST" class="flex flex-col sm:flex-row gap-3 justify-end items-center">
          @csrf
          <input type="hidden" name="status" id="attendance-status" value="">
          
          <div class="text-sm text-gray-500 mr-auto">
            <p>Approve or reject this employee's attendance records for the current payroll period.</p>
          </div>
          
          <button type="button" id="reject-attendance" 
                  onclick="setStatusAndSubmit('declined')" 
                  class="px-4 py-2 bg-red-50 border border-red-200 text-red-600 rounded-md hover:bg-red-100 transition-colors disabled:opacity-50 disabled:cursor-not-allowed flex items-center">
            <span class="material-symbols-outlined mr-1">block</span>
            Reject
          </button>
          
          <button type="button" id="approve-attendance" 
                  onclick="setStatusAndSubmit('approved')" 
                  class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed flex items-center">
            <span class="material-symbols-outlined mr-1">check_circle</span>
            Approve
          </button>
        </form>
      </div>
    </div>
  </div>
</div>