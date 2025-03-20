<?php

namespace App\Http\Controllers;

use App\Http\Requests\CurrencyRequest;
use App\Models\Currency;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        Gate::authorize('currency.viewAny');

        $currencies = Currency::latest()->paginate(config('setting.pagination_limit'));

        return view('backend.currencies.index', compact('currencies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): void
    {
        Gate::authorize('currency.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CurrencyRequest $request): JsonResponse
    {
        Gate::authorize('currency.create');

        Currency::create($request->validated());

        toastr()->success('Currency created successfully');

        return response()->json(['success' => true]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Currency $currency): void
    {
        Gate::authorize('currency.view');

        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Currency $currency): JsonResponse
    {
        Gate::authorize('currency.update');

        return response()->json([
            'success' => true,
            'currency' => $currency,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CurrencyRequest $request, Currency $currency): JsonResponse
    {
        Gate::authorize('currency.update');

        $currency->update($request->validated());

        toastr()->success('Currency info updated');

        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Currency $currency): JsonResponse
    {
        Gate::authorize('currency.delete');

        $currency->delete();

        return response()->json([
            'success' => true,
            'message' => __(':name deleted successfully!', ['name' => __('Currency')]),
        ]);
    }

    public function status(Request $request, Currency $currency): JsonResponse
    {
        Gate::authorize('language.update');

        $currency->update(['is_active' => $request->boolean('status')]);

        toastr()->success(__(':name updated successfully!', ['name' => __('Status')]));

        return response()->json([
            'success' => true,
        ]);
    }
}
