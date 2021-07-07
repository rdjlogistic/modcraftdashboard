<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;
use App\Category;
use App\Price;

class HomePageController extends Controller
{

    public function index()
    {
        return view('auth/login');
    }

    public function table(Request $request)
    {
        $companies = Company::filterByRequest($request)->paginate(9);

        return view('mainTable.search', compact('companies'));
    }

    public function category(Category $category)
    {
        $companies = Company::join('category_company', 'companies.id', '=', 'category_company.company_id')
            ->where('category_id', $category->id)
            ->paginate(9);

        return view('mainTable.category', compact('companies', 'category'));
    }

    public function price(Price $price)
    {
        $companies = Company::join('company_price', 'companies.id', '=', 'company_price.company_id')
            ->where('price_id', $price->id)
            ->paginate(9);

        return view('mainTable.price', compact('companies', 'price'));
    }

    public function company(Company $company)
    {
        return view('mainTable.company', compact ('company'));
    }

}