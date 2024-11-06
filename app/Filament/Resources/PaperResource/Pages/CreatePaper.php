<?php

namespace App\Filament\Resources\PaperResource\Pages;

use App\Filament\Resources\PaperResource;
use App\Jobs\NotifyEditorsOfNewPaper;
use App\Models\User;
use App\Notifications\PaperSubmittedNotification;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePaper extends CreateRecord
{
    protected static string $resource = PaperResource::class;

    protected function beforeFill(): void
    {
        // Automatically set the author_id to the current logged-in user
        $this->data['author_id'] = auth()->id();
    }
    protected function afterCreate(): void
    {
        // Send notification to the Editor-in-Chief after paper submission
        NotifyEditorsOfNewPaper::dispatch($this->record);
    }
}
