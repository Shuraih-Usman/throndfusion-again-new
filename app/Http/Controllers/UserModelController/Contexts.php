<?php

namespace App\Http\Controllers\UserModelController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\UserModel\Service;
use Illuminate\Support\Str;
use App\Helpers\ActivityLogHelper;
use Carbon\Carbon;
use App\Models\User;

class Contexts extends Controller
{
    //

    public function add(Request $request) {
        $s = 0;
    
            $validator = Validator::make($request->all(), [
                'title' => 'required|string',
                'image'=> 'required|image|mimes:jpg,jpeg,gif,png|max:2040',
                'category' => 'required',
                'first_reward' => 'required|numeric',
                'second_reward' => 'required|numeric',
                'third_reward' => 'required|numeric',
                'total_reward' => 'required|numeric',
                'finishing' => 'required|string',
                'description' => 'required|string',
            ]);
    
            if( $validator->fails() ) {
                $m = $validator->errors()->first();
            } else {
    
                $image = $request->file('image');
                $imageName = time() . '-' . rand(0, 9). '.' .$image->getClientOriginalExtension();
                $folder = 'images/contexts/' . date('y/m/');
                $subfolder = 'contexts/' . date('y/m/');

                while(file_exists($folder . $imageName)) {
                    $imageName = time() .'-'. rand(0, 9) . '.' .$image->getClientOriginalExtension();
                }

                $image->move(public_path($folder), $imageName);

                try {
                    DB::beginTransaction();

                    $campaign = new Service();
                    $campaign->title = $request->input('title');
                    $campaign->service_cat_id = $request->input('category');
                    $campaign->image = $imageName;
                    $campaign->img_folder = $subfolder;
                    $campaign->description = $request->input('description');
                    $campaign->user_id = Admin('id');
                    $campaign->status = 1;
                    $campaign->price =  $request->input('price');
                    $campaign->delivery_day = $request->input('delivery'); 
                    $campaign->save();
                    DB::commit();
                    $s = 1;
                    $m = "You successfully submitted a Service.";
                    ActivityLogHelper::log('Services', Admin('id'), $m);
                } catch (\Exception $e) {
                    DB::rollBack();
                    $m = "An error occurred while submitting. Please contact admins.";
                    Log::error($e->getMessage());
                }
    
            }
    
        
    
        return ['m' => $m, 's' => $s];
    }
    

