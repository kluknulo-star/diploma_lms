<?php

namespace App\Users\Services;

use App\Users\Models\User;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UpdateAvatarService
{
    public function updateAvatar(UploadedFile $avatar): bool
    {
        /** @var User $user */
        $user = auth()->user();

        $filename = time() . '.' . $avatar->getClientOriginalExtension();
        $path = $user->getAvatarsPath($user->id);

        Image::make($avatar)
            ->resize(300, 300)
            ->save($path . $filename);

        $user->avatar_filename = $filename;
        return $user->save();
    }
}
