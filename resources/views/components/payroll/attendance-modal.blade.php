<!-- Modal -->
<div id="attendance-modal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center hidden">
  <div class="bg-white rounded-lg shadow-lg w-1/2">
    <div class="p-4 border-b">
      <h2 class="text-lg font-bold">Attendance Records for Payroll #<span id="payroll-id"></span></h2>
      <button id="close-modal" class="text-red-500 hover:text-red-700 float-right">X</button>
    </div>
    <div class="p-4">
      <table class="table-auto w-full border-collapse border border-gray-300">
        <thead>
          <tr>
            <th class="border border-gray-300 px-4 py-2">Date</th>
            <th class="border border-gray-300 px-4 py-2">Time In</th>
            <th class="border border-gray-300 px-4 py-2">Time Out</th>
          </tr>
        </thead>
        <tbody id="attendance-table">
          <!-- Attendance records will be dynamically inserted here -->
        </tbody>
      </table>

      <form action="/payrolls/{$payroll->id}/update-status" id="update-status-form" method="POST"
        class="flex w-full gap-3 ml-auto justify-end">
        @csrf
        <input type="hidden" name="status" id="attendance-status" value="">
        <button class="btn btn-danger mt-4 disabled:bg-gray-400 disabled:text-neutral-700" type="button"
          id="reject-attendance" onclick="setStatusAndSubmit('declined')" disabled>
          Reject
        </button>
        <button class="btn btn-primary mt-4 disabled:bg-gray-400 disabled:text-neutral-700" type="button"
          id="approve-attendance" onclick="setStatusAndSubmit('approved')" disabled>
          Approve
        </button>
      </form>


    </div>
  </div>
</div>