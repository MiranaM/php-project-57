<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Label;

class LabelPolicy
{
    public function update(User $user, Label $label): bool
    {
        return true;
    }
    public function delete(User $user, Label $label): bool
    {
        return true;
    }
}
