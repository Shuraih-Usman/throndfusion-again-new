<?php

namespace App\Http\Controllers\ModelController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AdminModel\Wallet;

class Wallets extends Controller
{
    //

    public function list($request) 
    {
        
        $draw = $request->input('draw');
        $start = $request->input('start');
        $length = $request->input('length');
        $searchValue = $request->input('search.value');
    
        $orderColumnIndex = $request->input('order.0.column');
        $orderDirection = $request->input('order.0.dir');
    
        $filterData = $request->input('filterdata');
    
        $query = Wallet::query()
        ->Join('users as u', 'w.user_id', 'u.id')
        ->where('w.type', 'widthrawal')
        ->where('w.status', 2)
        ->selectRaw('w.*, u.username, u.balance, u.bank_name, u.account_number, u.account_name')
        ->from('wallets as w');
        ;
    
    
        if ($filterData == 'Draft') {
            $query->where('w.status', 0);
        } elseif ($filterData == 'Actived') {
            $query->where('w.status', 1);
        }
    
        if (!empty($searchValue)) {
            $query->where('w.reference', 'LIKE', "%$searchValue%");
        }
    
        $columns = ['w.id', 'w.amount', 'w.reference', 'w.status', 'w.created_at'];
        $orderColumn = $columns[$orderColumnIndex] ?? $columns[0];
        $orderDirection = isset($orderDirection) ? $orderDirection : 'desc';
    
        $query->orderBy($orderColumn, $orderDirection);
    
        $totalRecords = Wallet::where('type', 'withdrawal')
        ->where('status', 2)
        ->count();

    
        $results = $query->skip($start)->take($length)->get();
        $totalFiltered = ($searchValue != '') ? $results->count() : $totalRecords;
    
        $data = [];
        foreach ($results as $row) {

            
            $status =  '<span class="badge bg-label-warning me-1">Pending</span>';

            

            $dropDown = '<div class="btn-group">
            <button type="button" class="btn btn-primary btn-icon rounded-pill dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bx bx-dots-vertical-rounded"></i>
          </button>
          <ul class="dropdown-menu dropdown-menu-end" style="">';
    
            if ($row->status != 1) {
                $dropDown .= '<li><a class="dropdown-item waves-effect waves-light activate" data-id="' . $row->id . '" href="#">Approve it</a></li>';
                $dropDown .= '<li><a class="dropdown-item waves-effect waves-light view-account" data-bank="' . $row->bank_name . '" data-account="' . $row->account_number . '" data-account_name="' . $row->account_name . '" href="#">Account Details</a></li>';
            } else {
                $dropDown .= '<li><a class="dropdown-item waves-effect waves-light text-warning draft" href="#" data-id="'.$row->id.'">Ignore</a></li>';
            }
    
            $dropDown .= '<a class="dropdown-item waves-effect waves-light text-info edit" href="/admin/edit-user/' . $row->id . '">Edit</a></li>
                <li><a data-id="' . $row->id . '" class="dropdown-item waves-effect waves-light text-danger delete " href="#">Delete</a></li>
            </ul>
        </div>';


    
            $rowData = [
               $row->id,
               CUR.$row->amount,
               $row->type,
               $row->username,
               CUR.$row->balance,
               $row->reference,
               $status,
               $dropDown,
               $row->created_at->format('d M, Y')
            ];
            $rowData = array_combine(range(0, count($rowData) - 1), array_values($rowData));
            $data[] = $rowData;
        }
    
        $response = [
            "draw" => (int)$draw,
            "recordsTotal" => (int)$totalRecords,
            "recordsFiltered" => (int)$totalFiltered,
            "columns" => 0, 
            "data" => $data
        ];
    
        return $response;
    }


