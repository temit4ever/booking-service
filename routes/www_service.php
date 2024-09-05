<?php

declare(strict_types=1);

use App\Helpers\BookingActionHelper;
use App\Models\BookingDetails;
use App\Models\Member;
use App\Notifications\BookingConfirmationNotification;
use Carbon\Carbon;
use Fanzo\ServiceCommon\Microservice\EventMicroservice;
use Fanzo\ServiceCommon\Microservice\VenueMicroservice;
use Fanzo\ServiceCommon\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/home', function () {
    return 'Present for Joe';
});

Route::post(
    '/pending-booking/{venueId}',
    [\App\Http\Controllers\PendingBookingController::class, 'processPendingBooking']
)->name('web.pending-booking');
Route::put(
    '/{id}/{bookingId}/cancel',
    [\App\Http\Controllers\WebsiteController\WebsiteCancelBookingController::class, 'processCancelBooking']
)->name('web.cancel-booking');
Route::put(
    '/commit/pending-booking/{bookingId}',
    [\App\Http\Controllers\BookingController::class, 'processCommitPendingBooking']
)->name('web.commit.pending-booking');
Route::post(
    '/availability',
    [\App\Http\Controllers\BookingAvailabilityController::class, 'processBookingAvailability']
)->name('web.booking-availability');
Route::get(
    '/booking-details/{id}/{bookingId}',
    [\App\Http\Controllers\WebsiteController\WebsiteBookingDetailsController::class, 'processBookingDetails']
)->name('web.booking-details');
Route::put(
    '/amend-booking/{id}/{bookingId}',
    [App\Http\Controllers\AmendBookingDetailsController::class, 'processAmendBookingDetails']
)->name('web.amend-booking-details');
