<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Tag;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      
       $images= DB::table('images')
        ->join('image_user', 'images.id', '=', 'image_user.image_id')
        ->join('users', 'image_user.user_id', '=', 'users.id')
        ->select('*')
        ->where('user_id', '=',  Auth::user()->id)
        ->get();
        
        return view('images.index', compact('images'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags = Tag ::all();
        return view('images.create', compact('tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'cover' => 'required|image|max:60000', 
            'tag_ids.*'=> 'exists:tags,id'
          ]);
        
       
        $data = $request->all();
        $user_proprietario_id = Auth::user()->id;
        $image = new Image();
        $image->proprietario = $user_proprietario_id;
        if (array_key_exists('cover', $data)) {
            $cover = $data['cover'];
            $destination = 'immagini/thumb/';
            $filename = time() . '-' . $cover->getClientOriginalName();
            $upload = $cover->move($destination, $filename);
            $data['cover'] = $destination . $filename;
        }
       
        $users_list = DB::table('users')->get();
        $visibility_users = array();
        $n_utenti = count($users_list);
        $j = 0;
        $count = 0;
        while ($j < 3 and $count < $n_utenti-1){
            $n_random = rand(1, $n_utenti);
            if($n_random != $image->proprietario){
            if(in_array($n_random, $visibility_users)){
                continue;
            }else{
                array_push($visibility_users, $n_random);
                $j++;
            }
            $count++;
        }
        }  
        
        $image->no_visibility_list = json_encode($visibility_users);
        
        $image->fill($data);
        
        $image->save();
        

        // if (array_key_exists('users_ids', $data)) {
        //     $image->users()->attach($data['users_ids']);
        // }
        if (array_key_exists('tag_ids', $data)) {
            $image->tags()->attach($data['tag_ids']);
          }
        $image->users()->attach($visibility_users);
        // DB::table('user')->updateimgnum($user_proprietario_id);
        app('App\Http\Controllers\UserController')->updateimgnum($user_proprietario_id);
        return redirect()->route('images.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function show(Image $image)
    {
        $tags = Tag::all();

        return view('images.show',compact('image','tags'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    private function edit(Image $image)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Image $image)
    {
        $request->validate([
            'cover' => 'required|image|max:60000',
            'tags_ids.*'=> 'exists:tags,id'
          ]);
  
            $data = $request->all();
          

            if (array_key_exists('cover', $image)) {
              $cover = Storage::put('uploads', $image['cover']);
              $image['cover'] = $image;
            }
            if (array_key_exists('tag_ids', $data)) {
                $image->tags()->sync($data['tag_ids']);
              } else {
                $post->tags()->detach();
                $image->update($data);
              }
            if(array_key_exists('no_visibility_list', $image)){
              $image->services()->sync($data['service_ids']);
          } else {
              $image->services()->detach();
          }
            return redirect()->route('images.index', compact('image'));
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function destroy(Image $image)
    {
        $image->delete();
        return redirect()->route('images.index');
    }
    public function share(Request $request, Image $image)
    {
        $data = $request->all();
        $users_list = DB::table('users')->get();
        $visibility_users = array();
        $n_utenti = count($users_list);
        $j = 0;
        $count = 0;
        $list = json_decode($image['no_visibility_list']);
       
        foreach ($list as $user_no_visible){
            array_push($visibility_users, $user_no_visible);
        }
        // $image->users()->detach($visibility_users);
        while ($j < 3 and $count < $n_utenti-1){
            $n_random = rand(1, $n_utenti);
            if($n_random != $image->proprietario){
            if(in_array($n_random, $visibility_users)){
                continue;
            }else{
                array_push($visibility_users, $n_random);
                $j++;
            }
        }
        $count++;
        }  
        
       
        $image->update([
            "image_id" => $image['image_id'],
            "cover" => $image['cover'],
            "no_visibility_list" => $image['no_visibility_list']
        ]);

        $image->users()->sync($visibility_users);

        return redirect()->route('images.index');
    }

    public function ordenar(){
        $immagini= DB::table('images')
        ->join('image_user', 'images.id', '=', 'image_user.image_id')
        ->join('users', 'image_user.user_id', '=', 'users.id')
        ->select('*')
        ->where('user_id', '=',  Auth::user()->id)
        ->get();

        $i =  0;
        $image_date = array();
        $image_list = array();
        foreach ($immagini as $image){
            array_push($image_list, $image);
        }
        foreach ($immagini as $image){
            array_push($image_date, $image->created_at);
        }
        sort($image_date, SORT_STRING);
        $images=array();
        for($j=0; $j<count($image_date); $j++){
            for($k = 0; $k<count($image_date); $k++) {
                if(strtotime($image_date[$j]) == strtotime($image_list[$k]->created_at)){
                    if (in_array($image_list[$k], $images)){

                    }else{
                        array_push($images, $image_list[$k]);
                    }
                   

                }
            }
            
        } 
        return view('images.index', compact('images'));
    }
    public function searchperhashtag(Request $request,Tag $tag){
        $request->validate([
            'tag' => 'required|string',
          ]);
        $immagini= DB::table('images')
        ->join('image_user', 'images.id', '=', 'image_user.image_id')
        ->join('users', 'image_user.user_id', '=', 'users.id')
        ->select('*')
        ->where('user_id', '=',  Auth::user()->id)
        ->join('image_tag', 'images.id', '=', 'image_tag.image_id')
        ->get();
        $images_ids = array();
        foreach ($immagini as $image){
            array_push($images_ids, $image->image_id);           
        }
        $imageslist= array();
        foreach ($images_ids as $image){
            if (in_array($image, $imageslist)){

            }else{
                array_push($imageslist, $image);
            }           
        }
        $images = $this->searchimage($imageslist);

        

        return view('images.index', compact('images'));
    }

    private function searchimage($images){
        $immagini = DB::table('images')
        ->join('image_user', 'images.id', '=', 'image_user.image_id')
        ->join('users', 'image_user.user_id', '=', 'users.id')
        ->select('*')
        ->where('user_id', '=',  Auth::user()->id)
        ->get();
        $images_list = array();
        foreach ($immagini as $image){
            foreach ($images as $id){
                if($image->image_id == $id){
                    array_push($images_list, $image);
                }
            }           
        }        
        return $images_list;
    }
}
