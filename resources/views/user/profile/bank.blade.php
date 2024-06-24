@extends('user.app')

@section('title')
    Update Bank details
@endsection
@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
      <h4 class="fw-bold py-3 mb-4"><a href="/user/dashboard" class="text-muted fw-light">Dashboard /</a> <a href="{{route('profile')}}" class="text-muted fw-light">Profile /</a>  Edit Profile</h4>
      <div id="model" data-name="users"></div>
      <!-- Basic Layout -->
      <div class="row">

        <ul class="nav nav-pills flex-column flex-md-row m-3">
            <li class="nav-item">
              <a class="nav-link" href="{{route('profile')}}"><i class="bx bx-user me-1"></i> Account</a>
            </li>
            <li class="nav-item">
              <a class="nav-link " href="{{route('edit-profile')}}"><i class="bx bx-edit me-1"></i> Edit Profile</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" href="javascript:void(0);"><i class="bx bxs-bank me-1"></i> Update Bank Details</a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="{{route('changepass')}}"><i class="bx bxs-user me-1"></i>Change Password</a>
            </li>
          </ul>
        
        <div class="col-xl">
          <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
              <h5 class="mb-0">Update Bank Details  </h5>
            </div>
            <div class="card-body">
              <form id="addform" class="row" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="col-sm-12 col-md-12 mb-3">
                  <label class="form-label" for="basic-icon-default-fullname">NIN Number</label>
                  <div class="input-group input-group-merge">
                    <span id="basic-icon-default-fullname2" class="input-group-text"
                      ><i class="bx bx-user"></i
                    ></span>
                    <input
                      type="text"
                      name="nin"
                      class="form-control"
                      id="basic-icon-default-fullname"
                      aria-describedby="basic-icon-default-fullname2"
                      value="{{$user->nin_number}}"
                    />
                  </div>
                </div>
                <div class="col-sm-6 col-md-6 mb-3">
                  <label class="form-label" for="basic-icon-default-email">Bank Name</label>
                  <div class="input-group input-group-merge">
                    <span class="input-group-text"><i class="bx bxs-bank"></i></span>
                    <input
                      type="text"
                      
                      name="bank"
                      id=""
                      class="form-control"
                      aria-describedby="basic-icon-default-email2"
                      value="{{$user->bank_name}}">
                  
                  </div>
                  
                </div>
                <div class="col-sm-6 col-md-6 mb-3">
                  <label class="form-label" for="basic-icon-default-email">Account Name</label>
                  <div class="input-group input-group-merge">
                    <span class="input-group-text"><i class="bx bx-user"></i></span>
                    <input
                      type="text"
                      name="account"
                      id="basic-icon-default-email"
                      class="form-control"
                      aria-describedby="basic-icon-default-email2"
                      value="{{$user->account_name}}"
                    />
                  </div>
                </div>

                <div class="col-sm-12 col-md-12 mb-3">
                  <label class="form-label" for="basic-icon-default-phone">Account Name</label>
                  <div class="input-group input-group-merge">
                    <span id="basic-icon-default-phone2" class="input-group-text"
                      ><i class="bx bx-user"></i
                    ></span>
                    <input
                      type="text"
                      name="account_name"
                      id="basic-icon-default-phone"
                      class="form-control phone-mask"
                      aria-describedby="basic-icon-default-phone2"
                      value="{{$user->account_name}}"
                    />
                  </div>
                </div>














                  

                  <input type="hidden" name="id" value="{{$user->id}}">
                  <input type="hidden" name="action" value="updatebank">
                <button id="submit" type="submit" class="btn btn-primary">Submit</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
@endsection

  