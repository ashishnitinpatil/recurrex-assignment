<?php

namespace App\Http\Controllers;

use Auth;
use Validator;
use App\Http\Requests;
use Illuminate\Http\Request;

use App\Product;
use App\Libraries\Utilities;

class ProductController extends Controller
{
    /**
     * Instantiate a new ProductController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin', ['except' => [
            'index',
            'show',
        ]]);

        $this->middleware('web', ['only' => [
            'index',
            'create',
            'edit',
        ]]);
    }

    /**
     * Get a validator for an incoming product management request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data, $unique)
    {
        $mealCourseTypes = implode(',', Product::getMealCourseTypes());
        $servingTimes = implode(',', Product::getServingTimes());

        $uniqueSKU = $unique ? '|unique:products' : '';

        return Validator::make($data, [
            'name' => 'required|max:255',
            'SKU' => 'required|max:255'.$uniqueSKU,
            'description' => 'required|max:2048',
            'price' => 'required|digits_between:1,7',
            'stock' => 'required|digits_between:1,7',
            'date' => 'date',
            'image' => 'url',
            'meal_course_type' => "required|in:$mealCourseTypes",
            'serving_time' => "required|in:$servingTimes",
        ]);
    }

    /**
     * DRY function for handling input validation
     *
     * @return $request-all() if successful validation else throws Exception
     */
    private function handleValidation($request, $unique=true)
    {
        $inputData = $request->all();
        $validator = $this->validator($inputData, $unique);

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }
        else
            return $inputData;
    }

    /**
     * DRY function for getting product instance by product id
     * Fails on not finding product by id
     * Throws 403 if product not owned by current user
     *
     * @return object \App\Product
     */
    private function getProductByID($productID)
    {
        $product = Product::findOrFail($productID);
        if (!$product->isOwner(Auth::id()))
            abort(403, 'Unauthorized - Only product owner can update / delete');
        else
            return $product;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::paginate(15);

        return view('product.index', ['products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'product' => null,
            'serving_time_options' => Utilities::makeSnakeCaseRepresentable(Product::getServingTimes()),
            'meal_course_type_options' => Utilities::makeSnakeCaseRepresentable(Product::getMealCourseTypes()),
        ];

        return view('product.create_or_edit', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inputData = $this->handleValidation($request);
        $product = Auth::user()->products()->create($inputData);

        return redirect()->route('product.show', ['id' => $product->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Product::findOrFail($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = $this->getProductByID($id);
        $data = [
            'product' => $product,
            'serving_time_options' => Utilities::makeSnakeCaseRepresentable(Product::getServingTimes()),
            'meal_course_type_options' => Utilities::makeSnakeCaseRepresentable(Product::getMealCourseTypes()),
        ];

        return view('product.create_or_edit', $data);
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
        $product = $this->getProductByID($id);
        $inputData = $this->handleValidation($request, false);
        $product->update($inputData);

        return redirect()->route('product.show', ['id' => $product->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = $this->getProductByID($id);
        $product->delete();

        return redirect()->route('product.index');
    }
}
