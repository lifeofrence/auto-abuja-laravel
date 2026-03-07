<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Business;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class BusinessController extends Controller
{
    public function index(Request $request)
    {
        Gate::authorize('manage-operations');
        $query = Business::with(['user', 'category']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('business_name', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    })
                    ->orWhereHas('category', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $businesses = $query->latest()->paginate(20)->appends($request->all());
        return view('admin.businesses.index', compact('businesses'));
    }

    public function approve($id)
    {
        Gate::authorize('manage-operations');
        $business = Business::findOrFail($id);
        $business->update(['status' => 'approved']);

        return back()->with('status', "Business '{$business->business_name}' has been approved!");
    }

    public function suspend($id)
    {
        Gate::authorize('manage-operations');
        $business = Business::findOrFail($id);
        $business->update(['status' => 'disabled']);

        return back()->with('status', "Business '{$business->business_name}' has been suspended.");
    }

    public function destroy($id)
    {
        Gate::authorize('manage-operations');
        $business = Business::findOrFail($id);
        // Note: We might want to soft delete products too, but for now we just delete the business
        $business->delete();

        return back()->with('status', "Business deleted successfully.");
    }
}
