<?php

namespace App\Observers;

use App\Models\Testimonial;
use Illuminate\Support\Facades\Storage;

class TestimonialObserver
{
    /**
     * Handle the Testimonial "deleted" event.
     *
     * Ensures the author's image is deleted from storage when the testimonial is deleted.
     */
    public function deleted(Testimonial $testimonial): void
    {
        if (!empty($testimonial->image_path)) {
            Storage::disk('public')->delete($testimonial->image_path);
        }
    }
}
