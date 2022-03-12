@extends('admin/layout')
@section('page_title','Show Customer Details')
@section('customer_select','active')
@section('container')

    <h1>Customer Details</h1>
    <div class="row mt-4">
        <div class="col-md-8">
            <!-- DATA TABLE-->
            <div class="table-responsive m-b-40">
                <table class="table table-borderless table-data3">
                    <tbody>
                        <tr>
                            <td><strong>Name</strong></td>
                            <td>{{ $data->name }}</td>
                        </tr>
                        <tr>
                            <td><strong>Email</strong></td>
                            <td>{{ $data->email }}</td>
                        </tr>
                        <tr>
                            <td><strong>Mobile</strong></td>
                            <td>{{ $data->mobile }}</td>
                        </tr>
                        <tr>
                            <td><strong>Address</strong></td>
                            <td>{{ $data->address }}</td>
                        </tr>
                        <tr>
                            <td><strong>City</strong></td>
                            <td>{{ $data->city }}</td>
                        </tr>
                        <tr>
                            <td><strong>State</strong></td>
                            <td>{{ $data->state }}</td>
                        </tr>
                        <tr>
                            <td><strong>Zip Code</strong></td>
                            <td>{{ $data->zip }}</td>
                        </tr>
                        <tr>
                            <td><strong>Company</strong></td>
                            <td>{{ $data->company }}</td>
                        </tr>
                        <tr>
                            <td><strong>Gst Number</strong></td>
                            <td>{{ $data->gstin }}</td>
                        </tr>
                        <tr>
                            <td><strong>Created On</strong></td>
                            <td>{{ \Carbon\Carbon::parse($data->created_at)->format('d-m-Y h:i:s') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Updated On</strong></td>
                            <td>{{ \Carbon\Carbon::parse($data->updated_at )->format('d-m-Y h:i:s') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- END DATA TABLE-->
        </div>
    </div>
@endsection