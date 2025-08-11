<x-app-layout>
    <div class="py-4"> <!-- el alto del dashboard -->
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8"> <!-- el ancho del dashboard -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                <h1 class="text-2xl mb-4">{{ $post->title }}</h1>

                {{-- User Avatar --}}
                <div class="flex gap-4">
                    <x-user-avatar :user="$post->user" />

                    <div>
                        <x-follow-ctr :user="$post->user" class="flex gap-2">
                            <a href="{{ route('profile.show', $post->user) }}" class="hover:underline">
                                {{-- @dump($post->user) --}}
                                {{ $post->user->name }}
                            </a>
                            
                            @auth
                                &middot;
                                <button class="hover:underline"
                                x-text="following ? 'Dejar de seguir' : 'Seguir'"
                                :class="following ? 'text-red-600' : 'text-emerald-600'"
                                @click="follow()">
                                </button>
                            @endauth

                        </x-follow-ctr>


                        {{-- User Info --}}
                        <div class="flex gap-2 text-sm text-gray-500">
                            {{ $post->readTime() }} min read
                            &middot;
                            {{-- @dump($post->created_at) --}}
                            {{ $post->created_at->format('M d, Y') }}
                        </div>

                    </div>
                </div>

                {{-- Edit and Delete Buttons --}}
                @if ($post->user_id === Auth::id())
                    <div class="py-4 mt-8 border-t border-b border-gray-200">
                        <x-primary-button href="{{ route('post.edit', $post->slug) }}">
                            Editar Post
                        </x-primary-button>
                        <form class="inline block" action="{{ route('post.destroy', $post) }}" method="post">
                            @csrf
                            @method('delete')
                        </form>
                        <x-danger-button>
                            Eliminar Post
                        </x-danger-button>
                    </div>
                @endif

                {{-- Post Item Component --}}

                {{-- Clap Section --}}
                <x-clap-button :post="$post" />


                {{-- Content Section --}}
                <div class="mt-8">
                    <img src="{{ $post->imageUrl() }}" alt="{{ $post->title }}" class="w-full">

                    <div class="mt-4">
                        {{ $post->content }}
                    </div>
                </div>

                {{-- Category badge --}}
                <div class="mt-8">
                    <span class="px-4 py-2 bg-gray-200 rounded-2xl">
                        {{ $post->category->name }}
                    </span>
                </div>

                {{-- Clap Section --}}
                <x-clap-button :post="$post" />

                {{-- Comments Section --}}

            </div>
        </div>
    </div>
</x-app-layout>
