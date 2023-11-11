<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Validator;
use Carbon\Carbon;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Exception;

class BlogController extends Controller
{
    public function AuthAdmin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('/admin-dashboard');
        }else{
            abort(404);
        }
    }
    public function index(){
        $get_blog = DB::table('tbl_blog')->paginate(6);
        return view("pages.blog", ['get_blog'=>$get_blog]);
    }

    public function showBlog($id_blog){
        $show_blog = DB::table('tbl_blog')->where('id_blog',$id_blog)->first();
        $get_blog_list = DB::table('tbl_blog')->limit(4)->orderBy('id_blog', 'desc')->get();
        return view("pages.showblog", ['blog'=>$show_blog, 'get_blog_list'=>$get_blog_list]);
    }

    public function addBlog(){
        $this->AuthAdmin();
        return view('admin.pages.addblog');
    }

    public function addBlogProcess(Request $request){
        $this->AuthAdmin();
        $messages = [
            'title.required'=>'Bạn chưa có điền tiêu đề!',
            'content.required'=>'Bạn chưa nhập nội dung!',
            'end.required'=>'Bạn chưa nhập phần kết',
            'image1.required'=>'Bạn chưa chọn ảnh minh họa ',
            'image1.image'=>'File ảnh không hợp lệ!',
            'image1.max'=>'Ảnh dung lượng quá lớn!',
            'image2.required'=>'Bạn chưa chọn ảnh thân nội dung',
            'image2.image'=>'File ảnh không hợp lệ!',
            'image2.max'=>'Ảnh dung lượng quá lớn!',
        ];
        $request->validate([
            'title'=> 'required',
            'content'=> 'required',
            'end'=> 'required',
            'image1'=> 'required|image|max:5000',
            'image2'=> 'required|image|max:5000',
        ], $messages);
        
        $image1 = $request->image1;
        $image2 = $request->image2;

        $cloudinaryUpload1 = Cloudinary::upload($image1->getRealPath());
        $imageUrl1 = $cloudinaryUpload1->getSecurePath();
        $publicId1 = $cloudinaryUpload1->getPublicId();
       
        
        $cloudinaryUpload2 = Cloudinary::upload($image2->getRealPath());
        $imageUrl2 = $cloudinaryUpload1->getSecurePath();
        $publicId2 = $cloudinaryUpload2->getPublicId();
        
        

        $insert = DB::table('tbl_blog')->insert([
            'blog_title'=> $request->title,
            'blog_content'=> $request->content,
            'blog_end'=> $request->end,
            'blog_image1'=> $imageUrl1,
            'public_id1'=> $publicId1,
            'blog_image2'=> $imageUrl2,
            'public_id2'=> $publicId2,
            'created_at'=>now(),
            'updated_at'=> now(),
        ]);

        if($insert){
            return Redirect::to('/add-blog')->with('success','Thêm thành công!');
        }else{
            return Redirect::to('/add-blog')->with('error','Có lỗi xảy ra!');
        }
    }

    public function listBlog(){
        $get_blog = DB::table('tbl_blog')->get();
        return view('admin.pages.listblog', ['list_blog'=> $get_blog]);
    }

    public function editBlog($id_blog){
        $get_blog = DB::table('tbl_blog')->where('id_blog', $id_blog)->first();
        return view('admin.pages.editblog', ['blog'=> $get_blog]);
    }
    
    public function editBlogProcess($id_blog, Request $request){
        $this->AuthAdmin();
        $messages = [
            'title.required'=>'Bạn chưa có điền tiêu đề!',
            'content.required'=>'Bạn chưa nhập nội dung!',
            'end.required'=>'Bạn chưa nhập phần kết',
            'image1.image'=>'File ảnh không hợp lệ!',
            'image1.max'=>'Ảnh dung lượng quá lớn!',
            'image2.image'=>'File ảnh không hợp lệ!',
            'image2.max'=>'Ảnh dung lượng quá lớn!',
        ];
        $request->validate([
            'title'=> 'required',
            'content'=> 'required',
            'end'=> 'required',
            'image1'=> 'image|max:5000',
            'image2'=> 'image|max:5000',
        ], $messages);
        
        $get_blog = DB::table('tbl_blog')->where('id_blog', $id_blog)->first();

        $data = [
            'blog_title'=> $request->title,
            'blog_content'=> $request->content,
            'blog_end'=> $request->end,
            'blog_image1'=> $get_blog->blog_image1,
            'public_id1'=> $get_blog->public_id1,
            'blog_image2'=> $get_blog->blog_image2,
            'public_id2'=> $get_blog->public_id2,
            'updated_at'=> now(),
        ];

        //print_r($data);

        if(isset($request->image1)){
            $image1 = $request->image1;
            echo 'có ảnh 1</br>';
            Cloudinary::destroy($get_blog->public_id1);
            $cloudinaryUpload1 = Cloudinary::upload($image1->getRealPath());
            $imageUrl1 = $cloudinaryUpload1->getSecurePath();
            $publicId1 = $cloudinaryUpload1->getPublicId();
            $data['blog_image1'] = $imageUrl1;
            $data['public_id1'] = $publicId1;
        }

        if(isset($request->image2)){
            $image2 = $request->image2;
            echo 'có ảnh 2</br>';
            Cloudinary::destroy($get_blog->public_id2);
            $cloudinaryUpload2 = Cloudinary::upload($image2->getRealPath());
            $imageUrl2 = $cloudinaryUpload2->getSecurePath();
            $publicId2 = $cloudinaryUpload2->getPublicId();
            $data['blog_image2'] = $imageUrl2;
            $data['public_id2'] = $publicId2;
        }
        
        $update = DB::table('tbl_blog')->where('id_blog', $id_blog)->update($data);
        if($update){
            return redirect('/list-blog')->with('success','Thay đổi thành công!');
        }
    }

    public function destroy($id_blog){
        $this->AuthAdmin();
        $get_blog = DB::table('tbl_blog')->where('id_blog', $id_blog)->first();
        DB::beginTransaction();
        try{
            Cloudinary::destroy($get_blog->public_id1);
            Cloudinary::destroy($get_blog->public_id2);
            $delete = DB::table('tbl_blog')->where('id_blog',$id_blog)->delete();
            DB::commit();
            return redirect('/list-blog')->with('success','Xóa thành công!');
        }catch(Exception $e){
            DB::rollBack();
            return redirect('/list-blog')->with('error','Đã có lỗi xảy ra!');
        }
        
    }
}
