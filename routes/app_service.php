<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::get('/home', function () {
    return 'Present for Joe';
});

Route::post('/pending-booking/{venueId}', [\App\Http\Controllers\PendingBookingController::class, 'processPendingBooking'])->name('app.pending-booking');
Route::put('/{bookingId}/cancel', [\App\Http\Controllers\AppController\AppCancelBookingController::class, 'processCancelBooking'])->name('app.cancel-booking');
Route::put('/commit/pending-booking/{bookingId}', [\App\Http\Controllers\BookingController::class, 'processCommitPendingBooking'])->name('app.commit.pending-booking');
Route::post('/availability', [\App\Http\Controllers\BookingAvailabilityController::class, 'processBookingAvailability'])
    ->name('app.booking-availability');
Route::get('/upcoming-booking-details', [App\Http\Controllers\AppController\AppUpcomingBookingDetailsController::class, 'processUpcomingBookingDetails'])->name('app.upcoming-booking-details');
Route::get('/past-booking-details', [App\Http\Controllers\AppController\AppPastBookingDetailsController::class, 'processPastBookingDetails'])->name('app.past-booking-details');
Route::put('/amend-booking/{bookingId}', [App\Http\Controllers\AmendBookingDetailsController::class, 'processAmendBookingDetails'])->name('app.amend-booking-details');



