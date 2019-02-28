<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use App\Http\Controllers\Admin\MainAdminController;
use App\Models\Admin;
use App\Models\Admin_group;
use App\Models\Sessions;
use Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

class AdminController extends MainAdminController
{	
	protected $model;
	protected $view_folder = 'admin/user/';
	protected $rules = [
        'insert' => [
            'email'      => 'required|email',
            'first_name' => 'required',
            'last_name'  => 'required',
            'gad_id'     => 'required|exists:admin_group,id',
            'password'   => 'required|min:6'
        ],
        'update' => [
            'email'      => 'required|email',
            'first_name' => 'required',
            'last_name'  => 'required',
            'gad_id'     => 'required|exists:admin_group,id',
        ],
	];
    protected $columns_filter = [
        'id'         =>    'admin.id',            
        'gad_id'     =>    'admin.gad_id',            
        'first_name' =>    'admin.first_name',
        'last_name'  =>    'admin.last_name',
        'email'      =>    'admin.email',
        'status'     =>    'admin.status',
        'created_at' =>    'admin.created_at',
        'updated_at' =>    'admin.updated_at',
    ];
    protected $columns_search = [];

	public function __construct(Request $request) {
		$this->model = new Admin;
		parent::__construct($request);
	}

	public function setItem($type , $req , &$item){
        $validator = Validator::make($req->all(), $this->rules[$type]);
        if ($validator->fails()) {

            return [
                'type' => 'error',
                'msg'  => 'Vui lòng kiểm tra lại các trường nhập'
            ];
        }
        switch ($type) {
            case 'insert':
                //check if email is exists
                $user = $this->model::where(['email' => $req->email])->first();
                if($user){
                    return [
                        'type' => 'error',
                        'msg'  => 'Email đã tồn tại. Vui lòng sử dụng email khác'
                    ];
                }
                //encode password
                $item->password = encode_password($req->password);
                break;
            case 'update':
                //check if email is exists
                if($req->email !== $item->email){
                    $user = $this->model::where(['email' => $req->email])->first();
                    if($user){
                        return [
                            'type' => 'error',
                            'msg'  => 'Email đã tồn tại'
                        ];
                    }
                }                
            
            default:
                break;
        }
        $item->email      = $req->email;
        $item->first_name = $req->first_name;
        $item->last_name  = $req->last_name;
        $item->gad_id     = (int)$req->gad_id;        
        $item->status     = (int)$req->get('status',$this->status); 
        $item->settings   = '';

        return ['type' => 'success'];

    }

    /*
     * Create new resource item.
     */

    // public function store(Request $request) {

    //     if($request->isMethod('post')){
    //         $item = $this->model;
    //         $message = $this->setItem('insert',$request, $item);
    //         if($message['type'] == 'success'){
    //             if($item->save()){
    //                 $message['msg'] = 'Thêm dữ liệu thành công';
    //             } else {
    //                 $message['msg'] = 'Thêm dữ liệu thất bại';
    //             }

    //         }
    //     } else {
    //         $message = '';
    //     }
    //     $data['more'] = $this->getDataNeed();
    //     return $this->template($this->view_folder."add",$data,$message);
    // }


    /*
     * Show detail item that belongs to passed id.
     */
    // public function detail(Request $request,$id)
    // {
    //     //check if item exists
    //     $item = $this->model::find($id);
    //     if(empty($item)){
    //         return abort(404);
    //     }
    //     if($request->isMethod('post')){
    //         $result = $this->setItem('update',$request, $item);
    //         if($result['type'] == 'success'){
    //             $item->save();   
    //             $result['msg'] = 'Cập nhật dữ liệu thành công';         
    //         }
    //     } else {
    //         $result = "";
    //     }
    //     $data['info'] = $item;    
    //     $data['more'] = $this->getDataNeed();

    //     return $this->template($this->view_folder."detail",$data,$result);
    // }


    public function login(Request $request)
    {
        if($request->session()->has('user')){
            return redirect('/admin');
        }
    	return $this->template($this->view_folder."login");
    }

