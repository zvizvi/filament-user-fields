<div class="flex items-center gap-2">
    @if($user)
        <x-filament-panels::avatar.user :user="$user" size="sm" />
        <span class="text-sm font-medium">{{ $user->name }}</span>
    @endif
</div>
