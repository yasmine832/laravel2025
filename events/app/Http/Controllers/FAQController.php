<?php

namespace App\Http\Controllers;

use App\Models\FAQCategory;
use App\Models\FAQItem;
use Illuminate\Http\Request;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Routing\Controller;

class FAQController extends Controller
{
    public function __construct()
    {
        $this->middleware(['admin'])->only([
            'storeCategory', 'updateCategory', 'destroyCategory',
            'storeItem', 'updateItem', 'destroyItem'
        ]);
    }

    public function index()
    {
        $categories = FAQCategory::with('faqItems')->get();
        return view('faq.index', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        FAQCategory::create($validated);
        return back()->with('success', 'Category created successfully');
    }

    public function updateCategory(Request $request, FAQCategory $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category->update($validated);
        return back()->with('success', 'Category updated successfully');
    }

    public function destroyCategory(FAQCategory $category)
    {
        $category->delete();
        return back()->with('success', 'Category deleted successfully');
    }

    public function storeItem(Request $request, FAQCategory $category)
    {
        $validated = $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
        ]);

        $category->faqItems()->create($validated);
        return back()->with('success', 'Question added successfully');
    }

    public function updateItem(Request $request, FAQItem $item)
    {
        $validated = $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
        ]);

        $item->update($validated);
        return back()->with('success', 'Question updated successfully');
    }

    public function destroyItem(FAQItem $item)
    {
        $item->delete();
        return back()->with('success', 'Question deleted successfully');
    }
}