    public function doLogin(Request $request)
    {
    	if($request->session()->has('user')){
            return redirect('/admin');
        }
    	$email = $request->email;
    	$password = $request->password;
    	if(empty($email) || empty($password)){
    		return view($this->view_folder.'login')
    			->withMessage(['type' => 'error' , 'msg' => 'Email và mật khẩu không được để trống']);
    	} else {
    		$result = Admin::where([                
                'email' => $email , 
                'password' => encode_password($request->password)
            ])->first();

    		if(empty($result)){
    			return view($this->view_folder.'login')
    			->withMessage(['type' => 'error' , 'msg' => 'Email hoặc mật khẩu chưa chính xác']);
    		} else if($result->status !== 1){
                return view($this->view_folder.'login')
                ->withMessage(['type' => 'error' , 'msg' => 'Tài khoản của bạn đã bị vô hiệu hóa. Vui lòng liên hệ với quản trị viên.']);
            } else {

                $admin_model = new Admin();
                $per_user = $admin_model->get_permission_user($result->gad_id);                
                if($per_user){
                    $request->session()->put('permission', $per_user);
                }
                
    			$request->session()->put('user', $result);
                $session_id = session()->getId();
                if($session_id){
                    $session = new Sessions();
                    $session = $session->where('id' ,$session_id)->first();
                    
                    if($session){
                        $session->user_id = $result->id;
                        $session->ip_address = getRealUserIp();
                        $session->user_agent = $request->header('User-Agent');
                        $session->save();
                    }
                }
    			return redirect()->back();
    		}
    	}
    }

    public function changepass(Request $request)
    {
        $password_current = $request->password_old;
        $password_new = $request->password_new;
        $user = $this->model::find($request->authUser->id);
        if(empty($password_current) || empty($password_new) ) {
            $message = [
                'type' => 'error' , 
                'msg' => 'Mật khẩu hiện tại và mật khẩu mới không được để trống'
            ];
              
        } else if(strlen($password_new) < 6){
            $message = [
                'type' => 'error' , 
                'msg' => 'Mật khẩu phải trên 6 kí tự'
            ];

        } else if($user->password !== encode_password($password_current)) {
            $message = [
                'type' => 'error' , 
                'msg' => 'Mật khẩu hiện tại chưa chính xác'
            ];
        } else {
            $user->password = encode_password($password_current);

            if($user->save()){
                $message = [
                    'type' => 'success' , 
                    'msg' => 'Cập nhật mật khẩu thành công'
                ];
            } else {
                $message = [
                    'type' => 'error' , 
                    'msg' => 'Có lỗi! Cập nhật mật khẩu không thành công'
                ];
            }
            
        }
        return Redirect::back()
                ->withMessage($message);
    }

    public function forgot(Request $request)
    {
        return $this->template($this->view_folder.'forgot');
    }

    public function doForgot(Request $request)
    {
        $validator = Validator::make($request->all(), ['email' => 'required|email']);
        if ($validator->fails()) {
            
            $message = [
                'type' => 'error',
                'msg'  => 'Email không hợp lệ'
            ];
            return $this->template($this->view_folder.'forgot','',$message);
        } else {
            $user = $this->model->getByEmail($request->email);
            
            if(empty($user)){
                $message = [
                    'type' => 'error',
                    'msg'  => 'Email không tồn tại. Vui lòng kiểm tra và thử lại.'
                ];
                return view($this->view_folder."forgot")
                    ->withMessage($message);
                
            } else {
                $message = [
                    'type' => 'success',
                    'msg'  => 'Một đường link lấy lại mật khẩu đã được gửi tới email của bạn. Vui lòng kiểm tra email và làm theo hướng dẫn'
                ];
                $data = ['requestCode' => true];
                return $this->template($this->view_folder.'forgot',$data,$message);
            }

            

        }
    }

    public function lockuser(Request $request,$id)
    {
        $user = $this->model->find($id);
        if(empty($user)){
            abort(404);
        }
        if((int)$request->authUser->id === (int)$id){
            return Redirect("/admin/user/detail/$id")
                ->withMessage(['type' => 'error','msg' => 'Không thể khóa tài khoản này']);
        }
        
        $user->status = 0;
        $user->save();
        Sessions::where('user_id',$id)->delete();
        return Redirect("/admin/user/detail/$id")
                ->withMessage(['type' => 'success','msg' => 'Khóa tài khoản thành công']);

    }
    public function unlockuser(Request $request,$id)
    {
        $user = $this->model->find($id);
        if(empty($user)){
            abort(404);
        }
        $user->status = 1;
        $user->save();
        return redirect("/admin/user/detail/$id")
                ->withMessage(['type' => 'success','msg' => 'Mở khóa tài khoản thành công']);
    }
    public function logout(Request $request)
    {
        if(session()->has('user')){
            session()->flush();
        }
        return redirect('/admin/login');
    }

    public function delete(Request $request, $id) {
        return abort('404');
    }

    protected function getDataNeed(){
        $ad_group_model = new Admin_group();
        $data = $ad_group_model->getall();
        return $data;
    }
}
