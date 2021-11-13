<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kategori;
use JWTAuth;

class KategoriController extends Controller
{
    public function __construct()
    {
        $this->user = JWTAuth::parseToken()->authenticate();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'data' => Kategori::select('id', 'nama_kategori')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nama_kategori' => 'required|string'
        ]);

        $data = new Kategori([
            'nama_kategori' => $request->nama_kategori
        ]);
        if ($data->save())
            return response()->json([
                'success' => true,
                'kategori' => $data
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'Sorry, product could not be added'
            ], 500);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $kategori = Kategori::select('*')->where('id', $id)->get();

        if (!$kategori) {
            return response()->json([
                'success' => false,
                'message' => 'maaf, kategori dengan id ' . $id . ' tidak ditemukan'
            ], 400);
        } else {
            return response()->json([
                'success' => true,
                'message' => $kategori
            ], 200);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $kategori = Kategori::where('id', $id)->first();
        if ($kategori) {
            $kategori->nama_kategori = $request->nama_kategori ? $request->nama_kategori : $kategori->nama_kategori;
            $kategori->save();
            return response()->json([
                'message' => "success update ",
                'data' => $kategori
            ]);
        } else {
            return response()->json([
                'message' => "failed update " . $id
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Kategori::destroy($id);
        return response()->json([
            'message' => 'data dengan id ' . $id . ' berhasil dihapus'
        ]);
    }
}
