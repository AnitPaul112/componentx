<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Shoutout Box') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Success Message -->
                    @if(session('success'))
                        <div class="mb-4 text-green-500">
                            {{ session('success') }}
                        </div>
                    @endif

                    <h3 class="text-2xl font-semibold mb-4">Shoutouts:</h3>

                    <!-- Display Shoutouts -->
                    <div class="space-y-4 mb-6">
                        @foreach($shoutouts as $shoutout)
                            <div class="p-4 bg-gray-100 rounded-md">
                                <p class="font-semibold">{{ $shoutout->username }}</p>
                                <p class="text-gray-700">{{ $shoutout->message }}</p>
                                <p class="text-sm text-gray-500">{{ $shoutout->created_at->diffForHumans() }}</p>
                            </div>
                        @endforeach
                    </div>

                    <hr class="my-6">

                    <h3 class="text-2xl font-semibold mb-4">Post a Shoutout</h3>

                    <!-- Shoutout Form in a single box with Flexbox layout -->
                    <form action="{{ url('/shoutout') }}" method="POST">
                        @csrf
                        <div class="flex items-center space-x-4 p-4 border rounded-md bg-gray-100">
                            <!-- Username (Left) without box layout -->
                            <div class="w-1/2">
                                <span class="text-gray-700">{{ Auth::user()->name }}</span>
                            </div>

                            <!-- Shoutout (Middle) -->
                            <div class="flex-1 ml-4">
                                <textarea id="message" name="message" class="w-full p-2 border rounded-md" rows="4" placeholder="Write your shoutout..." required></textarea>
                            </div>

                            <!-- Post Button (Right) -->
                            <div class="flex-shrink-0">
                                <button type="submit" class="bg-blue-600 text-black px-4 py-2 rounded-md hover:bg-blue-500">Post</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
    // When the form is submitted, prevent default behavior
    $('form').submit(function(e) {
        e.preventDefault();

        // Get the form data
        var formData = $(this).serialize();

        // Send AJAX request
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: formData,
            success: function(response) {
                // On success, update the shoutouts list dynamically
                $('.space-y-4').html(response.shoutoutsHtml);
                // Optionally show success message
                alert(response.successMessage);
            }
        });
    });
</script>
