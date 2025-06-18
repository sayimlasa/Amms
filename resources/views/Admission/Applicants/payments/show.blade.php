@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        Payment Details
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('application-fee.index') }}">
                    Back List
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>Payment ID</th>
                        <td>
                            {{ $p->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>Full Name</th>
                        <td>{{ $p->name }}</td>
                    </tr>
                    <tr>
                        <th>Index Number</th>
                        <td>{{ $p->index_id }}</td>
                    </tr>
                    <tr>
                        <th>
                            Control Number
                        </th>
                        <td>
                            {{ $p->control_number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Bill ID
                        </th>
                        <td>
                            {{ $p->billId }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Amount
                        </th>
                        <td>
                            {{ $p->amount }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Date Created
                        </th>
                        <td>
                            {{ $p->created_at }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Date Paid
                        </th>
                        <td>
                            {{ $p->date_paid }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Status
                        </th>
                        <td style="color: {{ $p->status == 0 ? 'red' : 'green' }}">
                            @php
                            echo $p->status == 0 ? "Not Paid" : "Paid";
                            @endphp
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('application-fee.index') }}">
                    Back List
                </a>
            </div>
        </div>
    </div>
</div>
@endsection