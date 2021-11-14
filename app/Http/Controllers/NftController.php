<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Nft;
use App\Models\Collection;
use App\Models\Comment;

use Illuminate\Support\Facades\Http;

use Illuminate\Support\Facades\Auth;




class NftController extends Controller
{

        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function profilepage(){
        $nfts = Nft::get();
        $data['nfts'] = $nfts;
        return view('profile', $data);
    }

    public function index(){
        
        $nfts = Nft::get();

        $user = Auth::id();
       // $nfts = \DB::table("nfts")->get();
        $data["nfts"] = $nfts;
        $data['user'] = $user;
        



         return view('nft/index', $data);
    }

    // nfts in homepage
    public function homepage(){
        $nfts = Nft::get();
        $collections = Collection::get();
        $user = Auth::user();
        $data["nfts"] = $nfts;
        $data["user"] = $user;
        $data["collections"] = $collections;

        // if(!empty($user)){
            return view('homepage', $data);
        // }else{
        //     return view('login');
        // }

         
    }

    // detail page from the homepage
    public function showAllNfts($id){
        $user = Auth::user();
        $userId = $user["id"];
        $nft = Nft::where('id', $id)->with('Comment')->first();
        $comments = Comment::with('Nft', 'User')->get();
        $data['user'] = $user;
        $data['nft'] = $nft;
        // dd($nft);
        // dd($user->lastname);
        return view('nft/showAllNfts', $data);
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Nft::find($id);
        $data->delete();
        return redirect('/wallet');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create(){
        $data['user'] = Auth::user();
        $collections = Collection::get();
       // $collections = \DB::table("collections")->get();
        $data['collections'] = $collections;
        return view('nft/addNft', $data);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){

        
        
        $uploadedFileUrl = \Cloudinary::upload($request->file('nftImage')->getRealPath())->getSecurePath();
      
       
        $nft = new Nft();
        $nft->creator_id = $request->input('creator');
        $nft->owner_id = $request->input('creator');
        $nft->title = $request->input('nftTitle');
        $nft->description = $request->input('nftDescription');
        $nft->area = $request->input('nftArea');
        $nft->object_type = $request->input('nftObjectType');
        $nft->image_file_path = $uploadedFileUrl;
        $nft->collection_id = $request->input('collectionsId');
        $nft->save();
        return redirect('./nft');
    }

        /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       
        $data['user'] = Auth::user();
        $nft = Nft::find($id);
        $data['nft'] = $nft;
        return view('nft/editNft', $data);

    }

            /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        
        $uploadedFileUrl = \Cloudinary::upload($request->file('nftImage')->getRealPath())->getSecurePath();

        $nft = Nft::find($request->id);
        $nft->title = $request->input('nftTitle');
        $nft->description = $request->input('nftDescription');
        $nft->image_file_path = $uploadedFileUrl;
        $nft->save();
        return redirect('./wallet');
    }

    public function buyNft($id){
        $user = Auth::id();
        $nft = Nft::find($id);
        $data["nft"] = $nft;
        $data["user"] = $user;
        return view('nft/buyNft', $data );
    }

    public function Order(Request $request){
        //order toevoegen
        $order = new \App\Models\Order();
        $order->nft_id = $request->input('id');
        $order->price = $request->input('price');
        $order->seller_id = $request->input('seller');
        $order->buyer_id = $request->input('buyer');
        $order->save();
        

        //nft updaten
        $nft = Nft::find($request->input('id'));
        $nft->owner_id = $request->input('buyer');
        $nft->forSale = 0;
        $nft->save();

        return redirect('./nft');

    }

    public function sell($id){
        $nft = Nft::find($id);
        $data["nft"] = $nft;
        return view("nft/sellNft", $data);
    }

    public function markForSale(Request $request){
        $nft = Nft::find($request->input('id'));
        if($nft->owner_id === Auth::id()){
            $nft->forSale = 1;
            $nft->price = $request->input('price');
            $nft->save();
            return redirect('./nft');
        }
    }


    public function filter(Request $request){
        $filter = $request->input('filter');
        $option = $request->input('option');
        $user = Auth::user();
        $data["filter"] = $filter;
        $data["user"] = $user;
        $data["option"] = $option;

        if($filter == 'Price'){
            if($option == 'PriceLH'){
                $nfts = Nft::select('id','price', 'title', 'image_file_path','forSale', 'owner_id')->orderBy('price')->get();
                $data["nfts"] = $nfts;
                return view("/homepageFilter", $data);
            }else{
                $nfts = Nft::select('id','price', 'title', 'image_file_path','forSale', 'owner_id')->orderBy('price', 'desc')->get();
                $data["nfts"] = $nfts;
                return view("/homepageFilter", $data);
            }
        }else if($filter == 'Area'){
            if($option == 'AreaLH'){
                $nfts = Nft::select('id','area', 'title', 'image_file_path','forSale', 'owner_id')->orderBy('area')->get();
                $data["nfts"] = $nfts;
                return view("/homepageFilter", $data);
            }else{
                $nfts = Nft::select('id','area', 'title', 'image_file_path','forSale', 'owner_id')->orderBy('area', 'desc')->get();
                $data["nfts"] = $nfts;
                return view("/homepageFilter", $data);
            }
        }
        else{
            if($option == 'TypeAZ'){
                $nfts = Nft::select('id','object_type', 'title', 'image_file_path','forSale', 'owner_id')->orderBy('object_type')->get();
                $data["nfts"] = $nfts;
                return view("/homepageFilter", $data);
            }else{
                $nfts = Nft::select('id','object_type', 'title', 'image_file_path','forSale', 'owner_id')->orderBy('object_type', 'desc')->get();
                $data["nfts"] = $nfts;
                return view("/homepageFilter", $data);
            }
            
        }
    }

  

}
