<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kategori;
use App\Barang;
use JWTAuth;
use DB;

class BarangController extends Controller
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
        $data = DB::table('tbl_barang')
            ->leftjoin('tbl_kategori', 'tbl_kategori.id', '=', 'tbl_barang.nama_kategori')
            ->select('tbl_barang.*', 'tbl_kategori.nama_kategori')->get();
        return response()->json([
            'data' => $data
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
            'nama_barang' => 'required|string',
            'nama_kategori' => 'required|string',
            'price' => 'required|numeric'
        ]);

        $data = new Barang([
            'nama_barang' => $request->nama_barang,
            'nama_kategori' => $request->nama_kategori,
            'price' => $request->price,
        ]);
        if ($data->save())
            return response()->json([
                'success' => true,
                'barang' => $data
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
        $barang = DB::table('tbl_barang')
            ->leftjoin('tbl_kategori', 'tbl_kategori.id', '=', 'tbl_barang.nama_kategori')
            ->select('tbl_barang.*', 'tbl_kategori.nama_kategori')
            ->where('tbl_barang.id', $id)->get();
        if (!$barang) {
            return response()->json([
                'success' => false,
                'message' => 'maaf, barang dengan id ' . $id . ' tidak ditemukan'
            ], 400);
        } else {
            return response()->json([
                'success' => true,
                'message' => $barang
            ], 200);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $barang = Barang::where('id', $id)->first();
        if ($barang) {
            $barang->nama_barang = $request->nama_barang ? $request->nama_barang : $barang->nama_barang;
            $barang->nama_kategori = $request->nama_kategori ? $request->nama_kategori : $barang->nama_kategori;
            $barang->price = $request->price ? $request->price : $barang->price;
            $barang->save();
            return response()->json([
                'message' => "success update ",
                'data' => $barang
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
        Barang::destroy($id);
        return response()->json([
            'message' => 'data dengan id ' . $id . ' berhasil dihapus'
        ]);
    }
}
