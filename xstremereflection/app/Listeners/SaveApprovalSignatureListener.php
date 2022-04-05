<?php

namespace Vanguard\Listeners;

use Vanguard\Estimate;
use Vanguard\Events\CustomerApprovedEstimateEvent;

class SaveApprovalSignatureListener
{
    /**
     * Handle the event.
     */
    public function handle(CustomerApprovedEstimateEvent $event): void
    {
        $folderPath = public_path('customerSignature/');

        $image_parts = explode(';base64,', $event->file);

        $image_type_aux = explode('image/', $image_parts[0]);

        $image_type = $image_type_aux[1];

        $image_base64 = base64_decode($image_parts[1]);

        $fileName = uniqid() . '.' . $image_type;

        $file = $folderPath . $fileName;

        file_put_contents($file, $image_base64);

        $estimate = Estimate::find($event->estimate->id);
        $estimate->signature = '/customerSignature/' . $fileName;
        $estimate->save();
    }
}
