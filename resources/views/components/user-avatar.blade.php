@props(['user', 'size' => 'w-12 h-12'])

@if ($user->image)
    <img src="{{ $user->imageUrl() }}" alt="{{ $user->name }}" class="{{ $size }} rounded-full">
@else
    <img src="https://st3.depositphotos.com/9998432/13335/v/450/depositphotos_133352156-stock-illustration-default-placeholder-profile-icon.jpg"
        alt="Avatar Default" class="{{ $size }} rounded-full">
@endif
