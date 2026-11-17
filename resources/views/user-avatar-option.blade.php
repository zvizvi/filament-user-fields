<div class="flex items-center gap-2">
    @if($user)
        <x-filament-panels::avatar.user :user="$user" size="xs" />
        <span class="text-sm font-medium">{{ filament()->getUserName($user) }}</span>
    @endif
</div>
