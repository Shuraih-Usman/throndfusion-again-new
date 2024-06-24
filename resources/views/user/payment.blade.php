@extends('user.app')

@section('title')
    Payments
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><a href="/user/dashboard" class="text-muted fw-light">Dashboard /</a> Payments</h4>




    <!-- Basic Bootstrap Table -->
    <div class="card">
    
    <div id="model" data-name="payments"></div>

    

    <div style="display: flex;justify-content: space-between;" class="mb-0 d-flex justify-content-around">
      
      <h5 class="card-header showingBy"> Payments </h5>
</div>


      <div class="table-responsive text-nowrap m-3">
        <table id="dataTable" class="table" data-filter="ALL">
          <thead>
            <tr>
              <th>Id</th>
              <th>Amount </th>
              <th>Username</th>
              <th>Reference </th>
              <th>Type</th>
              <th>Balance</th>
              <th>Status</th>
              <th>Actions</th>
              <th>Date</th>
              <th>MNF</th>

            </tr>
          </thead>
        </table>
      </div>
    </div>
    <!--/ Basic Bootstrap Table -->
  </div>





@endsection