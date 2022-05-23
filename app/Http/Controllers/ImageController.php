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
        return view('images.create', compact('categories', 'tags'));
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
            'tags_ids.*'=> 'exists:tags,id'
          ]);
        
       
        $data = $request->all();
        $image = new Image();
        $image->proprietario = user_proprietario_id;
        if (array_key_exists('cover', $data)) {
            $cover = $data['cover'];
            $destination = 'immagini/thumb/';
            $filename = time() . '-' . $cover->getClientOriginalName();
            $upload = $cover->move($destination, $filename);
            $data['cover'] = $destination . $filename;
        }
        if (array_key_exists('tag_ids', $data)) {
            $image->tags()->attach($data['tag_ids']);
          }
       
        $users_list = DB::table('users')->get();
        $user_proprietario_id = Auth::user()->id;
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
        
        $image->users()->attach($visibility_users);
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
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function edit(Image $image)
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
        return redirect()->route('imagess.index');
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

}
