<!DOCTYPE html>
<html>

<head>
    <style>
        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
            text-align: center
        }
        .center {
            margin-left: auto;
            margin-right: auto;
        }
    </style>
</head>

<body>

    <div class="body">
        <table class="table center">
            <thead>
                <tr>
                    <th>Student Name</th>
                    <th>Adviser</th>
                    <th>Reference Number</th>
                    <th>Amount</th>
                    <th>Date of Submission</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($receipts as $data)
                    <tr>
                        <td>{{ $data->user->name }}</td>
                        <td>{{ $data->researchPaper->adviser->name }}</td>
                        <td>{{ $data->reference_number }}</td>
                        <td>{{ $data->amount }}</td>
                        <td>{{ $data->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div>
        <p>Total amount submitted by students: {{ $totalAmount }}</p>
    </div>
</body>

</html>
