<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use DB;

class AdminController extends Controller
{
    function addProduct(){
        echo "this is add product page";
    }

    function editProduct($masoSP=1){
        echo $masoSP;
    }

    function index(){
        //return view('welcome');
        // $array =[
        //     'title' => 'Home Page',
        //     'description' => 'this is home page of admin... '
        // ];
        //return view('home',$array);


        // return view('home',[
        //     'title' => 'Home Page',
        //     'description' => 'this is home page of admin... '
        // ]);

        $title = 'Home Page';
        $description = 'this is home page of admin....';

        return view('home',compact('title','description'));
    }

    function getDetailProduct($id, $alias){
        //return view('detail',compact('id','alias','array'));
        
        $array = [
            'PHP',
            'iOS',
            'Android',
            'Nodejs'  
        ];

        return view('detail',[
            'id' => $id,
            'alias' => $alias,
            'array' => $array
        ]);
    }

    function getRegister(){
        //return view('admin/register');
        return view('admin.register');
    }

    function postRegister(Request $req){
        //echo $fullname = $req->input('fullname');
        //echo $fullname = $req->fullname;
        // $input = $req->all();

        // dd($input);

        /**
         * fullname: required, min:6, max:50
         * email : required, đúng định dang
         * birthdate required, đúng định dang
         * age: required, phải nhập số
         * pw: required, min:6, ,max: 20
         * confirm_pw required, giống với pw
         */
        $arrV = [
            'fullname' => 'required|min:6|max:50',
            'email' => 'required|email',
            'age'=>'required|numeric',
            'birthdate'=> 'required|date',
            'password' => 'required|min:6|max:20',
            'confirm_password'=> 'required|same:password'
        ];

        $arrMess = [
            'fullname.required' => 'Họ tên ko được rỗng',
            'fullname.min' => 'Họ tên ít nhất :min ký tự'
        ];
        $validator = Validator::make($req->all(),$arrV,$arrMess);

        if($validator->fails())
            return redirect()->route('register')
                            ->withErrors($validator)
                            ->withInput();   
    
        /// luu db
    }

    function getFormUpload(){
        return view('admin.upload');
    }

    // function postFormUpload(Request $req){
    //     if($req->hasFile('image')){
    //         $file = $req->file('image');

    //         //kiem tra size < 1 Mb, type (png/jpg/doc), rename

    //         $size = $file->getSize();
    //         if($size > 1024*1024){
    //             echo 'File quá lớn';
    //             return;
    //         }
    //         $ext = $file->getClientOriginalExtension();
    //         $arrExt = ['doc','png','jpg'];
    //         if(!in_array($ext,$arrExt)){
    //             echo "File ko được phép chọn";
    //             return;
    //         }

    //         $newName = date('Y-m-d-H-i-m').'-'.$file->getClientOriginalName();
    //         $file->move('images',$newName);
    //         echo "Upload Thành công";
    //     }
    //     else{
    //         echo 'Vui lòng chọn file';
    //         return;
    //     }
    // }

    function postFormUpload(Request $req){
        if($req->hasFile('image')){
            $file = $req->file('image');
            //dd($file);

            $arrExt = ['doc','png','jpg'];
            foreach($file as $f){
                $size = $f->getSize();
                if($size > 1024*1024){
                    echo "File too large";
                    return;
                }

                $ext = $f->getClientOriginalExtension();
                if(!in_array($ext,$arrExt)){
                    echo "File ko được phép chọn";
                    return;
                }
            }
            foreach($file as $f){
                $newName = date('Y-m-d-H-i-m').'-'.$f->getClientOriginalName();
                $f->move('images',$newName);
            }
            echo "Upload success";

        }
        else{
            echo 'Vui lòng chọn file';
            return;
        }

    }

    function getDetail(){
        return view('pages.detail');
    }

    function getHome(){
        return view('pages.home');
    }

    //select * from foods
    function getProducts(){
        $data = DB::table('foods')->get();
        dd($data);
    }
}
