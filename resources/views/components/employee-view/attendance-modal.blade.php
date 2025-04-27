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


    </div>
  </div>

</div>