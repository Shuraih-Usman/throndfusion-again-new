@extends('admin.app')

@section('title')
   Wallet Transactions 
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><a href="/admin/dashboard" class="text-muted fw-light">Dashboard /</a> Transactions</h4>




    <!-- Basic Bootstrap Table -->
    <div class="card">
    
    <div id="model" data-name="transactions"></div>

    

    <div style="display: flex;justify-content: space-between;" class="mb-0 d-flex justify-content-around">
      
      <h5 class="card-header showingBy">   Wallet Transactions  </h5>
      <div class="m-3">

    </div>
</div>


      <div class="table-responsive text-nowrap m-3">
        <table id="dataTable" class="table" data-filter="ALL">
          <thead>
            <tr>
              <th>Id</th>
              <th>Amount </th>
              <th>Type</th>
              <th>User </th>
              <th>Price</th>
              <th>Reference</th>
              <th>Status</th>
              <th>Date</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
    <!--/ Basic Bootstrap Table -->
  </div>


  <div class="modal fade" id="account_details" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="require_title"></h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
       
        <div class="modal-body">
          <div class="row">
            <div class="col-12">
                <h3> Bank Name </h3>
                <p id="bank_name"></p>
            </div>
            <div class="col-sm-12">
              <h3>Account Number</h3>
              <p id="account_number"></p>
            </div>
            <div class="col-sm-12">
                <h3>Account Name</h3>
                <p id="account_name"></p>
              </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
            Close
          </button>
          
        </div>
      </div>
    </div>
  </div>


@endsection