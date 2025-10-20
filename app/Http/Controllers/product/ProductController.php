<?php

namespace App\Http\Controllers\product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private $products;
    public function __construct()
    {
        $this->products = [
            [
                'id' => 101,
                'name' => 'iPhone 15',
                'description' => 'Latest Apple smartphone',
                'price' => 1099.99,
                'category' => 'Electronics',
                'brand' => 'Apple',
                'in_stock' => true,
                'stock_quantity' => 25,
                'tags' => ['smartphone', 'apple', 'mobile'],
                'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTGEKk1DaaAsuqNnnM9yrZ_6OK6I7CiM1EFEg&s'
            ],
            [
                'id' => 102,
                'name' => 'Running Shoes',
                'description' => 'Professional running shoes',
                'price' => 89.99,
                'category' => 'Sports',
                'brand' => 'Nike',
                'in_stock' => true,
                'stock_quantity' => 50,
                'tags' => ['shoes', 'sports', 'running'],
                'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTGEKk1DaaAsuqNnnM9yrZ_6OK6I7CiM1EFEg&s'
            ],
            [
                'id' => 103,
                'name' => 'Programming Book',
                'description' => 'Learn PHP programming',
                'price' => 39.99,
                'category' => 'Books',
                'brand' => 'Tech Publications',
                'in_stock' => false,
                'stock_quantity' => 0,
                'tags' => ['book', 'programming', 'php'],
                'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTGEKk1DaaAsuqNnnM9yrZ_6OK6I7CiM1EFEg&s'
            ]
        ];
    }
    public function index()
    {

        return view('products.index', ['products' => $this->products, 'title' => 'Products List']);
    } //index function
    public function createView()
    {
        return view('products.create');
    } //create function
    public function show($id)
    {
        $key = array_search($id, array_column($this->products, 'id'));

        if ($key === false) {
            abort(404);
        }

        $product = $this->products[$key];

        return view('products.show', [
            'title' => $product['title'] ?? $product['name'],
            'product' => $product
        ]);
        return view('products.index');
    } //show function
}
