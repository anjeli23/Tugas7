<?php

namespace App\Http\Controllers;

use App\Models\Produk;

class ProdukController extends Controller
{
    function index()
    {
        $user = request()->user();
        $data['list_produk'] = $user->produk;
        return view('produk.index', $data);
    }
    function create()
    {
        return view('produk.create');
    }
    function store()
    {
        $produk = new Produk;
        $produk->id_user = request()->user()->id;
        $produk->nama = request('nama');
        $produk->stok = request('stok');
        $produk->harga = request('harga');
        $produk->berat = request('berat');
        $produk->deskripsi = request('deskripsi');
        $produk->save();

        return redirect('admin/produk')->with('success', 'Data Berhasil Ditambahkan');
    }
    function show($produk)
    {
        $data['produk'] = Produk::find($produk);
        return view('produk.show', $data);
    }
    function edit(Produk $produk)
    {
        $data['produk'] =  $produk;
        return view('produk.edit', $data);
    }
    function update(Produk $produk)
    {
        $produk->nama = request('nama');
        $produk->harga = request('harga');
        $produk->berat = request('berat');
        $produk->stok = request('stok');
        $produk->deskripsi = request('deskripsi');
        $produk->save();

        return redirect('admin/produk')->with('success', 'Data Berhasil Diedit');
    }
    function destroy(Produk $produk)
    {
        $produk->delete();

        return redirect('admin/produk')->with('danger', 'Data Berhasil Dihapus');
    }
    function filter()
    {
        $nama = request('nama');
        $stok = explode(",", request('stok'));
        $data['list_produk'] = produk::where('nama', 'like', "%$nama%")->get();
        $data['list_produk'] = produk::where('stok', '<>', $stok)->get();
        $data['harga_min'] = $harga_min = request('harga_min');
        $data['harga_max'] = $harga_max = request('harga_max');
        // $data['list_produk'] = Produk::whereNotBetween('harga_min',  "$harga_min")->get()
        //$data['list_produk'] = Produk::whereNotBetween('harga', [$harga_min, $harga_max])->get();
        //$data['list_produk'] = Produk::whereNotBetween('stok',  "$stok")->get();
        //$data['list_produk'] = produk::whereIn('nama', 'like', "%$nama%")->get();
        //$data['list_produk'] = Produk::whereNotIn('stok',  "$stok")->get();
        //$data['list_produk'] = produk::where('stok', $stok)->get();
        $data['list_produk'] = produk::whereDate('created_at', '2022-09-05')->get();
        $data['nama'] = $nama;
        return view('produk.index', $data);
    }
}
