<?php
$payroll->employee->user->name = htmlspecialchars($payroll->employee->user->name, ENT_QUOTES, 'UTF-8');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Payroll Details</title>
  <style>
    table {
      width: 100%;
      border-collapse: collapse;
    }

    th,
    td {
      border: 1px solid #ddd;
      padding: 8px;
      text-align: left;
    }

    th {
      background-color: #f4f4f4;
    }

    body {
      font-family: DejaVu Sans, sans-serif;
    }
  </style>
</head>

<body>
  <h1>Payroll Details</h1>
  <p><strong>Employee:</strong> {{ strtoupper($payroll->employee->user->getFullName()) }}</p>
  <p><strong>Payroll Period:</strong> Payroll {{ $payroll->from_date }} to {{ $payroll->to_date }}</p>
  <p><strong>Status:</strong> {{ strtoupper($payroll->status) }}</p>

  <h2>Payroll Details</h2>
  <table>
    <tr>
      <th>Base Salary</th>
      <th>Days Worked</th>
      <th>Deductions</th>
      <th>Net Salary</th>
    </tr>
    <tr>
      <td>₱{{ number_format($payroll->employee->salary, 2) }}</td>
      <td>{{ $payroll->getWorkedAttendances()->count() }}</td>
      <td>₱{{ number_format($payroll->employee->loansAndDeductions->sum('amount'), 2) }}</td>
      <td>₱{{ number_format($payroll->amount - $payroll->employee->loansAndDeductions->sum('amount'), 2) }}</td>
    </tr>
  </table>
</body>

</html>