    public function Transactions($request) 
    {
        
        $draw = $request->input('draw');
        $start = $request->input('start');
        $length = $request->input('length');
        $searchValue = $request->input('search.value');
    
        $orderColumnIndex = $request->input('order.0.column');
        $orderDirection = $request->input('order.0.dir');
    
        $filterData = $request->input('filterdata');
    
        $query = Wallet::query()
        ->Join('users as u', 'w.user_id', 'u.id')
        ->selectRaw('w.*, u.username, u.balance, u.bank_name, u.account_number, u.account_name')
        ->from('wallets as w');
        ;
    
    
        if ($filterData == 'Draft') {
            $query->where('w.status', 0);
        } elseif ($filterData == 'Actived') {
            $query->where('w.status', 1);
        }
    
        if (!empty($searchValue)) {
            $query->where('w.reference', 'LIKE', "%$searchValue%");
        }
    
        $columns = ['w.id', 'w.amount', 'w.reference', 'w.status', 'w.created_at'];
        $orderColumn = $columns[$orderColumnIndex] ?? $columns[0];
        $orderDirection = isset($orderDirection) ? $orderDirection : 'desc';
    
        $query->orderBy($orderColumn, $orderDirection);
    
        $totalRecords = Wallet::count();

    
        $results = $query->skip($start)->take($length)->get();
        $totalFiltered = ($searchValue != '') ? $results->count() : $totalRecords;
    
        $data = [];
        foreach ($results as $row) {

            
            $status =    ($row->status == 1) ? '<span class="badge bg-label-success me-1">Completed</span>' : ($row->status == 2 ?  '<span class="badge bg-label-warning me-1">Pending</span>' : '<span class="badge bg-label-danger me-1">Terminate</span>');

            

          


    
            $rowData = [
               $row->id,
               CUR.$row->amount,
               $row->type,
               $row->username,
               CUR.$row->balance,
               $row->reference,
               $status,
               $row->created_at->format('d M, Y')
            ];
            $rowData = array_combine(range(0, count($rowData) - 1), array_values($rowData));
            $data[] = $rowData;
        }
    
        $response = [
            "draw" => (int)$draw,
            "recordsTotal" => (int)$totalRecords,
            "recordsFiltered" => (int)$totalFiltered,
            "columns" => 0, 
            "data" => $data
        ];
    
        return $response;
    }



    public function toStatus($request) {
        $s = 0;
        $errors = [];
        $type = $request->type;
        $ids = $request->ids;
        $table = 'withdrawal';
        if (Admin('superAdmin') != 1) {
            $m = "Unauthorized action";
        } else {

            if(!$ids) {
                $m = "No item selected";
            } else if(!in_array($type, ['activateAll', 'draftAll', 'draft', 'activate', 'delete', 'deleteAll'])) {
                $m = "Invalid Action";
            } else {
                $total = 0;
    
                switch($type) {
                    case 'activateAll':
                        foreach($ids as $id) {
                            if(!$id) {
                                continue;
                            }
                          $user = Wallet::find($id);
                          $user->status = 1;
                          $user->save();
                          $total++;
                            
                        }
    
                        if($total > 0) {
                            $s = 1;
                            $m = "$total withdrawal where successfully Approved";
                        } else {
                            $m = "Failed to approve items";
                        }
                        break;
                    case 'draftAll':
                        foreach($ids as $id) {
                            if(!$id) {
                                continue;
                            }
                          $user = Wallet::find($id);
                          $user->status = 0;
                          $user->save();
                          $total++;
                            
                        }
    
                        if($total > 0) {
                            $s = 1;
                            $m = "$total $table where successfully Ignored";
                        } else {
                            $m = "Failed to Ignored items";
                        }
                        break;
                    case 'deleteAll':
                        foreach($ids as $id) {
                            if(!$id) {
                                continue;
                            }
                          $user = Wallet::find($id);
                          $user->delete();
                          $total++;
                            
                        }
    
                        if($total > 0) {
                            $s = 1;
                            $m = "$total $table where successfully Deleted";
                        } else {
                            $m = "Failed to delete items";
                        }
                        break;
                    case 'draft':
                        $user = Wallet::find($ids);
                        $user->status = 0;
                        $user->save();
                        $s = 1; 
                        $m = "Item was successfully ignored";
                        break;
                    case 'activate':
                        $user = Wallet::find($ids);
                        $user->status = 1;
                        $user->save();
                        $s = 1; 
                        $m = "withrawal was successfully approved";
                        break; 
                    case 'delete':
                        $user = Wallet::find($ids);
                        $s = 1; 
                        $m = "Item was successfully deleted";
                        break;
                    default:
                        $m = "Undefined action";
                        break;
                }
            }
        }

       
        
        return ['m' => $m, 's' => $s];
    }
}