    public function list($request) 
    {
        
        $draw = $request->input('draw');
        $start = $request->input('start');
        $length = $request->input('length');
        $searchValue = $request->input('search.value');
    
        $orderColumnIndex = $request->input('order.0.column');
        $orderDirection = $request->input('order.0.dir');
    
        $filterData = $request->input('filterdata');
    
        $query = Service::query();

  $query->join('service_cats as c', 'services.service_cat_id', '=', 'c.id')
        ->where('services.user_id', Admin('id'))
         ->select('services.*',  'c.title as category_title');

    
        if ($filterData == 'Closed') {
            $query->where('services.status', 0);
        } elseif ($filterData == 'Actived') {
            $query->where('services.status', 1);
        }
    
        if (!empty($searchValue)) {
            $query->where('services.title', 'LIKE', "%$searchValue%");
        }
    
        $columns = ['services.id', 'services.title', 'services.status', 'services.created_at'];
        $orderColumn = $columns[$orderColumnIndex] ?? $columns[0];
        $orderDirection = isset($orderDirection) ? $orderDirection : 'desc';
    
        $query->orderBy($orderColumn, $orderDirection);
    
        $totalRecords = Service::count();
    
        $results = $query->skip($start)->take($length)->get();
        $totalFiltered = ($searchValue != '') ? $results->count() : $totalRecords;
    
        $data = [];
        foreach ($results as $row) {

            $image = '<img src="/images/'.$row->img_folder.$row->image.'" class="thumbnail" width="60" height="60"/>';
            $status = $row->status == 1 ? '<span class="badge bg-label-primary me-1">Active</span>' : '<span class="badge bg-label-warning me-1">Inactive</span>';

            

            $dropDown = '<div class="btn-group">
            <button type="button" class="btn btn-primary btn-icon rounded-pill dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bx bx-dots-vertical-rounded"></i>
          </button>
          <ul class="dropdown-menu dropdown-menu-end" style="">';
    
            if ($row->status != 1) {
                $dropDown .= '<li><a class="dropdown-item waves-effect waves-light activate" data-id="' . $row->id . '" href="#">Activate</a></li>';
            } else {
                $dropDown .= '<li><a class="dropdown-item waves-effect waves-light text-warning draft" href="#" data-id="'.$row->id.'">Draft</a></li>';
            }
    
            $dropDown .= '<a class="dropdown-item waves-effect waves-light text-info edit" href="#" data-id="' . $row->id . '">Edit</a></li>
                <li><a data-id="' . $row->id . '" class="dropdown-item waves-effect waves-light text-danger delete " href="#">Delete</a></li>
            </ul>
        </div>';
    
            $rowData = [
               $row->id,
               $image,
               '<a href="javascript:void(0);" class="view" data-id="'.$row->id.'" data-name="'.$row->title.'" data-price="'.$row->price.'" data-delivery="'.$row->delivery_day.'" data-status="'.$row->status.'" data-image="'.$row->image.'" data-folder="'.$row->img_folder.'" data-cat="'.$row->category_title.'" data-desc="'.$row->description.'">'.$row->title .'</a>',
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



    public function toStatus($request) {
        $s = 0;
        $errors = [];
        $type = $request->type;
        $ids = $request->ids;
        $table = 'Service';

            if(!$ids) {
                $m = "No item selected";
            } else if(!in_array($type, ['activateAll', 'closeAll', 'close', 'activate', 'delete', 'deleteAll'])) {
                $m = "Invalid Action";
            } else {
                $total = 0;
    
                switch($type) {
                    case 'activateAll':
                        foreach($ids as $id) {
                            if(!$id) {
                                continue;
                            }
                          $user = Service::find($id);
                          $user->status = 1;
                          $user->save();
                          $total++;
                            
                        }
    
                        if($total > 0) {
                            $s = 1;
                            $m = "$total $table where successfully Activated";
                            ActivityLogHelper::log($table, Admin('id'), $m);
                        } else {
                            $m = "Failed to activate items";
                        }
                        break;
                    case 'closeAll':
                        foreach($ids as $id) {
                            if(!$id) {
                                continue;
                            }
                          $user = Service::find($id);
                          $user->status = 0;
                          $user->save();
                          $total++;
                            
                        }
    
                        if($total > 0) {
                            $s = 1;
                            $m = "$total $table where successfully Close";
                            ActivityLogHelper::log($table, Admin('id'), $m);
                        } else {
                            $m = "Failed to close items";
                        }
                        break;
                    case 'close':
                        $user = Service::find($ids);
                        $user->status = 0;
                        $user->save();
                        $s = 1; 
                        $m = "Item was successfully updated";
                        ActivityLogHelper::log($table, Admin('id'), $m);
                        break;
                    case 'activate':
                        $user = Service::find($ids);
                        $user->status = 1;
                        $user->save();
                        $s = 1; 
                        $m = "Item was successfully updated";
                        ActivityLogHelper::log($table, Admin('id'), $m);
                        break;
                     case 'delete':
                        $user = Service::find($ids);
                        $image = public_path('/images/'.$user->img_folder.$user->image);
                        unlink($image);
                        $user->delete();
                        $s = 1; 
                        $m = "Item was deleted successfully";
                        ActivityLogHelper::log($table, Admin('id'), $m);
                        break;                   
                    default:
                        $m = "Undefined action";
                        break;
                }
            }
        

       
        
        return ['m' => $m, 's' => $s];
    }
}
