<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Court;
use App\Models\CourtBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class CourtBookingController extends Controller
{
    public function index(Request $request)
    {
        $query = CourtBooking::query();
        
        // Filter by date range
        if ($request->has('start_date')) {
            $query->where('booking_date', '>=', $request->input('start_date'));
        }
        
        if ($request->has('end_date')) {
            $query->where('booking_date', '<=', $request->input('end_date'));
        }
        
        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->input('status'));
        }
        
        $bookings = $query->with(['user', 'court.branch'])->paginate($request->input('per_page', 15));
        
        return response()->json($bookings);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'court_id' => 'required|exists:courts,id',
            'booking_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        // Check if court is available during the requested time
        $existingBooking = CourtBooking::where('court_id', $validated['court_id'])
            ->where('booking_date', $validated['booking_date'])
            ->where(function ($query) use ($validated) {
                $query->whereBetween('start_time', [$validated['start_time'], $validated['end_time']])
                    ->orWhereBetween('end_time', [$validated['start_time'], $validated['end_time']])
                    ->orWhere(function ($query) use ($validated) {
                        $query->where('start_time', '<=', $validated['start_time'])
                            ->where('end_time', '>=', $validated['end_time']);
                    });
            })
            ->exists();

        if ($existingBooking) {
            throw ValidationException::withMessages([
                'court_id' => ['The selected court is not available during the requested time.'],
            ]);
        }

        // Get the court to calculate price
        $court = Court::findOrFail($validated['court_id']);
        
        // Calculate booking duration in hours
        $startTime = \Carbon\Carbon::createFromFormat('H:i', $validated['start_time']);
        $endTime = \Carbon\Carbon::createFromFormat('H:i', $validated['end_time']);
        $durationHours = $startTime->diffInMinutes($endTime) / 60;
        
        // Calculate price
        $pricePerHour = $court->use_branch_price ? $court->branch->price_per_hour : $court->price_per_hour;
        $totalPrice = $pricePerHour * $durationHours;

        $booking = new CourtBooking([
            'court_id' => $validated['court_id'],
            'user_id' => Auth::id(),
            'booking_date' => $validated['booking_date'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'price' => $totalPrice,
            'status' => 'pending',
        ]);

        $booking->save();
        
        return response()->json([
            'booking' => $booking,
            'message' => 'Booking created successfully. Please complete payment to confirm your booking.',
        ], 201);
    }

    public function show(CourtBooking $booking)
    {
        $booking->load(['user', 'court.branch']);
        return response()->json($booking);
    }

    public function update(Request $request, CourtBooking $booking)
    {
        // Only allow updating status for admin/manager
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled,completed',
        ]);

        $booking->update($validated);
        
        return response()->json($booking);
    }

    public function destroy(CourtBooking $booking)
    {
        // Only allow deletion if status is pending
        if ($booking->status !== 'pending') {
            return response()->json(['message' => 'Only pending bookings can be deleted.'], 422);
        }
        
        $booking->delete();
        return response()->json(null, 204);
    }

    public function byBranch(Branch $branch, Request $request)
    {
        $query = CourtBooking::whereHas('court', function ($query) use ($branch) {
            $query->where('branch_id', $branch->id);
        });
        
        // Filter by date
        if ($request->has('date')) {
            $query->where('booking_date', $request->input('date'));
        }
        
        $bookings = $query->with(['user', 'court'])->get();
        
        return response()->json($bookings);
    }

    public function byCourt(Court $court, Request $request)
    {
        $query = CourtBooking::where('court_id', $court->id);
        
        // Filter by date
        if ($request->has('date')) {
            $query->where('booking_date', $request->input('date'));
        }
        
        $bookings = $query->with(['user'])->get();
        
        return response()->json($bookings);
    }

    public function myBookings(Request $request)
    {
        $userId = Auth::id();
        
        $query = CourtBooking::where('user_id', $userId);
        
        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->input('status'));
        }
        
        // Only upcoming bookings
        if ($request->boolean('upcoming', false)) {
            $query->where(function ($query) {
                $query->where('booking_date', '>', now()->format('Y-m-d'))
                    ->orWhere(function ($query) {
                        $query->where('booking_date', '=', now()->format('Y-m-d'))
                            ->where('end_time', '>', now()->format('H:i'));
                    });
            });
        }
        
        $bookings = $query->with(['court.branch'])->orderBy('booking_date')->orderBy('start_time')->get();
        
        return response()->json($bookings);
    }
}