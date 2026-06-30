<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Notities') }}
            </h2>
            <a href="{{ route('notes.create') }}"
               class="inline-flex items-center px-4 py-2 bg-gray-800 text-white text-sm font-medium rounded-md hover:bg-gray-700">
                + Nieuwe notitie
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('status') === 'note-created')
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-md">
                    Notitie aangemaakt.
                </div>
            @elseif (session('status') === 'note-updated')
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-md">
                    Notitie bijgewerkt.
                </div>
            @elseif (session('status') === 'note-deleted')
                <div class="mb-4 p-4 bg-yellow-100 text-yellow-800 rounded-md">
                    Notitie verwijderd.
                </div>
            @endif

            @forelse ($notes as $note)
                <div class="mb-4 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 flex items-start justify-between gap-4">
                        <div class="flex-1 min-w-0">
                            <h3 class="font-semibold text-gray-900 truncate">{{ $note->title }}</h3>
                            @if ($note->body)
                                <p class="mt-1 text-gray-600 text-sm whitespace-pre-wrap">{{ $note->body }}</p>
                            @endif
                            <p class="mt-2 text-xs text-gray-400">{{ $note->created_at->diffForHumans() }}</p>
                        </div>
                        <div class="flex items-center gap-2 shrink-0">
                            <a href="{{ route('notes.edit', $note) }}"
                               class="px-3 py-1 text-sm text-gray-700 border border-gray-300 rounded-md hover:bg-gray-100">
                                Bewerken
                            </a>
                            <form method="POST" action="{{ route('notes.destroy', $note) }}"
                                  onsubmit="return confirm('Notitie verwijderen?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="px-3 py-1 text-sm text-red-600 border border-red-300 rounded-md hover:bg-red-50">
                                    Verwijderen
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-500">
                        Nog geen notities. <a href="{{ route('notes.create') }}" class="underline text-gray-700">Maak er een aan.</a>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
