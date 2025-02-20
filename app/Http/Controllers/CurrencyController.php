<?php

namespace App\Http\Controllers;

use App\Http\Requests\Currency\StoreRequest;
use App\Http\Requests\Currency\UpdateRequest;
use App\Models\Currency;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        Gate::authorize('currency.viewAny');

        $currencies = Currency::paginate(config('setting.pagination_limit'));

        return view('backend.currencies.index', compact('currencies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('currency.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        Gate::authorize('currency.create');

        Currency::create($request->validated());

        toastr()->success('Currency created successfully');

        return Redirect::route('currencies.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Currency $currency): JsonResponse
    {
        if (! request()->ajax()) {
            Gate::authorize('currency.view');
            abort(Response::HTTP_NOT_FOUND);
        }

        if (! auth()->user()->can('currency.view')) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized request',
            ], Response::HTTP_UNAUTHORIZED);
        }

        return response()->json([
            'success' => true,
            'currency' => $currency,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Currency $currency)
    {
        Gate::authorize('currency.update');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Currency $currency): RedirectResponse
    {
        abort_if(! $currency->is_created, Response::HTTP_FORBIDDEN);

        Gate::authorize('currency.update');

        $currency->update($request->validated());

        toastr()->success('Currency info updated');

        return Redirect::route('currencies.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Currency $currency)
    {
        abort_if(! $currency->is_created, Response::HTTP_FORBIDDEN);

        Gate::authorize('currency.delete');

        $currency->delete();

        return response()->json([
            'status' => true,
            'message' => __(':name deleted successfully!', ['name' => __('Currency')]),
        ]);
    }

    public function statusUpdate(Request $request, Currency $currency): JsonResponse
    {
        if (! request()->ajax()) {
            Gate::authorize('language.update');
        }

        if (! auth()->user()->can('currency.update')) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], Response::HTTP_UNAUTHORIZED);
        }

        $currency->update(['is_active' => $request->boolean('status')]);

        toastr()->success(__(':name updated successfully!', ['name' => __('Status')]));

        return response()->json([
            'status' => true,
            'message' => __(':name updated successfully!', ['name' => __('Status')]),
        ]);
    }
}
