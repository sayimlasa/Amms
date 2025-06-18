@extends('layouts.admin')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12"> <!-- Full-width column on large screens -->
                    <div class="card">
                        <div class="card-header text-center">
                            <h4 class="m-0">Tution Fee</h4>
                        </div>

                        <div class="card-body">
                            <!-- Display Control Number if generated -->
                            @if (session('controlNumber'))
                                <div class="alert alert-success text-center">
                                    <strong>Control Number Generated:</strong> {{ session('controlNumber') }}
                                </div>
                            @endif
                            <h5>Index Number <strong>{{ $indexnumber }}</strong></h5>
                            <h5>Total Tution Fee <strong>{{ $totalbeforeperc }}</strong></h5>
                            <h5>Loan Amount <strong>{{ $loanAmount }}</strong></h5>
                            <h5>40% Tuition Fee: <strong>{{ $totalfee }}</strong></h5>

                            <!-- Form to trigger control number generation -->
                            <form method="POST" action="{{ route('generate.control_number') }}">
                                @csrf
                                <div class="text-center">
                                    <div class="col-xxl-3 col-md-3" hidden>
                                        <input type="text" class="form-control" id="index_no" name="index_no"
                                            value="{{ $indexnumber }}" oninput="capitalizeOnlyFirstLetter(this)" required>
                                    </div>
                                    <div class="col-xxl-3 col-md-3" hidden>
                                        <input type="text" class="form-control" id="name" name="amount"
                                            value="{{ $totalfee }}" oninput="capitalizeOnlyFirstLetter(this)" required>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Generate Control Number</button>
                                </div>
                            </form>

                            <!-- Table to display Control Number, Bill, and Amount -->
                            <div class="mt-4">
                                <h5 class="text-center">Payment Details</h5>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Bill ID</th>
                                            <th>Control Number</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Data will be displayed here -->
                                        @php $count = 1; @endphp
                                        @foreach ($controlpayment as $payment)
                                            <tr>
                                                <td>{{ $count++ }}</td> <!-- Display the incremented count -->
                                                <td>{{ $payment->billId }}</td>
                                                <!-- Assuming 'billId' is one of the fields -->
                                                <td>{{ $payment->control_no }}</td>
                                                <!-- Assuming 'control_no' is one of the fields -->
                                                <td>{{ $payment->amount }}</td>
                                                <!-- Assuming 'amount' is one of the fields -->
                                                <td style="color: {{ $payment->status == 0 ? 'red' : 'green' }}">
                                                    {{ $payment->status == 0 ? 'Pending' : 'Paid' }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-lg-12"> <!-- Full-width column on large screens -->
                    <div class="card">
                        <div class="card-header text-center">
                            <h4 class="m-0">Application Fee</h4>
                        </div>

                        <div class="card-body">
                            <!-- Display Control Number if generated -->
                            @if (session('controlNumber'))
                                <div class="alert alert-success text-center">
                                    <strong>Control Number Generated:</strong> {{ session('controlNumber') }}
                                </div>
                            @endif
                            <h5>Index Number <strong>{{ $indexnumber }}</strong></h5>
                            <!-- Form to trigger control number generation -->
                            <form method="POST" action="{{ route('generate.control_number') }}">
                                @csrf
                                <div class="text-center">
                                    <div class="col-xxl-3 col-md-3" hidden>
                                        <input type="text" class="form-control" id="index_no" name="index_no"
                                            value="{{ $indexnumber }}" oninput="capitalizeOnlyFirstLetter(this)" required>
                                    </div>
                                    <div class="col-xxl-3 col-md-3" hidden>
                                        <input type="text" class="form-control" id="name" name="amount"
                                            value="{{ $totalfee }}" oninput="capitalizeOnlyFirstLetter(this)" required>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Generate Control Number</button>
                                </div>
                            </form>

                            <!-- Table to display Control Number, Bill, and Amount -->
                            <div class="mt-4">
                                <h5 class="text-center">Payment Details</h5>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Bill ID</th>
                                            <th>Control Number</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Data will be displayed here -->
                                        @php $count = 1; @endphp
                                        @foreach ($applicationfee as $paymentapp)
                                            <tr>
                                                <td>{{ $count++ }}</td> <!-- Display the incremented count -->
                                                <td>{{ $paymentapp->bill_id }}</td>
                                                <!-- Assuming 'billId' is one of the fields -->
                                                <td>{{ $paymentapp->control_no }}</td>
                                                <!-- Assuming 'control_no' is one of the fields -->
                                                <td>{{ $paymentapp->amount }}</td>
                                                <!-- Assuming 'amount' is one of the fields -->
                                                <td style="color: {{ $paymentapp->status == 0 ? 'red' : 'green' }}">
                                                    {{ $paymentapp->status == 0 ? 'Pending' : 'Paid' }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
