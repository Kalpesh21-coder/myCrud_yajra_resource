<?php

namespace App\Http\Controllers;

use App\Models\Hero;
use Illuminate\Http\Request;
use App\DataTables\HerosDataTable;
use Illuminate\Support\Facades\File;


class HeroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(HerosDataTable $herosDataTable)
    {
        $view_type = 'listing';
        return $herosDataTable->render('heros.index', compact('view_type'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $view_type = 'add';
        return view('heros.index', compact('view_type'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required | max:20',
            'image' => 'required ',
            'price' => 'required | numeric | min:2',
        ]);



        if ($request->image != "") {

            $img = $request->image;

            $ext = $img->getClientOriginalExtension();

            $imgName = time() . '.' . $ext;

            $img->move(public_path('upload/images'), $imgName);


            Hero::create([
                'name' => $request->name,
                'image' => $imgName,
                'price' => $request->price,
            ]);
        }

        $view_type = 'listing';
        return redirect()->route('hero.index', compact('view_type'))->with('status', 'Created successfully...');
    }

    /**
     * Display the specified resource.
     */
    public function show(Hero $hero)
    {
        $view_type = 'show';
        return view('heros.index', compact('hero', 'view_type'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Hero $hero)
    {
        $view_type = 'edit';
        return view('heros.index', compact('hero', 'view_type'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Hero $hero)
    {



        if ($request->image != "") {

            $request->validate([
                'name' => 'required | max:20',
                'image' => 'required ',
                'price' => 'required | numeric | min:2',
            ]);



            File::delete(public_path('upload/images/' . $hero->image));

            $image =  $request->image;

            $ext = $image->getClientOriginalExtension();

            $imageName = time() . '.' . $ext;

            $image->move(public_path('upload/images'), $imageName);




            $hero->update([
                'name' => $request->name,
                'image' => $imageName,
                'price' => $request->price,
            ]);
        } elseif ($request->image == "") {

            $hero->update([
                'name' => $request->name,

                'price' => $request->price,
            ]);
        }



        $view_type = 'listing';
        return redirect()->route('hero.index', compact('view_type'))->with('status', 'Updated successfully...');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hero $hero)
    {
        $path = public_path('upload/images/' . $hero->image);
        $is_file_exists = File::exists($path);
        if ($is_file_exists) {
            File::delete($path);
        }
        $hero->delete();
        $view_type = 'listing';
        return redirect()->route('hero.index', compact('view_type'))->with('status', 'Deleted successfully...');
    }
}
